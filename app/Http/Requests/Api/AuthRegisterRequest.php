<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class AuthRegisterRequest extends FormRequest
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
            'first_name' => 'required',
            'last_name' => 'required',
            'area_id' => 'required|exists:areas,id',
            'region_id' => 'required|int|exists:regions,id',
            'school_id' => 'int|exists:schools,id',
            'school_name' => 'string',
            'class_id' => 'required|int|exists:education_levels,id',
            'language_id' => 'required|int|exists:languages,id',
            'email' => 'required|email|unique:users',
            'phone' => 'required|unique:users',
            'password' => 'required',
            'inviter_id' => 'int',
            /*'promocode' => 'sometimes|required|exists:promocodes,name'*/
        ];
    }
}
