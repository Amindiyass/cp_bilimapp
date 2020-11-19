<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Attachments extends Model
{
    protected $table = 'attachments';
    protected $primaryKey = 'id';
    protected $fillable = [
        'model_type',
        'model_id',
        'user_id',
        'type',
        'path',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
