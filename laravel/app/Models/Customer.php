<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\{HasMany};

class Customer extends Model
{
    use HasFactory;

    protected $guarded = ['created_at', 'updated_at'];

    public function orders(): hasMany
    {
        return $this->hasMany(Order::class);
    }

    public function creditCards(): hasMany
    {
        return $this->hasMany(CustomerCreditCard::class);
    }
}
