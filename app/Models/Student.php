<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $table = 'students';
    protected $fillable = [
        'first_name',
        'last_name',
        'area_id',
        'region_id',
        'school_id',
        'language_id',
        'user_id',
        'class_id',
    ];

    public function scopeByUser($query)
    {
        return $query->where('user_id', auth()->id());
    }


    # TODO  write all relationships
}
