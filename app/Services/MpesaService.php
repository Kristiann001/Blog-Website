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
        $this->client = new Client();
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
                ]
            ]);

            return json_decode($response->getBody())->access_token;
        } catch (\Exception $e) {
            Log::error('M-Pesa Access Token Error: ' . $e->getMessage());
            return null;
        }
    }

    public function stkPush($phoneNumber, $amount, $callbackUrl, $reference)
    {
        $token = $this->getAccessToken();
        if (!$token) return null;

        $timestamp = date('YmdHis');
        $password = base64_encode($this->shortcode . $this->passkey . $timestamp);

        $body = [
            'BusinessShortCode' => $this->shortcode,
            'Password' => $password,
            'Timestamp' => $timestamp,
            'TransactionType' => 'CustomerPayBillOnline',
            'Amount' => $amount,
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
                'json' => $body
            ]);

            return json_decode($response->getBody());
        } catch (\Exception $e) {
            Log::error('M-Pesa STK Push Error: ' . $e->getMessage());
            return null;
        }
    }
}
