<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    use HasFactory;


    protected $guarded = ['created_at', 'updated_at'];
    protected $casts = [
        'qr_code' => 'json',
        'form_request' => 'json',
        'api_request' => 'json',
        'api_response' => 'json',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function customerCreditCard(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
