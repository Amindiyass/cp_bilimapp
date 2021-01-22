<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class TestStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name_kz' => 'required',
            'name_ru' => 'required',
            'course_id' => 'required|int',
            'section_id' => 'required|int',
            'order_number' => 'required|int',
            'question_in_kz' => 'required|array',
            'question_in_ru' => 'required|array',
        ];
    }

    public function validationData()
    {
        return $this->post();
    }
}
