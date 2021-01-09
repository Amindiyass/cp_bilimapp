<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    protected $appends = [
     //   'link_to_lesson'
    ];

    public function completedRate()
    {
        return $this->morphOne(CompletedRate::class, 'model')->where('user_id', auth()->id());
    }

    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }

    public function getLinkToLessonAttribute()
    {
        return route('api.lesson', ['lesson' => $this->lesson->id]);
    }
}
