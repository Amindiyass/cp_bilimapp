<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
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
}
