<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $table = 'reviews';
    protected $primaryKey = 'id';
    protected $fillable = [
        'model_type',
        'stars_quantity',
        'model_id',
        'user_id',
        'review_body'
    ];

    public function author()
    {
        return $this->belongsTo(User::class);
    }
}
