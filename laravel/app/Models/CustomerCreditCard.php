<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CustomerCreditCard extends Model
{
    use HasFactory;

    // protected $fillable = ['customer_id', 'card_number', 'expiry_date', 'card_holder_name'];
    protected $guarded = ['created_at', 'updated_at'];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }
}
