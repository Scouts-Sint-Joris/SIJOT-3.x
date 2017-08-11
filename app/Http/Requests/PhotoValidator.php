<?php

namespace Sijot\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PhotoValidator extends FormRequest
{
    // TODO Create class docblock. 
    
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
            'title'         => 'required', 
            'group'         => 'required', 
            'image'         => 'required', 
            'url'           => 'required', 
            'description'   => 'required',
        ];
    }
}
