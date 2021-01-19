<?php

namespace App\Models;

use App\Http\Requests\Admin\LessonStoreRequest;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * Class Lesson
 * @package App\Models
 * @property CompletedRate $completed_rate
 * @property Lesson $previous
 * @property Section $section
 * @property Test[] $tests
 */
class Lesson extends Model
{
    protected $casts = [
        'created_at' => 'timestamp',
        'updated_at' => 'timestamp',
    ];

    protected $fillable = [
        'name_ru',
        'name_kz',
        'section_id',
        'description_kz',
        'description_ru',
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
        if ($lesson){
            return route('api.lesson', ['lesson' => $lesson->id]);
        }else{
            return null;
        }
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



    public function store(LessonStoreRequest $request)
    {
        try {
            DB::beginTransaction();
            $lesson = new Lesson();
            $lesson->fill($request->all());
            $lesson->save();

            $video_key = sprintf('%s-%s', 'lesson_video', session()->getId());
            $videos = session()->get($video_key);
            $course = Course::where(['id' => $request->course_id])->first();
            $subject_id = $course->subject->id;
            $videos = [
                'title_kz' => $videos['title_kz'][0],
                'title_ru' => $videos['title_ru'][0],
                'path' => $videos['path'][0],
                'sort_number' => $videos['sort_number'][0],
                'lesson_id' => $lesson->id,
                'subject_id' => $subject_id,
            ];

            DB::table('videos')->insert($videos);

            $conspectus_key = sprintf('%s-%s', 'lesson_conspectus', session()->getId());
            $conspectus = session()->get($conspectus_key);
            $conspectus = [
                'body' => $conspectus['body'][0],
                'lesson_id' => $lesson->id,
            ];

            DB::table('conspectuses')->insert($conspectus);

            DB::commit();

            session()->forget($conspectus_key);
            session()->forget($video_key);

            return [
                'success' => true,
                'message' => null,
            ];
        } catch (\Exception $exception) {
            DB::rollBack();
            $error = sprintf('%s %s %s', $exception->getFile(), $exception->getFile(), $exception->getMessage());
            return [
                'success' => false,
                'message' => $error,
            ];
        }
    }

    public function deleteWithDependencies($lesson)
    {
        try {
            DB::beginTransaction();
            Video::where('lesson_id', $lesson->id)->delete();
            Conspectus::where('lesson_id', $lesson->id)->delete();
            Assignment::where('lesson_id', $lesson->id)->delete();
            $lesson->delete();
            DB::commit();

            return [
                'success' => true,
                'message' => null,
            ];
        } catch (\Exception $exception) {
            DB::rollBack();
            return [
                'success' => false,
                'message' => $exception->getMessage()
            ];
        }
    }
}
