<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Subscription
 * @package App\Models
 * @property int $id
 * @property string $name
 * @property int $price
 * @property $duration_in_year
 * @property $duration_in_month
 * @property $duration_in_week
 * @property int $discount
 * @property boolean $is_active
 */
class Subscription extends Model
{

}
