<?php

namespace App\Models;

use App\Filters\QueryFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

/**
 * Class Assignment
 * @package App\Models
 * @property Lesson $lesson
 */
class Assignment extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'content',
        'order_number',
        'lesson_id',
        'answer',
        'section_id',
        'subject_id',
    ];

    public function scopeFilter(Builder $builder, QueryFilter $filters)
    {
        return $filters->apply($builder);
    }


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
        if (!($previous = $this->lesson->previous())) {
            return true;
        }
        if (isset($previous->completed_rate->rate)) {
            return $previous->completed_rate->rate === 100;
        }
        return false;
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function section()
    {
        return $this->belongsTo(Section::class);
    }


    public function get_temp_filter_items($request)
    {
        $sections = !empty($request->input('sections')) ? explode(',', $request->input('sections')) : [];
        $lessons = !empty($request->input('lessons')) ? explode(',', $request->input('lessons')) : [];
        $subjects = !empty($request->input('subjects')) ? explode(',', $request->input('subjects')) : [];

        return [
            'sections' => $sections,
            'lessons' => $lessons,
            'subjects' => $subjects,
        ];
    }

    public static function store($request, $assignment = null)
    {
        try {
            DB::beginTransaction();

            if (!isset($assignment)) {
                $assignment = new Assignment();
            }

            $assignment->fill($request->all());
            $assignment->save();

            $assignmentSolution = new  AssignmentSolution();
            $assignmentSolution->assignment_id = $assignment->id;
            $assignmentSolution->content = $request->solution;
            $assignmentSolution->save();

            DB::commit();
            return [
                'success' => true,
                'message' => null,
            ];
        } catch (\Exception $exception) {
            DB::rollBack();
            $message = sprintf('%s %s %s',
                $exception->getFile(),
                $exception->getLine(),
                $exception->getMessage());

            return [
                'success' => false,
                'message' => $message,
            ];
        }
    }
}
