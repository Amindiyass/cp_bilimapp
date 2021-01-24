<?php

namespace App;

use App\Models\Subscription;
use Illuminate\Database\Eloquent\Model;


/**
 * Class Order
 * @package App
 * @property Subscription $subscription
 * @property int $subscription_id
 * @property int $user_id
 * @property int $amount
 * @property int $status
 */
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

    public function subscription()
    {
        return $this->belongsTo(Subscription::class);
    }
}
