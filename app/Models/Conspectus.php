<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Conspectus extends Model
{
    protected $fillable = [
        'body',
        'lesson_id',
        'video_id'
    ];

    protected $table = 'conspectuses';
    protected $primaryKey = 'id';
}
