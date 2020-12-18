<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class UserSubscription extends Pivot
{
    protected $table = 'user_subscriptions';
}
