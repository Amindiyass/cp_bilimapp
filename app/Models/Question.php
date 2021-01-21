<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

/**
 * Class Question
 * @package App\Models
 * @property array $right_variant_id
 */
class Question extends Model
{
    protected $table = 'questions';
    protected $casts = [
        'right_variant_id' => 'array'
    ];
    protected $fillable = [
        'test_id',
        'right_variant_id',
        'order_number',
        'created_at',
        'updated_at',
        'body_kz',
        'body_ru',
        'photo'
    ];
    protected $appends = [
        'multiple',
    ];


    public function variants()
    {
        return $this->hasMany(TestVariant::class);
    }

    public function test()
    {
        return $this->belongsTo(Test::class);
    }

    public function right_variants()
    {
        return count($this->right_variant_id);
    }

    public function getRightAnswersAttribute()
    {
        if (empty($this->right_variant_id)) {
            return $this->variants();
        }
        if (is_array($this->right_variant_id)) {
            return $this->variants()->whereIn('id', $this->right_variant_id)->get();
        }
        return $this->variants()->where('id', $this->right_variant_id)->get();
    }

    public function getMultipleAttribute()
    {
        return is_array($this->right_variant_id) ? count($this->right_variant_id) > 1 : false;
    }

    public function getPhotoAttribute($value)
    {
        return Storage::url($value);
    }
}
