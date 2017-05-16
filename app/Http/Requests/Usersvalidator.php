<?php

namespace Sijot\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class Usersvalidator
 *
 * @package Sijot\Http\Requests
 */
class Usersvalidator extends FormRequest
{
    // TODO: Fill in the the validation rules.

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }
}
