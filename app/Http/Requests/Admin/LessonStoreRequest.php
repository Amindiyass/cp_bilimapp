<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class LessonStoreRequest extends FormRequest
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
            'name_ru' => 'required',
            'name_kz' => 'required',
//            'description_kz' => 'required',
//            'description_ru' => 'required',
//            'body' => 'required',
            'title_kz' => 'required',
            'title_ru' => 'required',
            'path' => 'required',
            'sort_number' => 'required'

        ];
    }
}
