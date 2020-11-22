<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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

    # TODO write all relationships
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
}
