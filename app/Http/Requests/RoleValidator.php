<?php

namespace Sijot\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoleValidator extends FormRequest
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
            'name'        => 'required|unique:roles',
            'description' => 'required'
        ];
    }
}
