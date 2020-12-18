<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Test extends Model
{
    public $next;

    use SoftDeletes;

    protected $fillable = [
        'name_kz',
        'name_ru',
        'section_id',
        'order_number',

    ];

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

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function variants()
    {
        return $this->hasMany(TestVariant::class);
    }

    public function store($request)
    {
        try {
            DB::beginTransaction();
            $test = new Test();
            $test->fill($request);
            $test->save();
            Question::insert([
                'test_id' => $test->id,
                'right_variant_id' => json_encode([]),
                'order_number' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'body_kz' => $request['question_kz'],
                'body_ru' => $request['question_ru'],
            ]);
            DB::commit();
            return [
                'success' => true,
                'message' => null
            ];
        } catch (\Exception $exception) {
            DB::rollBack();
            $message = sprintf('%s %s %s',
                $exception->getFile(),
                $exception->getLine(),
                $exception->getMessage()
            );
            return [
                'success' => false,
                'message' => $message
            ];

        }
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
