<?php

namespace Sijot\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class EventValidator
 *
 * @package Sijot\Http\Requests
 */
class EventValidator extends FormRequest
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
            'author_id'     => 'required',
            'title'         => 'required',
            'description'   => 'required',
            'start_date'    => 'required',
            'end_date'      => 'required',
            'status'        => 'required',
            'end_hour'      => 'required',
            'start_hour'    => 'required',
        ];
    }
}
