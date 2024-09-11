<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PosPayment extends Model
{
    protected $fillable = [
        'pos_id',
        'date',
        'amount',
        'discount',
        'paymnent_method',
        'created_by',

    ];


    public function bankAccount()
    {
        return $this->hasOne('App\Models\BankAccount', 'id', 'account_id');
    }
}
