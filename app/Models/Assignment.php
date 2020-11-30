<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Assignment
 * @package App\Models
 * @property Lesson $lesson
 */
class Assignment extends Model
{
    public function solution()
    {
        return $this->hasOne(AssignmentSolution::class);
    }

    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }

    public function checkLesson()
    {
        return $this->lesson->previous->completed_rate->rate === 100;
    }
}
