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
        $amount   = ($data['amount'] ?? 0) / 100; // Amount in USD (converted from GHS if applicable)
        $currency = $data['currency'] ?? 'USD';

        // ── 4. Determine payment type
        $membershipType = $metadata['membership_type'] ?? null;
        $isMembership = in_array($membershipType, ['monthly', 'annual']);
        $isDonation = !$isMembership; 

        Log::info('Payment callback received', [
            'reference' => $reference,
            'email' => $email,
            'amount' => $amount,
            'currency' => $currency,
            'membership_type' => $membershipType,
            'is_membership' => $isMembership
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
            // Check if donation already exists
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

        if ($existingDonor) {
            $donor = $existingDonor;
            $this->updateDonorIfNeeded($donor, $metadata);
            
            $hadMembershipBefore = Member::where('donor_id', $donor->id)->exists();
            
            Log::info('Existing donor found', [
                'donor_id' => $donor->id,
                'email' => $donor->email
            ]);

        } else {
            $plainPassword = $this->generateDefaultPassword();

            // Get values from metadata with fallbacks
            $firstname = $metadata['firstname'] ?? '';
            $lastname = $metadata['lastname'] ?? '';
            
            // If firstname or lastname are empty, use parts from email
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
                'amount' => $amount
            ]);

            // Create donor WITHOUT email_verified_at (it's not in fillable)
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

            // Set email_verified_at separately (not mass assignable)
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

        $existingMember = Member::where('donor_id', $donor->id)->first();
        $isExistingMember = $existingMember && $existingMember->status == 'active';

        // ── 7. Handle payment based on type
        $member = null;
        $donation = null;

        if ($isMembership) {
            // Process membership payment
            $member = $this->processMembership($donor, $reference, $data, $metadata, $membershipType, $amount);
            
            Log::info('Membership payment processed', [
                'donor_id' => $donor->id,
                'member_id' => $member->id,
                'transaction_id' => $reference,
                'amount' => $amount,
                'membership_type' => $membershipType,
                'is_existing_member' => $isExistingMember
            ]);
        }
        
        if ($isDonation) {
            // Process donation with reason
            $donationReason = $metadata['donation_reason'] ?? null;
            $customReason = $metadata['custom_reason'] ?? null;
            
            $donation = Donation::create([
                'donor_id'          => $donor->id,
                'transaction_id'    => $reference,
                'amount'            => $amount,
                'currency'          => $currency,
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
                'amount' => $amount,
                'donation_reason' => $donationReason,
                'custom_reason' => $customReason,
                'donor_is_member' => $isExistingMember
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
                        'donation' => $donation,
                        'membership_type' => $membershipType,
                        'donor' => $donor,
                    ],
                    $donor->email,
                    'APN Membership — Thank You for Your Renewal'
                );
                
                Log::info('✅ Member renewal email sent', [
                    'donor_id' => $donor->id,
                    'email' => $donor->email
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
                         . ($isMembership ? " ({$membershipType} membership - $" . $amount . ")" : " (Donation - $" . $amount . ")"),
                'time'      => now()->format('d M Y, h:i A'),
            ]);
        }

        Auth::guard('donor')->login($donor);

        // ── 10. Redirect to appropriate success page
        if ($isMembership) {
            return redirect()->route('member.success', ['reference' => $reference])
                ->with('success', 'Membership payment successful! Welcome to APN!');
        } else {
            return redirect()->route('donation.success', ['reference' => $reference])
                ->with('success', 'Donation successful! Thank you for your support!');
        }
    }

   private function processMembership($donor, $reference, $data, $metadata, $membershipType, $amount)
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

    $isRenewal = false;
    $oldEndDate = null;

    if ($existingMember) {
        // This is a RENEWAL
        $isRenewal = true;
        $oldEndDate = $existingMember->end_date;
        
        // Extend the end date
        $existingMember->update([
            'end_date' => $membershipType === 'annual' 
                ? $existingMember->end_date->addYear() 
                : $existingMember->end_date->addMonth(),
            'renewal_count' => $existingMember->renewal_count + 1,
            'status' => 'active',
        ]);
        
        $member = $existingMember;
        
        Log::info('Membership renewed', [
            'donor_id' => $donor->id,
            'member_id' => $member->id,
            'old_end_date' => $oldEndDate,
            'new_end_date' => $member->end_date,
            'renewal_count' => $member->renewal_count
        ]);
    } else {
        // New membership
        $member = Member::create([
            'donor_id' => $donor->id,
            'membership_type' => $membershipType,
            'status' => 'active',
            'start_date' => $startDate,
            'end_date' => $endDate,
            'renewal_count' => 0,
        ]);
        
        Log::info('New membership created', [
            'donor_id' => $donor->id,
            'member_id' => $member->id,
            'membership_type' => $membershipType,
            'start_date' => $startDate,
            'end_date' => $endDate
        ]);
    }
    
    // Record membership payment
    $payment = MemberPayment::create([
        'donor_id' => $donor->id,
        'member_id' => $member->id,
        'transaction_id' => $reference,
        'membership_type' => $membershipType,
        'amount' => $amount,
        'currency' => $data['currency'] ?? 'USD',
        'payment_method' => $data['authorization']['channel'] ?? 'card',
        'payment_status' => 'success',
        'paystack_response' => $data,
        'payment_date' => $now,
        'period_start' => $member->start_date,
        'period_end' => $member->end_date,
    ]);

    // Send renewal email if this is a renewal
    if ($isRenewal && function_exists('sendEmail')) {
        sendEmail(
            'emails.membership-renewal',
            [
                'donor' => $donor,
                'member' => $member,
                'payment' => $payment,
                'old_end_date' => $oldEndDate
            ],
            $donor->email,
            'Your APN Membership Has Been Renewed'
        );
        
        Log::info('Membership renewal email sent', [
            'donor_id' => $donor->id,
            'email' => $donor->email
        ]);
    }

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