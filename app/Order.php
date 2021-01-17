<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    const STATUS_CREATED = 0;
    const STATUS_SUCCESS = 1;
    const STATUS_FAILURE = 2;

    protected $fillable = [
        'amount',
        'subscription_id',
        'user_id',
        'status'
    ];
}
