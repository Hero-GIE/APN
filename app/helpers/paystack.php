<?php

namespace App\Helpers;

use Exception;
use App\Traits\ResponseTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class Paystack
{
    private function stateUrl($state)
    {
        if ($state == 'live') {
            return '';
        } else {
            return 'sandbox.';
        }
    }
    
    private function initite($data, $state = 'live')
    {
        $amnt = (int) ceil($data['amount']);
        $response = Http::asForm()->withHeaders([
            'Authorization' => "Bearer " . env("PAYSTACK_SECRET_KEY", 'sk_test_c14739d17cc031127f892f5ff0ecf497e0c85b34'),
            'Content-Type' => "application/json"
        ])->post('https://api.paystack.co/transaction/initialize', [
            'email' => "edwinofosuhene31@gmail.com",
            'amount' => 12200,
            'reference' => 388458
        ])->json();
        dd($response);
        return $response;
    }

    public function initiate($data)
    {
        try {
          
            $amountInPesewas = (int) $data['amount']; 
            
            $endPoint = 'https://api.paystack.co/transaction/initialize';
            
            $postData = [
                'email' => $data['email'],
                'amount' => $amountInPesewas, 
                'currency' => $data['currency'] ?? 'GHS',
                'callback_url' => url('/donation/callback'),
                'reference' => $data['order_id'],
                'metadata' => $data['metadata'] ?? []
            ];

            Log::info('Paystack API request', [
                'url' => $endPoint, 
                'data' => $postData,
                'amount_ghs' => $amountInPesewas / 100 
            ]);

            $ch = curl_init();
            $headers = array(
                'Authorization: Bearer ' . env('PAYSTACK_SECRET_KEY'),
                'Content-Type: application/json'
            );
            
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_URL, $endPoint);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
            
            $result = curl_exec($ch);
            
            if (curl_error($ch)) {
                Log::error('cURL error: ' . curl_error($ch));
                return ['status' => false, 'message' => 'cURL error: ' . curl_error($ch)];
            }
            
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
            
            $result = json_decode($result, TRUE);
            
            Log::info('Paystack API response', ['http_code' => $httpCode, 'response' => $result]);
            
            return $result;
            
        } catch (\Exception $e) {
            Log::error('Paystack helper error: ' . $e->getMessage());
            return ['status' => false, 'message' => $e->getMessage()];
        }
    }

    private function ussdInitiate($data, $state = 'live')
    {
        $response = Http::asForm()->withHeaders([
            'Authorization' => "Bearer " . env("PAYSTACK_SECRET_KEY", 'sk_test_4bc1809fcd590182ee672518e204a0a796acd48b'),
            'Content-Type' => "application/json"
        ])->post('https://api.paystack.co/charge', [
            'email' => $data['email'],
            'amount' => $data['amount'],
            'currency' => 'GHS',
            'reference' => $data['order_id'],
            'mobile_money' => ['phone' => $data['phone'], 'provider' => $data['network']]
        ])->throw()->json();

        return $response;
    }

    public function submitOtp($ref, $otp)
    {
        $response = Http::asForm()->withHeaders([
            'Authorization' => "Bearer " . env("PAYSTACK_SECRET_KEY", 'sk_test_4bc1809fcd590182ee672518e204a0a796acd48b'),
            'Content-Type' => "application/json"
        ])->post('https://api.paystack.co/charge/submit_otp', [
            'otp' => $otp,
            'reference' => $ref,
        ])->throw()->json();

        return $response;
    }

    public function checkout($data, $state = 'live')
    {
        $initiateRes = $this->initiate($data, $state);
        Log::info('checkout', $initiateRes);
        return $initiateRes['data'];
    }

    public function verify($data)
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => "Bearer " . env('PAYSTACK_SECRET_KEY'), 
            ])->get('https://api.paystack.co/transaction/verify/' . $data)->throw()->json();
        } catch (Exception $e) {
            return ['data' => ['status' => 'error', 'gateway_response' => "Transaction not found"]];
        }
        return $response;
    }

    public function recurring($data)
    {
        $response = Http::asForm()->withHeaders([
            'Authorization' => "Bearer " . env("PAYSTACK_SECRET_KEY"),
            'Content-Type' => "application/json"
        ])->post('https://api.paystack.co/transaction/charge_authorization', [
            'authorization_code' => $data['auth'],
            'email' => $data['email'],
            'amount' => $data['amount'] 
        ])->throw()->json();

        return $response;
    }

    public function ussdCheckout($data, $state = 'live')
    {
        $initiateRes = $this->ussdInitiate($data, $state);
        return $initiateRes;
    }
}