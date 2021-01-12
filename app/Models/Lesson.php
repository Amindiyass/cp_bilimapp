<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * Class Lesson
 * @package App\Models
 * @property CompletedRate $completed_rate
 * @property Lesson $previous
 * @property Test[] $tests
 */
class Lesson extends Model
{
    protected $casts = [
        'created_at' => 'timestamp',
        'updated_at' => 'timestamp',
    ];

    public function assignments()
    {
        return $this->hasMany(Assignment::class);
    }

    public function assignment()
    {
        return $this->hasMany(Assignment::class);
    }

    public function videos()
    {
        return $this->hasMany(Video::class);
    }

    public function video()
    {
        return $this->hasOne(Video::class);
    }

    public function conspectus()
    {
        return $this->hasMany(Conspectus::class);
    }

    public function tests()
    {
        return $this->hasMany(Test::class);
    }

    public function test()
    {
        return $this->hasOne(Test::class);
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
//        $testResults = TestResult::byUser()->where('passed', 'false')->groupBy('test_id')->latest()->get();
//        foreach ($testResults as $testResult) {
//            if (!$testResult->passed) {
//                return route('api.test', ['test' => $testResult->test->id]);
//            }
//        }
        $testResult = TestResult::select('test_id')->byUser()->where('passed', 'false')->groupBy('test_id')->first();
        if ($testResult) {
            return route('api.test', ['test' => $testResult->test_id]);
        }
        // $course = $this->load('section.course');
        $lesson = $this->section->course->lessons()->where('lessons.id', '>', $this->id)->first();
        return route('api.lesson', ['lesson' => $lesson->id]);
    }

    public function getLinkAttribute()
    {
        return route('api.lesson', ['lesson' => $this->id]);
    }

    public function getCompletedAttribute()
    {
        return $this->completed_rate ? $this->completed_rate->rate : 0;
    }

    public function incrementCompletedRate()
    {
        if (!$this->completed_rate) {
            $this->completedRate()->create([
                'rate' => 1,
                'user_id' => auth()->user()->id,
                'is_checked' => false
            ]);
        }
    }

}
