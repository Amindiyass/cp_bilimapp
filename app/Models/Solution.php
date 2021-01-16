<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


/* @property string $question
 * @property string $answer
 * @property Course $course
 * @property Category[] $categories
 * */
class Solution extends Model
{
    public function course()
    {
        return $this->belongsTo('App\Models\Course');
    }

    public function categories()
    {
        return $this->belongsToMany('App\Models\Category','solution_categories');
    }
}
