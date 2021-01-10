<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CourseStoreRequest extends FormRequest
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
            'language_id' => 'required|int',
            'subject_id' => 'required|int',
            'class_id' => 'required|int',
            'order' => 'required',
            'description_ru' => 'required',
            'description_kz' => 'required',
        ];
    }
}
