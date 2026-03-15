<?php

namespace App\Http\Controllers;

use App\Models\Donor;
use App\Models\Donation;
use App\Models\Member;
use App\Models\MemberPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PaystackCallbackController extends Controller
{
    public function handle(Request $request)
    {
        $reference = $request->query('reference');

        if (! $reference) {
            Log::error('Paystack callback: missing reference');
            return redirect()->route('donor.login')
                ->with('error', 'Invalid payment reference. Please contact support.');
        }

        // ── 1. Verify payment with Paystack 
        $secretKey = config('services.paystack.secret_key');

        if (! $secretKey) {
            Log::error('Paystack secret key is missing from .env');
            return redirect()->route('home')
                ->with('error', 'Payment configuration error. Please contact support.');
        }

        $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $secretKey,
                'Content-Type'  => 'application/json',
            ])
            ->get("https://api.paystack.co/transaction/verify/{$reference}");

        if (! $response->successful()) {
            Log::error('Paystack API verification failed', [
                'reference'   => $reference,
                'http_status' => $response->status(),
                'body'        => $response->body(),
            ]);
            return redirect()->route('home')
                ->with('error', 'Payment verification failed. Please contact support.');
        }

        $body   = $response->json();
        $status = $body['data']['status'] ?? null;

        // ── 2. Confirm payment status is success 
        if ($status !== 'success') {
            Log::warning('Paystack payment not successful', [
                'reference' => $reference,
                'status'    => $status,
            ]);
            return redirect()->route('home')
                ->with('error', 'Payment was not completed. Please try again.');
        }

        $data = $body['data'];

        // ── 3. Prevent duplicate processing
        if (Donation::where('transaction_id', $reference)->exists()) {
            Log::info('Duplicate callback — already processed', ['reference' => $reference]);
            return redirect()->route('donor.login')
                ->with('info', 'Payment already processed. Please log in to your account.');
        }

        // ── 4. Extract details 
        $email    = $data['customer']['email'];
        $metadata = $data['metadata'] ?? [];
        $amount   = ($data['amount'] ?? 0) / 100;
        $currency = $data['currency'] ?? 'GHS';

        // ── 5. Find or create donor
        $existingDonor = Donor::where('email', $email)->first();
        $isNewDonor    = false;
        $plainPassword = null;

        if ($existingDonor) {
            $donor = $existingDonor;
            $this->updateDonorIfNeeded($donor, $metadata);

        } else {
            $plainPassword = $this->generateDefaultPassword();

            $donor = Donor::create([
                'firstname'         => $metadata['firstname']   ?? explode('@', $email)[0],
                'lastname'          => $metadata['lastname']    ?? '',
                'email'             => $email,
                'phone'             => $metadata['phone']       ?? null,
                'country'           => $metadata['country']     ?? null,
                'address'           => $metadata['address']     ?? null,
                'city'              => $metadata['city']        ?? null,
                'region'            => $metadata['region']      ?? null,
                'postcode'          => $metadata['postcode']    ?? null,
                'email_updates'     => filter_var($metadata['email_updates'] ?? true,  FILTER_VALIDATE_BOOLEAN),
                'text_updates'      => filter_var($metadata['text_updates']  ?? false, FILTER_VALIDATE_BOOLEAN),
                'password'          => Hash::make($plainPassword),
                'email_verified_at' => now(),
            ]);

            $isNewDonor = true;

            Log::info('New donor created via Paystack callback', [
                'donor_id' => $donor->id,
                'email'    => $donor->email,
            ]);
        }

        // ── 6. Save donation record
        $donation = Donation::create([
            'donor_id'          => $donor->id,
            'transaction_id'    => $reference,
            'amount'            => $amount,
            'currency'          => $currency,
            'payment_status'    => 'success',
            'payment_method'    => $data['authorization']['channel'] ?? null,
            'paystack_response' => $data,
        ]);

        // ── 7. Handle membership if applicable
        $membershipType = $metadata['membership_type'] ?? null;
        $isMembership = in_array($membershipType, ['monthly', 'annual']);
        
        if ($isMembership) {
            $this->processMembership($donor, $donation, $membershipType, $amount);
        }

       // ── 8. Send emails ──
    if (function_exists('sendEmail')) {
    if ($isNewDonor) {
        if ($isMembership) {
            $member = Member::where('donor_id', $donor->id)->first();
            
            sendEmail(
                'emails.member-welcome',
                [
                    'member' => $member, 
                    'password' => $plainPassword,
                ],
                $donor->email,
                'Welcome to APN Membership — Your Account is Ready'
            );
        } else {

            sendEmail(
                'emails.donor-welcome',
                [
                    'donor' => $donor,
                    'donation' => $donation,
                    'password' => $plainPassword,
                ],
                $donor->email,
                'Welcome to APN — Your Account is Ready'
            );
        }

        if (function_exists('messageAdmin')) {
            $type = $isMembership ? 'Member' : 'Donor';
            messageAdmin([
                'title'     => "New {$type} Account Created",
                'message'   => "A new {$type} account was created after a successful payment.",
                'user_info' => $donor->firstname . ' ' . $donor->lastname
                             . ' — ' . $donor->email
                             . ($isMembership ? " ({$membershipType} membership)" : ''),
                'time'      => now()->format('d M Y, h:i A'),
            ]);
        }
    } else {
        if ($isMembership) {
            $member = Member::where('donor_id', $donor->id)->first();
            
            sendEmail(
                'emails.member-renewal',
                [
                    'member' => $member,
                    'donation' => $donation,
                    'membership_type' => $membershipType,
                ],
                $donor->email,
                'APN Membership — Thank You for Your Renewal'
            );
        } else {
        
            sendEmail(
                'emails.donor-thankyou',
                [
                    'donor' => $donor,
                    'donation' => $donation,
                ],
                $donor->email,
                'APN — Thank You for Your Donation'
            );
        }
    }
   }

        Log::info('Payment processed via Paystack callback', [
            'donor_id'       => $donor->id,
            'donation_id'    => $donation->id,
            'transaction_id' => $reference,
            'amount'         => $amount,
            'currency'       => $currency,
            'new_donor'      => $isNewDonor,
            'is_membership'  => $isMembership,
            'membership_type' => $membershipType,
        ]);

        Auth::guard('donor')->login($donor);

        // ── 9. Redirect to appropriate success page
        if ($isMembership) {
            return redirect()->route('member.success', ['reference' => $reference])
                ->with('success', 'Membership payment successful! Welcome to APN.');
        } else {
            return redirect()->route('donation.success', ['reference' => $reference])
                ->with('success', 'Donation successful! Thank you for your support.');
        }
    }

    private function processMembership($donor, $donation, $membershipType, $amount)
    {
        $now = Carbon::now();
        
        if ($membershipType === 'annual') {
            $startDate = $now->copy();
            $endDate = $now->copy()->addYear();
        } else { 
            $startDate = $now->copy();
            $endDate = $now->copy()->addMonth();
        }

        $existingMember = Member::where('donor_id', $donor->id)
            ->where('status', 'active')
            ->first();

        if ($existingMember) {

            $existingMember->update([
                'end_date' => $existingMember->end_date->add($membershipType === 'annual' ? '1 year' : '1 month'),
                'renewal_count' => $existingMember->renewal_count + 1,
            ]);
            
            $member = $existingMember;
        } else {
            // Create new membership
            $member = Member::create([
                'donor_id' => $donor->id,
                'membership_type' => $membershipType,
                'status' => 'active',
                'start_date' => $startDate,
                'end_date' => $endDate,
                'renewal_count' => 0,
            ]);
        }

        // Record payment in member_payments
        MemberPayment::create([
            'donor_id' => $donor->id,
            'member_id' => $member->id,
            'donation_id' => $donation->id,
            'membership_type' => $membershipType,
            'amount' => $amount,
            'payment_date' => $now,
            'period_start' => $startDate,
            'period_end' => $endDate,
        ]);

        Log::info('Membership processed', [
            'donor_id' => $donor->id,
            'member_id' => $member->id,
            'type' => $membershipType,
            'end_date' => $endDate,
        ]);

        return $member;
    }

    private function updateDonorIfNeeded(Donor $donor, array $metadata): void
    {
        $updates = [];

        foreach (['phone', 'address', 'city', 'country', 'postcode', 'region'] as $field) {
            if (empty($donor->$field) && ! empty($metadata[$field])) {
                $updates[$field] = $metadata[$field];
            }
        }

        if (! empty($updates)) {
            $donor->update($updates);
            Log::info('Donor info updated from payment metadata', ['donor_id' => $donor->id]);
        }
    }

    private function generateDefaultPassword(): string
    {
        $adjectives = ['Blue', 'Gold', 'Swift', 'Bold', 'Calm', 'Bright', 'Green', 'Clear', 'Royal', 'Noble'];
        $nouns      = ['Hawk', 'River', 'Star', 'Lion', 'Peak', 'Stone', 'Leaf', 'Palm', 'Eagle', 'Crest'];

        return $adjectives[array_rand($adjectives)]
            . '#'
            . $nouns[array_rand($nouns)]
            . rand(10, 99);
    }
}