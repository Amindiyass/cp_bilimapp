<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class TestVariant extends Model
{

    protected $table = 'test_variants';
    protected $primaryKey = 'id';
    protected $fillable = [
        'variant_in_kz',
        'variant_in_ru',
        'order_number',
        'question_id',
        'test_id'
    ];


    public function is_right()
    {
        $right_variants = $this->question->right_variant_id;
        if (in_array($this->id, $right_variants)) {
            return true;
        }
        return false;
    }

    public function store($request)
    {
        try {
            DB::beginTransaction();
            $question = Question::find($request->question_id);

            $variant = new TestVariant();
            $test_id = $question->test->id;
            if (!isset($test_id)) {
                return redirect(route('question.edit'))
                    ->with('error', 'ID теста не найден');
            }

            $variant->test_id = $test_id;
            $variant->order_number = 0;
            $variant->fill($request->all());
            $variant->save();

            if ($request->is_right) {
                $right_variants_id = $question->right_variant_id;
                $right_variants_id[count($right_variants_id)] = $variant->id;
                $question->right_variant_id = $right_variants_id;
                $question->save();
            }
            DB::commit();

            return [
                'success' => true,
                'message' => null
            ];
        } catch (\Exception $exception) {
            DB::rollBack();
            $message = sprintf('%s %s %s',
                $exception->getFile(),
                $exception->getLine(),
                $exception->getMessage()
            );
            return [
                'success' => false,
                'message' => $message
            ];
        }

    }

    public function modify($request)
    {
        try {
            $array = [];
            DB::beginTransaction();
            $variant = TestVariant::find($request->variant_id);
            $question = $variant->question;

            $test_id = $question->test->id;
            if (!isset($test_id)) {
                return redirect(route('question.edit'))
                    ->with('error', 'ID теста не найден');
            }

            $variant->test_id = $test_id;
            $variant->order_number = 0;
            $variant->fill($request->all());
            $variant->save();

            $right_variants_id = $question->right_variant_id;

            if ($request->is_right) {
                if (!in_array($variant->id, $right_variants_id)) {
                    $right_variants_id[count($right_variants_id)] = $variant->id;
                }
            } else {
                if (($key = array_search($variant->id, $right_variants_id)) !== false) {
                    unset($right_variants_id[$key]);
                }
                foreach ($right_variants_id as $right_variant) {
                    $array[] = $right_variant;
                }
                $right_variants_id = $array;
            }

            $question->right_variant_id = $right_variants_id;
            $question->save();
            DB::commit();

            return [
                'success' => true,
                'message' => null
            ];
        } catch (\Exception $exception) {
            DB::rollBack();
            $message = sprintf('%s %s %s',
                $exception->getFile(),
                $exception->getLine(),
                $exception->getMessage()
            );
            return [
                'success' => false,
                'message' => $message
            ];
        }
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}
