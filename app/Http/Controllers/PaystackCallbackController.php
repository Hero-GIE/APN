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

        // ── 3. Extract details 
        $email    = $data['customer']['email'];
        $metadata = $data['metadata'] ?? [];
        $amountGHS = ($data['amount'] ?? 0) / 100; 
        $currency = $data['currency'] ?? 'GHS';

        // ── 4. Determine payment type
        $membershipType = $metadata['membership_type'] ?? null;
        $isMembership = in_array($membershipType, ['monthly', 'annual']);
        $isDonation = !$isMembership; 

        // IMPORTANT: Get USD amount from metadata (this is the correct 100 or 10)
        $usdAmount = (float)($metadata['original_amount_usd'] ?? 0);

        // If for some reason metadata doesn't have it, calculate based on membership type
        if ($usdAmount <= 0 && $isMembership) {
            $usdAmount = $membershipType === 'annual' ? 100 : 10;
        }

        Log::info('Payment callback received', [
            'reference' => $reference,
            'email' => $email,
            'amountGHS' => $amountGHS,
            'usdAmount' => $usdAmount,
            'currency' => $currency,
            'membership_type' => $membershipType,
            'is_membership' => $isMembership,
            'metadata_original_amount_usd' => $metadata['original_amount_usd'] ?? 'NOT_SET'
        ]);

        // ── 5. Prevent duplicate processing
        if ($isMembership) {
            if (MemberPayment::where('transaction_id', $reference)->exists()) {
                Log::info('Duplicate membership callback — already processed', ['reference' => $reference]);
                
                $donor = Donor::where('email', $email)->first();
                if ($donor) {
                    Auth::guard('donor')->login($donor);
                    return redirect()->route('member.dashboard')
                        ->with('info', 'Payment already processed. Welcome back!');
                }
                
                return redirect()->route('donor.login')
                    ->with('info', 'Payment already processed. Please log in to your account.');
            }
        }
        
        if ($isDonation) {
            if (Donation::where('transaction_id', $reference)->exists()) {
                Log::info('Duplicate donation callback — already processed', ['reference' => $reference]);
                
                $donor = Donor::where('email', $email)->first();
                if ($donor) {
                    Auth::guard('donor')->login($donor);
                    return redirect()->route('donor.dashboard')
                        ->with('info', 'Payment already processed. Thank you for your support!');
                }
                
                return redirect()->route('donor.login')
                    ->with('info', 'Payment already processed. Please log in to your account.');
            }
        }

        // ── 6. Find or create donor
        $existingDonor = Donor::where('email', $email)->first();
        $isNewDonor    = false;
        $plainPassword = null;
        $hadMembershipBefore = false;

        if ($existingDonor) {
            $donor = $existingDonor;
            $this->updateDonorIfNeeded($donor, $metadata);
            
            // Check if donor had a membership before (active or expired) for the same type
            $hadMembershipBefore = Member::where('donor_id', $donor->id)
                ->where('membership_type', $membershipType)
                ->exists();
            
            Log::info('Existing donor found', [
                'donor_id' => $donor->id,
                'email' => $donor->email,
                'had_membership_before' => $hadMembershipBefore
            ]);
        } else {
            $plainPassword = $this->generateDefaultPassword();

            $firstname = $metadata['firstname'] ?? '';
            $lastname = $metadata['lastname'] ?? '';
            
            if (empty($firstname)) {
                $firstname = explode('@', $email)[0];
            }
            if (empty($lastname)) {
                $lastname = 'Member';
            }
            
            Log::info('Creating new donor', [
                'email' => $email,
                'firstname' => $firstname,
                'lastname' => $lastname,
                'membership_type' => $membershipType,
                'usdAmount' => $usdAmount
            ]);

            $donor = Donor::create([
                'firstname'         => $firstname,
                'lastname'          => $lastname,
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
            ]);

            $donor->email_verified_at = now();
            $donor->save();

            $isNewDonor = true;
            $hadMembershipBefore = false;

            Log::info('✅ New donor created via Paystack callback', [
                'donor_id' => $donor->id,
                'email'    => $donor->email,
                'has_password' => !is_null($plainPassword)
            ]);
        }

        // ── 7. Handle payment based on type
        $member = null;
        $donation = null;
        $payment = null;
        $isRenewalProcessed = false;

        if ($isMembership) {
            // Process membership payment - pass USD amount
            $result = $this->processMembership($donor, $reference, $data, $metadata, $membershipType, $usdAmount);
            $member = $result['member'];
            $payment = $result['payment'];
            $isRenewalProcessed = $result['is_renewal'];
            
            Log::info('Membership payment processed', [
                'donor_id' => $donor->id,
                'member_id' => $member->id,
                'payment_id' => $payment->id,
                'transaction_id' => $reference,
                'usdAmount' => $usdAmount,
                'is_renewal' => $isRenewalProcessed,
                'renewal_count' => $member->renewal_count
            ]);
        }
        
        if ($isDonation) {
            $donationReason = $metadata['donation_reason'] ?? null;
            $customReason = $metadata['custom_reason'] ?? null;
            
            $donation = Donation::create([
                'donor_id'          => $donor->id,
                'transaction_id'    => $reference,
                'amount'            => $usdAmount,
                'currency'          => 'USD',
                'payment_status'    => 'success',
                'payment_method'    => $data['authorization']['channel'] ?? 'card',
                'paystack_response' => $data,
                'donation_reason'   => $donationReason,
                'custom_reason'     => $customReason,
            ]);
            
            Log::info('Donation processed', [
                'donor_id' => $donor->id,
                'donation_id' => $donation->id,
                'transaction_id' => $reference,
                'amount' => $usdAmount,
                'donation_reason' => $donationReason
            ]);
        }

        // ── 8. Send emails ──
        if (function_exists('sendEmail')) {
            // CASE 1: Brand new donor + membership = member-welcome
            if ($isNewDonor && $isMembership) {
                sendEmail(
                    'emails.member-welcome',
                    [
                        'member' => $member,
                        'membership' => $member,
                        'password' => $plainPassword,
                        'donor' => $donor,
                    ],
                    $donor->email,
                    'Welcome to APN Membership — Your Account is Ready'
                );
                
                Log::info('✅ New member welcome email sent', [
                    'donor_id' => $donor->id,
                    'email' => $donor->email
                ]);
            }
            
            // CASE 2: Brand new donor + donation = donor-welcome
            elseif ($isNewDonor && !$isMembership) {
                sendEmail(
                    'emails.donor-welcome',
                    [
                        'donor' => $donor,
                        'donation' => $donation,
                        'password' => $plainPassword,
                    ],
                    $donor->email,
                    'Welcome to APN — Thank You for Your Donation'
                );
                
                Log::info('✅ New donor welcome email sent', [
                    'donor_id' => $donor->id,
                    'email' => $donor->email
                ]);
            }
            
            // CASE 3: Existing donor + membership (first time becoming member)
            elseif (!$isNewDonor && $isMembership && !$hadMembershipBefore) {
                sendEmail(
                    'emails.member-welcome',
                    [
                        'member' => $member,
                        'membership' => $member,
                        'password' => null,
                        'donor' => $donor,
                    ],
                    $donor->email,
                    'Welcome to APN Membership — You\'re Now a Member!'
                );
                
                Log::info('✅ Existing donor became member - welcome email sent', [
                    'donor_id' => $donor->id,
                    'email' => $donor->email
                ]);
            }
            
            // CASE 4: Existing member renewing = member-renewal
            elseif (!$isNewDonor && $isMembership && $hadMembershipBefore) {
                sendEmail(
                    'emails.member-renewal',
                    [
                        'member' => $member,
                        'payment' => $payment,
                        'donor' => $donor,
                    ],
                    $donor->email,
                    'APN Membership — Thank You for Your Renewal'
                );
                
                Log::info('✅ Member renewal email sent', [
                    'donor_id' => $donor->id,
                    'email' => $donor->email,
                    'payment_id' => $payment->id ?? null,
                    'amount' => $payment->amount ?? 0
                ]);
            }
            
            // CASE 5: Existing donor making another donation
            elseif (!$isNewDonor && !$isMembership) {
                sendEmail(
                    'emails.donor-thankyou',
                    [
                        'donor' => $donor,
                        'donation' => $donation,
                    ],
                    $donor->email,
                    'APN — Thank You for Your Donation'
                );
                
                Log::info('✅ Donor thank you email sent', [
                    'donor_id' => $donor->id,
                    'email' => $donor->email
                ]);
            }
        } else {
            Log::warning('⚠️ sendEmail function not available - emails not sent', [
                'donor_id' => $donor->id,
                'email' => $donor->email
            ]);
        }

        // ── 9. Admin notification (optional)
        if (function_exists('messageAdmin') && $isNewDonor) {
            $type = $isMembership ? 'Member' : 'Donor';
            messageAdmin([
                'title'     => "New {$type} Account Created",
                'message'   => "A new {$type} account was created after a successful payment.",
                'user_info' => $donor->firstname . ' ' . $donor->lastname
                             . ' — ' . $donor->email
                         . ($isMembership ? " ({$membershipType} membership - $" . $usdAmount . ")" : " (Donation - $" . $usdAmount . ")"),
                'time'      => now()->format('d M Y, h:i A'),
            ]);
        }

        Auth::guard('donor')->login($donor);

        // ── 10. Redirect to appropriate success page
        if ($isMembership) {
            return redirect()->route('member.success', [
                'reference' => $reference,
                'is_renewal' => $isRenewalProcessed ? 'true' : 'false'
            ])->with('success', $isRenewalProcessed ? 'Membership renewed successfully!' : 'Membership payment successful! Welcome to APN!');
        } else {
            return redirect()->route('donation.success', ['reference' => $reference])
                ->with('success', 'Donation successful! Thank you for your support!');
        }
    }

   private function processMembership($donor, $reference, $data, $metadata, $membershipType, $usdAmount)
{
    $now = Carbon::now();
    
    // Look for existing membership of the SAME type for renewal
    $existingMember = Member::where('donor_id', $donor->id)
        ->where('membership_type', $membershipType)
        ->orderBy('created_at', 'desc')
        ->first();
    
    $isRenewal = false;
    $member    = null;
    $payment   = null;
    
    if ($existingMember) {
        // Same membership type - RENEWAL
        $isRenewal = true;
        $oldEndDate = $existingMember->end_date;
        $oldStatus = $existingMember->status;
        
        // Calculate new end date
        if ($membershipType === 'annual') {
            if ($existingMember->end_date && $existingMember->end_date->isFuture()) {
                $newEndDate = $existingMember->end_date->copy()->addYear();
            } else {
                $newEndDate = $now->copy()->addYear();
            }
        } else {
            if ($existingMember->end_date && $existingMember->end_date->isFuture()) {
                $newEndDate = $existingMember->end_date->copy()->addMonth();
            } else {
                $newEndDate = $now->copy()->addMonth();
            }
        }
        
        $existingMember->update([
            'end_date'      => $newEndDate,
            'renewal_count' => $existingMember->renewal_count + 1,
            'status'        => 'active',
            'start_date'    => $existingMember->start_date ?: $now,
        ]);
        
        $existingMember->refresh();
        $member = $existingMember;
        
        Log::info('Membership renewed - status updated', [
            'donor_id'      => $donor->id,
            'member_id'     => $member->id,
            'old_status'    => $oldStatus,
            'new_status'    => $member->status,
            'old_end_date'  => $oldEndDate,
            'new_end_date'  => $member->end_date,
            'renewal_count' => $member->renewal_count,
        ]);
    } else {
        // Check if donor has ANY other membership type (switching plans)
        $anyExistingMember = Member::where('donor_id', $donor->id)
            ->orderBy('created_at', 'desc')
            ->first();
        
        if ($anyExistingMember) {
            // User is switching from one plan type to another
            Log::info('Member switching membership type (not a renewal)', [
                'donor_id' => $donor->id,
                'old_type' => $anyExistingMember->membership_type,
                'new_type' => $membershipType,
                'old_status' => $anyExistingMember->status,
            ]);
        }
        
        // Create NEW membership for different type
        $startDate = $now->copy();
        $endDate   = $membershipType === 'annual'
            ? $now->copy()->addYear()
            : $now->copy()->addMonth();
        
        $member = Member::create([
            'donor_id'        => $donor->id,
            'membership_type' => $membershipType,
            'status'          => 'active',
            'start_date'      => $startDate,
            'end_date'        => $endDate,
            'renewal_count'   => 0,
        ]);
        
        Log::info('New membership created (different plan type)', [
            'donor_id'        => $donor->id,
            'member_id'       => $member->id,
            'membership_type' => $membershipType,
        ]);
    }
    
    // Create payment record
    $payment = MemberPayment::create([
        'donor_id'          => $donor->id,
        'member_id'         => $member->id,
        'transaction_id'    => $reference,
        'membership_type'   => $membershipType,
        'amount'            => $usdAmount,
        'currency'          => 'USD',
        'payment_method'    => $data['authorization']['channel'] ?? 'card',
        'payment_status'    => 'success',
        'paystack_response' => $data,
        'payment_date'      => $now,
        'period_start'      => $member->start_date,
        'period_end'        => $member->end_date,
    ]);
    
    return [
        'member' => $member,
        'payment' => $payment,
        'is_renewal' => $isRenewal
    ];
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