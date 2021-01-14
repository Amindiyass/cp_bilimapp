<?php

namespace App\Models;

use App\Filters\QueryFilter;
use App\Search\ModelSearch;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * Class Course
 * @package App\Models
 *
 * @property $language_id
 * @property $subject_id
 * @property $class_id
 * @property Subject $subject
 * @property EducationLevel $class
 * @property Language $language
 * @property string $description
 * @property CompletedRate $completedRate
 * @property Lesson[] $lessons
 */
class Course extends Model
{


    protected $table = 'courses';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name_ru',
        'name_kz',
        'language_id',
        'subject_id',
        'class_id',
        'order',
        'description_ru',
        'description_kz',

    ];

    public function scopeFilter(Builder $builder, QueryFilter $filters)
    {
        return $filters->apply($builder);
    }

    public function scopeSearch(Builder $builder, ModelSearch $search)
    {
        return $search->apply($builder);
    }

    public function class()
    {
        return $this->belongsTo(EducationLevel::class, 'class_id', 'id');
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function sections()
    {
        return $this->hasMany(Section::class);
    }

    public function lessons()
    {
        return $this->hasManyThrough(Lesson::class, Section::class);
    }

    public function language()
    {
        return $this->belongsTo(Language::class);
    }

    public function completedRate()
    {
        return $this->morphOne(CompletedRate::class, 'model');
    }

    public function tests()
    {
        return $this->hasMany(Test::class);
    }

    public function education_level()
    {
        return $this->hasOne(EducationLevel::class, 'id', 'class_id');
    }


    public function getCountTestsAttribute()
    {
        return Test::whereIn('lesson_id', $this->lessons()->select('lessons.id'))->count();
    }

    public function getCountVideosAttribute()
    {
        return Video::whereIn('lesson_id', $this->lessons()->select('lessons.id'))->count();
    }

    public function getLinkAttribute()
    {
        return route('course.show', ['course' => $this->id]);
    }

    public static function test_count()
    {

        $test_count = cache()->remember('test_count', '300', function () {
            $result = [];
            $courses = Course::all();
            foreach ($courses as $course) {
                $sectionsIds = Section::where(['course_id' => $course->id])->get()->pluck('id')->toArray();
                $lessonIds = Lesson::whereIn('section_id', $sectionsIds)->get()->pluck('id')->toArray();
                $count = Test::whereIn('lesson_id', $lessonIds)->count();
                $result[$course->id] = $count;
            }
            return $result;
        });
        return $test_count;
    }

    public static function video_count()
    {

        $video_count = cache()->remember('video_count', '300', function () {
            $result = [];
            $courses = Course::all();
            foreach ($courses as $course) {
                $sectionsIds = Section::where(['course_id' => $course->id])->get()->pluck('id')->toArray();
                $lessonIds = Lesson::whereIn('section_id', $sectionsIds)->get()->pluck('id')->toArray();
                $count = Video::whereIn('lesson_id', $lessonIds)->count();
                $result[$course->id] = $count;
            }
            return $result;
        });

        return $video_count;
    }

    public static function assignment_count()
    {

        $assignment_count = cache()->remember('assignment_count', '300', function () {
            $result = [];
            $courses = Course::all();
            foreach ($courses as $course) {
                $sectionsIds = Section::where(['course_id' => $course->id])->get()->pluck('id')->toArray();
                $lessonIds = Lesson::whereIn('section_id', $sectionsIds)->get()->pluck('id')->toArray();
                $count = Assignment::whereIn('lesson_id', $lessonIds)->count();
                $result[$course->id] = $count;
            }
            return $result;
        });

        return $assignment_count;
    }

    public function store($request)
    {
        try {
            DB::beginTransaction();
            $course = new Course();
            $course->fill($request->all());
            $course->save();

            $key = sprintf('%s-%s', 'course_section', session()->getId());
            $section = session()->get(sprintf('%s-%s', 'course_section', session()->getId()));
            for ($i = 0; $i < count($section['sort_number']); $i++) {
                DB::table('sections')
                    ->insert([
                        'name_ru' => $section['name_ru'][$i],
                        'name_kz' => $section['name_kz'][$i],
                        'sort_number' => $section['sort_number'][$i],
                        'course_id' => $course->id,
                    ]);
            }

            session()->forget($key);

            DB::commit();

            return [
                'success' => true,
                'message' => null
            ];
        } catch (\Exception $exception) {
            DB::rollBack();
            $error = sprintf('%s %s %s', $exception->getFile(), $exception->getLine(), $exception->getMessage());
            return [
                'success' => false,
                'message' => $error,
            ];


        }
    }

}
