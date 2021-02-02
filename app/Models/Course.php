<?php

namespace App\Models;

use App\Filters\QueryFilter;
use App\Search\ModelSearch;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
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
 * @property Solution[] $solutions
 * @property Category[] $solutionCategories;
 */
class Course extends Model
{

    use SoftDeletes;

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

    protected $casts = [
        'created_at' => 'timestamp',
        'updated_at' => 'timestamp',
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
        return Test::whereIn('lesson_id', $this->lessons()->select('lessons.id'))->where('order_number',10000)->count();
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
                $count = Test::whereIn('lesson_id', $lessonIds)->where('order_number',10000)->count();
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

    public function store($request, $course = null)
    {
        try {
            DB::beginTransaction();
            if (!isset($course)) {
                $course = new Course();
            }
            $course->fill($request->all());
            $course->save();

            $sectionArray = [];
            if (!isset($course)) {
                foreach ($request->addmore as $key => $value) {
                    $section = new Section();
                    $value['course_id'] = $course->id;
                    $section->fill($value);
                    $section->save();
                }
            } else {
                foreach ($request->addmore as $key => $value) {
                    if (!isset($value['section_id'])) {
                        $section = new Section();
                    } else {
                        $section = Section::where(['id' => $value['section_id']])->first();
                    }
                    $value['course_id'] = $course->id;
                    $section->fill($value);
                    $section->save();
                    array_push($sectionArray, $section->id);
                }
            }

            if (!isset($course)) {
                $sections = Section::where(['course_id' => $course->id])->get()->pluck('id')->toArray();
                foreach ($sections as $key => $item) {
                    if (!in_array($item, $sectionArray)) {
                        Section::find($item)->delete();
                    }
                }
            }


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

    public function get_temp_filter_items($request)
    {
        $classes = !empty($request->input('classes')) ? explode(',', $request->input('classes')) : [];
        $languages = !empty($request->input('languages')) ? explode(',', $request->input('languages')) : [];
        $subjects = !empty($request->input('subject_id')) ? explode(',', $request->input('subject_id')) : [];

        return [
            'classes' => $classes,
            'languages' => $languages,
            'subjects' => $subjects,
        ];
    }

    public function solutions()
    {
        return $this->hasMany('App\Models\Solution');
    }

    public function solutionCategories()
    {
        return $this->hasMany('App\Models\Category', 'course_id', 'id');
    }
}
