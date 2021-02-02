<?php

namespace App\Models;

use App\Http\Requests\Admin\LessonStoreRequest;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

/**
 * Class Lesson
 * @package App\Models
 * @property CompletedRate $completed_rate
 * @property Lesson $previous
 * @property Section $section
 * @property Test[] $tests
 * @property string $solutions_file_url
 */
class Lesson extends Model
{

    use SoftDeletes;

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
        'order',
        'solutions_file_url'
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
        return $this->hasMany(Test::class)->where('order_number',10000);
    }

    public function test()
    {
        return $this->hasOne(Test::class)->where('order_number',10000);
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
        if ($lesson) {
            return route('api.lesson', ['lesson' => $lesson->id]);
        } else {
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


    public function store(LessonStoreRequest $request, $lesson = null)
    {
        try {
            DB::beginTransaction();

            if (!isset($lesson)) {
                $lesson = new Lesson();
                $video = new Video();
                $conspectus = new  Conspectus();
            } else {
                $video = Video::where(['lesson_id' => $lesson->id])->first();
                $conspectus = Conspectus::where(['lesson_id' => $lesson->id])->first();
            }

            $lesson->fill($request->all());
            if ($request->file('solutions_file_url')) {
                $lesson->solutions_file_url = Storage::putFile('solutions/' . auth()->id(), $request->file('solutions_file_url'), 'public');
            }
            $lesson->save();


            $course = Course::where(['id' => $request->course_id])->first();
            $subject = $course->subject;
            $videos = [
                'title_kz' => $request->title_kz,
                'title_ru' => $request->title_ru,
                'lesson_id' => $lesson->id,
                'subject_id' => $subject->id,
                'path' => $request->path,
                'sort_number' => $request->sort_number,
            ];


            $video->fill($videos);
            $video->save();

            $conspectuses = [
                'body' => $request->body,
                'lesson_id' => $lesson->id,
                'video_id' => $video->id,
            ];

            if ($conspectus) {
                $conspectus->fill($conspectuses);
                $conspectus->save();
            }

            DB::commit();

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
