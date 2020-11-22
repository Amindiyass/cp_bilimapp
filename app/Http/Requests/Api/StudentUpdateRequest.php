<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class StudentUpdateRequest extends FormRequest
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
            'first_name' => 'required|string',
            'last_name' => 'string',
            'region_id' => 'required|integer',
            'area_id' => 'required|integer',
            'school_id' => 'required|integer',
            'phone' => 'required',
            'photo' => 'image',
            'email' => 'email'
        ];
    }
}
