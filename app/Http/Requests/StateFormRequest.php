<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StateFormRequest extends FormRequest
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
        $rules = [
            'name'       => 'required|max:60|unique:states',
            'country_id' => 'required|integer|exists:countries,id'
        ];

        switch ($this->method()) {
            case 'PUT':
            case 'PATCH':
                $stateId        = $this->route()->parameter('state')->id;
                $rules['name'] .= sprintf(',name,%s', $stateId); 
                break;  
        }

        return $rules;
    }
}
