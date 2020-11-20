<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'likes';
    protected $fillable = [
        'model_type',
        'model_id',
        'user_id',
        'is_active',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }



}
