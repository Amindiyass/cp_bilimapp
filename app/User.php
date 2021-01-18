<?php

namespace App;

use App\Models\CompletedRate;
use App\Models\Promocode;
use App\Models\Student;
use App\Models\Subscription;
use Carbon\Carbon;
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

    const ROLE_ADMIN = 1;
    const ROLE_STUDENT = 2;
    const ROLE_MODERATOR = 3;
    const ROLE_STUFF = 4;


    protected $fillable = [
        'name',
        'email',
        'password',
        'is_active',
        'balance',
        'recommend_user_id',
        'phone',
        'inviter_id'
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

    public function inviter()
    {
        return $this->belongsTo(User::class, 'inviter_id', 'id');
    }

    public function promocode()
    {
        return $this->hasOne(Promocode::class);
    }

    public static function getRoleNames($role_id)
    {
        switch ($role_id) {
            case self::ROLE_ADMIN:
                return 'admin';
            case self::ROLE_STUDENT:
                return 'student';
            case  self::ROLE_MODERATOR:
                return 'moderator';
            case self::ROLE_STUFF:
                return 'stuff';
        }
    }

    public function getAvatarImageAttribute($value)
    {
        return Storage::url($value);
    }

    public function associateRedisCodeAndPhone($phone, $code)
    {
        Redis::hset($phone, 'code', $code);
    }

    public function checkCode($phone, $code)
    {
        $originalCode = Redis::hget($phone, 'code');
        return $originalCode === $code;
    }

    public function students()
    {
        return $this->hasMany(Student::class);
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
        return $this->belongsToMany(Subscription::class, 'user_subscriptions');
    }

    public function isActiveSubscription()
    {
        $userSubscriptions = $this->subscriptions()->withPivot('created_at')->get();
        foreach ($userSubscriptions as $userSubscription) {
            $active = $userSubscription->pivot->created_at
                    ->addWeeks($userSubscription->duration_in_week)
                    ->addMonths($userSubscription->duration_in_month)
                    ->addYear($userSubscription->duration_in_year) > Carbon::now();
            if ($active) {
                return true;
            }
        }
        return false;
    }

    public function getActiveSubscription()
    {
        $userSubscriptions = $this->subscriptions()->withPivot('created_at')->get();
        foreach ($userSubscriptions as $userSubscription) {
            $active = $userSubscription->pivot->created_at
                    ->addWeeks($userSubscription->duration_in_week)
                    ->addMonths($userSubscription->duration_in_month)
                    ->addYear($userSubscription->duration_in_year) > Carbon::now();
            if ($active) {
                return $userSubscription;
            }
        }
        return null;
    }

    public function getRoleName($id)
    {
        $user = self::find($id);
        switch ($user->roles->pluck('name')[0]) {
            case 'stuff':
                return 'Сотрудник';
            case 'admin':
                return 'Администратор';
            case 'moderator':
                return 'Модератор';
        }
    }
}
