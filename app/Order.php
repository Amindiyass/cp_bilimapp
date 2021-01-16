<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    const STATUS_CREATED = 0;
    const STATUS_SUCCESS = 0;
    const STATUS_FAILURE = 0;

    protected $fillable = [
        'amount',
        'subscription_id',
        'user_id',
        'status'
    ];
}
