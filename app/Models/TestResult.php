<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TestResult extends Model
{
    protected $fillable = [
        'user_id',
        'total_question',
        'wrong_answered',
        'right_answered',
        'passed',
        'answers',
    ];
    protected $casts = [
        'answers' => 'array'
    ];

    public function test()
    {
        return $this->belongsTo(Test::class);
    }

    public function scopeUser($query)
    {
        return $query->where('user_id', auth()->id());
    }


    public function scopePassed($query)
    {
        return $query->where('passed', true);
    }
}
