<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    public $next;
    public function questions()
    {
        return $this->hasMany(Question::class);
    }
    public function completedRate()
    {
        return $this->morphOne(CompletedRate::class, 'model')->where('user_id', auth()->id());
    }

    public function notCompletedRate()
    {
        return $this->morphOne(CompletedRate::class, 'model')
                    ->where('user_id', auth()->id())
                    ->where('is_checked', false);
    }

    public function getNextAttribute()
    {
        $nextTest = self::where('id', '>', $this->id)->first();
        return route('api.test', ['id' => $nextTest->id]);
    }

    public function results()
    {
        return $this->hasMany(TestResult::class);
    }

    public function lastResult()
    {
        return $this->hasOne(TestResult::class)->latest();
    }

    public function passedResults()
    {
        return $this->hasMany(TestResult::class)->where('passed', true);
    }

    public function previous()
    {
        return self::where('id', '<', $this->id)->orderBy('id', 'desc')->first();
    }

    public function checkTest(array $answers = [])
    {
        $questions = $this->questions()->get();
        $rightAnswers = 0;
        $wrongAnswers = 0;
        foreach ($answers as $key => $answer) {
            $answeredQuestion = $questions->where('id', $key)->first();
            if (!$answeredQuestion) {
                $wrongAnswers++;
                continue;
            }
            if ((int)$answeredQuestion->right_variant_id === (int)$answer) {
                $rightAnswers++;
            } else {
                $wrongAnswers++;
            }
        }
        return $this->results()->create([
            'user_id' => auth()->id(),
            'total_question' => $questions->count(),
            'wrong_answered' => $wrongAnswers,
            'right_answered' => $rightAnswers,
            'answers' => $answers,
            'passed' => ($rightAnswers * 100 / $questions->count()) > 70
        ]);

    }
}
