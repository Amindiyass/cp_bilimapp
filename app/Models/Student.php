<?php

namespace App\Models;

use App\Filters\QueryFilter;
use App\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $table = 'students';
    protected $fillable = [
        'first_name',
        'last_name',
        'area_id',
        'region_id',
        'school_id',
        'language_id',
        'user_id',
        'class_id',
    ];

    public function scopeFilter(Builder $builder, QueryFilter $filters)
    {
        return $filters->apply($builder);
    }

    public function scopeByUser($query)
    {
        return $query->where('user_id', auth()->id());
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function language()
    {
        return $this->belongsTo(Language::class);
    }

    public function get_items()
    {
        $areas = Area::all()->pluck('name_ru', 'id')->toArray();
        $classes = EducationLevel::all()->pluck('order_number', 'id')->toArray();
        $languages = Language::all()->pluck('name_ru', 'id')->toArray();
        $subscriptions = Subscription::where(['is_active' => true])->get()->pluck('name_ru', 'id');
        sort($classes);

        $regions = Region::all()->pluck('name_ru', 'id')->toArray();
        $schools = Region::all()->pluck('name_ru', 'id')->toArray();

        $result = [
            'areas' => $areas,
            'classes' => $classes,
            'languages' => $languages,
            'subscriptions' => $subscriptions,
            'regions' => $regions,
            'schools' => $schools,
        ];
        return $result;
    }

}
