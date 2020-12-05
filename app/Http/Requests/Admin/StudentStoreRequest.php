<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StudentStoreRequest extends FormRequest
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
        # TODO  make validation for checking region and school parent from update
        return [
                'first_name' => 'required',
                'last_name' => 'required',
                'phone' => 'required',
                'email' => 'required|unique:users',
                'area_id' => 'required|int',
                'region_id' => 'required|int',
                'school_id' => 'required|int',
                'language_id' => 'required|int',
                'class_id' => 'required|int',
        ];
    }

    public function validationData()
    {
        return $this->post();
    }
}
