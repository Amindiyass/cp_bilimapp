<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Lesson
 * @package App\Models
 * @property CompletedRate $completed_rate
 * @property Lesson $previous
 */
class Lesson extends Model
{
    public function assignments()
    {
        return $this->hasMany(Assignment::class);
    }

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


    public function completedRate()
    {
        return $this->morphOne(CompletedRate::class, 'model')->where('user_id', auth()->id());
    }

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function previous()
    {
        return self::where('id', '<', $this->id)->orderBy('id', 'desc')->first();
    }

    public function getNextStepAttribute()
    {
        $testResults = TestResult::user()->groupBy('test_id')->latest()->get();
        foreach ($testResults as $testResult) {
            if (!$testResult->passed) {
                return route('api.test', ['id' => $testResult->test->id]);
            }
        }
        $course = $this->load('section.course');
        $lesson = $course->lessons()->where('id', '>', $this->id)->first();
        return route('lesson', ['lesson' => $lesson->id]);
    }
}
