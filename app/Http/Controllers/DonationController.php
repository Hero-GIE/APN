<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\Paystack;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Models\Donor;
use App\Models\Donation;
use App\Models\Member;
use App\Models\MemberPayment;
use Carbon\Carbon;

class DonationController extends Controller
{
    public function initialize(Request $request)
    {
        try {
                 
            Log::info('Donation/Membership initialization request received', $request->all());

            $validator = Validator::make($request->all(), [
                'amount' => 'required|numeric|min:1',
                'email' => 'required|email',
                'firstname' => 'required|string',
                'lastname' => 'required|string',
                'phone' => 'nullable|string',
                'country' => 'nullable|string',
                'city' => 'nullable|string',
                'region' => 'nullable|string',
                'membership_type' => 'nullable|in:monthly,annual', 
                'email_updates' => 'sometimes|boolean',
                'text_updates' => 'sometimes|boolean',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            $orderId = 'APN_' . time() . '_' . uniqid();
            $paystackData = [
                'email' => $request->email,
                'amount' => $request->amount,
                'order_id' => $orderId,
                'metadata' => [
                    'firstname' => $request->firstname,
                    'lastname' => $request->lastname,
                    'phone' => $request->phone ?? '',
                    'country' => $request->country ?? '',
                    'city' => $request->city ?? '',
                    'region' => $request->region ?? '',
                    'membership_type' => $request->membership_type ?? 'donation', 
                    'email_updates' => $request->boolean('email_updates', true),
                    'text_updates' => $request->boolean('text_updates', false)
                ]
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