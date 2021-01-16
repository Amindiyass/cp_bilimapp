<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'amount',
        'subscription_id',
        'user_id'
    ];
}
