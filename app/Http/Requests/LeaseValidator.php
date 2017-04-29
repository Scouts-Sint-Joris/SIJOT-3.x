<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LeaseValidator extends FormRequest
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
            'status_id'     => 'required',
            'start_datum'   => 'required|date|before:eind_datum',
            'eind_datum'    => 'required|date|after:start_datum',
            'contact_email' => 'required|email',
            'groeps_naam'   => 'required'
        ];
    }
}
