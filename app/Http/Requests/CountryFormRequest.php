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
            'name'         => 'required|max:60|unique:country',
            'country_code' => 'required|max:3|unique:country'
        ];

        if($this->isMethod('put')) {
            $rules['id']            = 'required|integer|exists:country';
            $rules['name']         .= ',' . $this->get('id', 0); 
            $rules['country_code'] .= ',' . $this->get('id', 0); 
        } elseif ($this->isMethod('delete')) {
            $rules = [
                'id' => 'required|integer|exists:country'
            ];
        }

        return $rules;
    }
}
