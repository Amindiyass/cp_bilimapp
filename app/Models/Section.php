<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    protected $fillable = [
        'name_kz',
        'name_ru',
        'sort_number',
        'course_id'
    ];

    public function lessons()
    {
        return $this->hasMany(Lesson::class);
    }

    public function tests()
    {
        return $this->hasMany(Test::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function getLinkAttribute()
    {
        return route('api.lesson', ['lesson' => $this->id]);
    }

    public function getCompletedAttribute()
    {
        return $this->completed_rate ? $this->completed_rate->rate : 0;
    }
}
