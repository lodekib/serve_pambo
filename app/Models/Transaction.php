<?php

namespace App\Models;

use App\Events\TransactionCreatedEvent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'result_code','merchant_request_id',
        'checkout_request_id','amount','receipt_number',
        'transaction_date','phone'
    ];

    protected $dispatchesEvents = [
        'created' =>TransactionCreatedEvent::class
    ];
}
