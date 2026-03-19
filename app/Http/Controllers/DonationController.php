<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\Paystack;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\Donor;
use App\Models\Donation;
use App\Models\Member;
use App\Models\MemberPayment;
use Carbon\Carbon;

class DonationController extends Controller
{
    private const USD_TO_GHS_RATE = 10.89;
    
    public function initialize(Request $request)
    {
        try {
  
            $authenticatedDonor = Auth::guard('donor')->user();
            
            $rules = [
                'amount' => 'required|numeric|min:1',
            ];

            if (!$authenticatedDonor) {
                $rules['email'] = 'required|email|unique:donors,email';
                $rules['firstname'] = 'required|string';
                $rules['lastname'] = 'required|string';
                $rules['phone'] = 'nullable|string';
                $rules['country'] = 'nullable|string';
                $rules['city'] = 'nullable|string';
                $rules['region'] = 'nullable|string';
                $rules['email_updates'] = 'sometimes|boolean';
                $rules['text_updates'] = 'sometimes|boolean';
            }

            if ($request->has('membership_type') && $request->membership_type !== 'donation') {
                $rules['membership_type'] = 'required|in:monthly,annual';
            }

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                Log::warning('Donation validation failed', [
                    'errors' => $validator->errors()->toArray(),
                    'input' => $request->except(['_token']),
                    'is_authenticated' => !is_null($authenticatedDonor)
                ]);
                
                return response()->json([
                    'status' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            $isMembership = in_array($request->membership_type, ['monthly', 'annual']);
            
            $orderId = 'APN_' . time() . '_' . uniqid();
            
            $amountInGHS = round($request->amount * self::USD_TO_GHS_RATE, 2);
            $amountInPesewas = (int) ($amountInGHS * 100);
            
            Log::info('Amount conversion', [
                'usd_amount' => $request->amount,
                'exchange_rate' => self::USD_TO_GHS_RATE,
                'ghs_amount' => $amountInGHS,
                'pesewas' => $amountInPesewas,
                'membership_type' => $request->membership_type,
                'is_authenticated' => !is_null($authenticatedDonor)
            ]);

            $metadata = [];

            if ($authenticatedDonor) {
                $metadata = [
                    'firstname' => $authenticatedDonor->firstname,
                    'lastname' => $authenticatedDonor->lastname,
                    'phone' => $authenticatedDonor->phone ?? '',
                    'country' => $authenticatedDonor->country ?? '',
                    'city' => $authenticatedDonor->city ?? '',
                    'region' => $authenticatedDonor->region ?? '',
                    'membership_type' => $isMembership ? $request->membership_type : 'donation',
                    'is_membership' => $isMembership,
                    'original_amount_usd' => $request->amount,
                    'original_amount_ghs' => $amountInGHS,
                    'exchange_rate' => self::USD_TO_GHS_RATE,
                    'donor_id' => $authenticatedDonor->id,
                    'email_updates' => $authenticatedDonor->email_updates,
                    'text_updates' => $authenticatedDonor->text_updates,
                    'is_authenticated' => true,
                    // Add donation reason to metadata
                    'donation_reason' => $request->donation_reason,
                    'custom_reason' => $request->custom_reason
                ];

                $email = $authenticatedDonor->email;
            } else {
                $metadata = [
                    'firstname' => $request->firstname,
                    'lastname' => $request->lastname,
                    'phone' => $request->phone ?? '',
                    'country' => $request->country ?? '',
                    'city' => $request->city ?? '',
                    'region' => $request->region ?? '',
                    'membership_type' => $isMembership ? $request->membership_type : 'donation',
                    'is_membership' => $isMembership,
                    'original_amount_usd' => $request->amount,
                    'original_amount_ghs' => $amountInGHS,
                    'exchange_rate' => self::USD_TO_GHS_RATE,
                    'email_updates' => $request->boolean('email_updates', true),
                    'text_updates' => $request->boolean('text_updates', false),
                    'is_authenticated' => false,
                    'donation_reason' => $request->donation_reason,
                    'custom_reason' => $request->custom_reason
                ];

                $email = $request->email;
            }
            
            $paystackData = [
                'email' => $email,
                'amount' => $amountInPesewas, 
                'currency' => 'GHS', 
                'order_id' => $orderId,
                'metadata' => $metadata,
                'callback_url' => route('paystack.callback')
            ];
            
            $paystack = new Paystack();
            $response = $paystack->initiate($paystackData);

            if ($response && isset($response['status']) && $response['status'] === true) {
                return response()->json([
                    'status' => true,
                    'data' => $response['data']
                ]);
            } else {
                $message = $response['message'] ?? 'Payment initialization failed';
                return response()->json([
                    'status' => false,
                    'message' => $message
                ], 400);
            }

        } catch (\Exception $e) {
            Log::error('Donation/Membership initialization error: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            
            return response()->json([
                'status' => false,
                'message' => 'Failed to initialize payment: ' . $e->getMessage()
            ], 500);
        }
    }
}