<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CountryFormRequest extends FormRequest
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
            'name' => 'required|max:60|unique:countries',
            'code' => 'required|max:3|unique:countries'
        ];

        switch ($this->method()) {
            case 'PUT':
            case 'PATCH':
                $countryId     = $this->route()->parameter('country')->id;
                $rules['name'] .= sprintf(',name,%s', $countryId); 
                $rules['code'] .= sprintf(',code,%s', $countryId);
                break;  
        }

        return $rules;
    }
}
