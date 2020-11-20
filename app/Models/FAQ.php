<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FAQ extends Model
{
    const STATUS_IN_PROCESS = 2;
    const STATUS_ANSWERED = 1;
    const STATUS_CANCELED = 3;

    protected $table = 'faqs';
    protected $fillable = ['question', 'answer', 'status'];
}
