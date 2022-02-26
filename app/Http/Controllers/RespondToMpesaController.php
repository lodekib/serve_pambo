<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class RespondToMpesaController extends Controller
{
    public function  validation(Request $request){
        Log::info($request->all());

        return [
            'ResultCode' => 0,
            'ResultDesc' => 'Accept Service',
            'ThirdPartyTransID' => 'Validated by Brooksys '.rand(3000, 10000000)
        ];
    }

    public function confirmation(Request $request){
        $response = json_decode($request->getContent());
        Storage::disk('public')->put('mpesaTransactions/transactions.json',$response);
//        TODO :Hello Brian ..Read the incoming request and get the ResultCode.
//        TODO :if the ResultCode is 0 then get the MerchantRequestID,CheckoutRequestID,Inside CallBackMetaData
//       TODO: get the Amount,MpesaReceiptNumber,TransactionDate and store them to db
        $result_code = $response->Body->stkCallback->ResultCode;

        if($result_code == 0){
            Log::info(serialize($response));
            $metaData = $response->Body->stkCallback->CallbackMetadata;
            $amount = $metaData->Item[0]->Value;
            $merchant_request_id = $response->Body->stkCallback->MerchantRequestID;
            $checkout_request_id =$response->Body->stkCallback->CheckoutRequestID;
            $receipt_number =$metaData->Item[1]->Value;
            $transaction_date = $metaData->Item[2]->Value;
            $phoneNumber = $metaData->Item[3]->Value;

            $transaction = new Transaction();

            $transaction->result_code =$result_code;
            $transaction->merchant_request_id = $merchant_request_id;
            $transaction->checkout_request_id =$checkout_request_id;
            $transaction->amount =$amount;
            $transaction->receipt_number = $receipt_number;
            $transaction->transaction_date = $transaction_date;
            $transaction->phone =$phoneNumber;
            $transaction->save();
        }else{
            Log::info('The response recieved is '.serialize($response));
        }


        return [
            'ResultCode' => 0,
            'ResultDesc' => 'Accept Service',
            'ThirdPartyTransID' =>'Confirmed by Brooksys '.rand(3000, 10000000)
        ];
    }
}
