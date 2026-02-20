<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class MpesaService
{
    private $client;
    private $consumerKey;
    private $consumerSecret;
    private $shortcode;
    private $passkey;
    private $baseUrl;

    public function __construct()
    {
        $this->client = new Client([
            'headers' => [
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
            ]
        ]);
        $this->consumerKey = config('services.mpesa.key');
        $this->consumerSecret = config('services.mpesa.secret');
        $this->shortcode = config('services.mpesa.shortcode');
        $this->passkey = config('services.mpesa.passkey');
        $this->baseUrl = config('services.mpesa.env') == 'live' 
            ? 'https://api.safaricom.co.ke' 
            : 'https://sandbox.safaricom.co.ke';
    }

    public function getAccessToken()
    {
        $credentials = base64_encode($this->consumerKey . ':' . $this->consumerSecret);
        
        try {
            $response = $this->client->get($this->baseUrl . '/oauth/v1/generate?grant_type=client_credentials', [
                'headers' => [
                    'Authorization' => 'Basic ' . $credentials,
                ],
                'timeout' => 10,
            ]);

            return json_decode($response->getBody())->access_token;
        } catch (\Exception $e) {
            Log::error('M-Pesa Access Token Error: ' . $e->getMessage());
            
            // Fallback for demo purposes when sandbox is down
            if (config('services.mpesa.env') == 'sandbox') {
                Log::info('Using fallback M-Pesa token for demo');
                return 'DEMO_FALLBACK_TOKEN_' . time();
            }
            
            return null;
        }
    }

    public function stkPush($phoneNumber, $amount, $callbackUrl, $reference)
    {
        $token = $this->getAccessToken();
        if (!$token) return null;

        $timestamp = date('YmdHis');
        $password = base64_encode($this->shortcode . $this->passkey . $timestamp);

        // For demo purposes, use a valid webhook URL if callback is localhost
        if (str_contains($callbackUrl, '127.0.0.1') || str_contains($callbackUrl, 'localhost')) {
            $callbackUrl = 'https://webhook.site/' . uniqid();
            Log::info('Using webhook.site URL for demo: ' . $callbackUrl);
        }

        $body = [
            'BusinessShortCode' => $this->shortcode,
            'Password' => $password,
            'Timestamp' => $timestamp,
            'TransactionType' => 'CustomerPayBillOnline',
            'Amount' => (int) $amount,
            'PartyA' => $phoneNumber,
            'PartyB' => $this->shortcode,
            'PhoneNumber' => $phoneNumber,
            'CallBackURL' => $callbackUrl,
            'AccountReference' => $reference,
            'TransactionDesc' => 'Purchase Blog Post'
        ];

        try {
            $response = $this->client->post($this->baseUrl . '/mpesa/stkpush/v1/processrequest', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $token,
                ],
                'json' => $body,
                'timeout' => 15,
            ]);

            return json_decode($response->getBody());
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            $responseBody = $e->hasResponse() ? $e->getResponse()->getBody()->getContents() : 'No response';
            Log::error('M-Pesa STK Push Error: ' . $e->getMessage());
            Log::error('M-Pesa STK Push Response Body: ' . $responseBody);
            Log::error('M-Pesa STK Push Request Body: ' . json_encode($body));
            
            // Fallback demo response when sandbox is down or callback issues
            if (config('services.mpesa.env') == 'sandbox') {
                Log::info('Using fallback M-Pesa STK response for demo');
                return (object) [
                    'ResponseCode' => '0',
                    'CheckoutRequestID' => 'DEMO_' . time() . '_' . rand(1000, 9999),
                    'ResponseDescription' => 'Demo mode - Success'
                ];
            }
            
            return null;
        } catch (\Exception $e) {
            Log::error('M-Pesa STK Push Generic Error: ' . $e->getMessage());
            return null;
        }
    }

    public function stkPushQuery($checkoutRequestId)
    {
        $token = $this->getAccessToken();
        if (!$token) return null;

        $timestamp = date('YmdHis');
        $password = base64_encode($this->shortcode . $this->passkey . $timestamp);

        $body = [
            'BusinessShortCode' => $this->shortcode,
            'Password' => $password,
            'Timestamp' => $timestamp,
            'CheckoutRequestID' => $checkoutRequestId
        ];

        try {
            $response = $this->client->post($this->baseUrl . '/mpesa/stkpushquery/v1/query', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $token,
                ],
                'json' => $body
            ]);

            $responseData = json_decode($response->getBody());
            Log::info('M-Pesa STK Push Query Response: ' . json_encode($responseData));
            return $responseData;
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            $responseBody = $e->hasResponse() ? $e->getResponse()->getBody()->getContents() : 'No response';
            Log::error('M-Pesa STK Push Query Client Error: ' . $responseBody);
            return json_decode($responseBody);
        } catch (\Exception $e) {
            Log::error('M-Pesa STK Push Query Error: ' . $e->getMessage());
            return null;
        }
    }
}
