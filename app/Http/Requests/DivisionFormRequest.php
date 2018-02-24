<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DivisionFormRequest extends FormRequest
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
            'name' => 'required|max:60|unique:divisions'
        ];

        switch ($this->method()) {
            case 'PUT':
            case 'PATCH':
                $divisionId   = $this->route()->parameter('division')->id;
                $rules['name'] .= sprintf(',name,%s', $divisionId);
                break; 
        }

        return $rules;
    }
}
