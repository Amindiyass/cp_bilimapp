<?php

namespace App;

use App\Models\CompletedRate;
use App\Models\Student;
use App\Models\UserSubscription;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Storage;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable, SoftDeletes, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_active',
        'balance',
        'recommend_user_id',
        'phone'
    ];
    protected $softDelete = true;

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getAvatarImageAttribute($value)
    {
        return Storage::url($value);
    }

    public function associateRedisCodeAndPhone($phone, $code)
    {
        Redis::hset($phone, $code);
    }

    public function checkCode($phone, $code)
    {
        $originalCode = Redis::hget($phone);
        return $originalCode === $code;
    }

    public function student()
    {
        return $this->hasOne(Student::class);
    }

    public function completedRates()
    {
        return $this->hasMany(CompletedRate::class);
    }

    public function subscriptions()
    {
        return $this->hasMany(UserSubscription::class);
    }

}
