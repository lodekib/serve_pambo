<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MpesaController extends Controller
{

    private  function getPassword($timestamp)
    {
//        TODO Hello Brian ...Remember to check the PASSKEY in env file
        return base64_encode(env('BUSINESS_SHORTCODE').env('PASSKEY').$timestamp);
    }

    public function accessToken(){
        $url = env('MPESA_ENV') == 0
            ? 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials'
            : 'https://api.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';

        $curl = curl_init($url);
        curl_setopt_array(
            $curl,
            array(
                CURLOPT_HTTPHEADER => ['Content-Type: application/json; charset=utf8'],
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HEADER => false,
                CURLOPT_USERPWD => env('CONSUMER_KEY') . ':' . env('CONSUMER_SECRET')
            )
        );
        $response = json_decode(curl_exec($curl));
        curl_close($curl);

        return $response->access_token;
    }


    public function httpHelper($url,$body){
        $url = 'https://sandbox.safaricom.co.ke/mpesa/' . $url;
        $curl = curl_init();
        curl_setopt_array(
            $curl,
            array(
                CURLOPT_URL => $url,
                CURLOPT_HTTPHEADER => array(
                    'Content-Type:application/json',
                    'Authorization:Bearer '. $this->accessToken()),
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => json_encode($body)
            )
        );
        $curl_response = curl_exec($curl);
        curl_close($curl);
        return $curl_response;

    }

    public function  stkPush($amount, $phone){
        $timestamp = date('YmdHis');
        $password = $this->getPassword($timestamp);
        $url ='/stkpush/v1/processrequest';
        $data =array(
            'BusinessShortCode' => env('BUSINESS_SHORTCODE'),
            'Password' => $password,
            'Timestamp' => $timestamp,
            'TransactionType' => 'CustomerPayBillOnline',
            'Amount' => $amount,
            'PartyA' => $phone,
            'PartyB' => env('BUSINESS_SHORTCODE'),
            'PhoneNumber' => $phone,
            'CallBackURL' => env('TEST_URL'). '/api/pambo_v1/confirmation',
            'AccountReference' => 'Pambo Services',
            'TransactionDesc' => 'Pambo Service Promotion'
        );

        return  $this->httpHelper($url,$data);

    }


    public function registerURLS()
    {
        $url = '/c2b/v1/registerurl';
        $body = [
            'ShortCode' => env('BUSINESS_SHORTCODE'),
            'ResponseType' => 'Completed',
            'ConfirmationURL' => env('TEST_URL').'/api/pambo_v1/confirmation',
            'ValidationURL' => env('TEST_URL').'/api/pambo_v1/validation'
        ];


        return response()->json($this->httpHelper($url, $body));
    }
}
