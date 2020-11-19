<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class CompletedRate extends Model
{
    protected $table = 'completed_rates';
    protected $primaryKey = 'id';
    protected $fillable = [
        'model_type',
        'model_id',
        'user_id',
        'is_checked'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
