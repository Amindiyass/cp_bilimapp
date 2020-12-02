<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    public function videos()
    {
        return $this->hasMany(Video::class);
    }

    public function conspectus()
    {
        return $this->hasMany(Conspectus::class);
    }

    public function tests()
    {
        return $this->hasMany(Test::class);
    }

    public function assignments()
    {
        return $this->hasMany(Assignment::class);
    }

    public function completedRate()
    {
        return $this->morphOne(CompletedRate::class, 'model')->where('user_id', auth()->id());
    }
}
