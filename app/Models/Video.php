<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Video
 * @package App\Models
 * @property Lesson $lesson
 */
class Video extends Model
{
    protected $appends = [
        'link',
        'has_conspectus'
    ];

    public function completedRate()
    {
        return $this->morphOne(CompletedRate::class, 'model')->where('user_id', auth()->id());
    }

    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }

    public function getLinkAttribute()
    {
        return '/lesson/' . $this->id;
    }

    /**
     * @return bool
     */
    public function getHasConspectusAttribute()
    {
        return $this->lesson->conspectus->count() > 0;
    }
}
