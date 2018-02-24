<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeFormRequest extends FormRequest
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
            'firstname'     => 'required|max:60',
            'middlename'    => 'nullable|max:60',
            'lastname'      => 'required|max:60',
            'address'       => 'required|max:255',
            'city'          => 'required|string|max:255',
            'state_id'      => 'required|integer|exists:states,id',
            'country_id'    => 'required|integer|exists:countries,id',
            'department_id' => 'required|integer|exists:departments,id',
            'division_id'   => 'required|integer|exists:divisions,id',
            'zipcode'       => 'nullable|max:10',       
            'age'           => 'required|integer|between:18,100',
            'birthdate'     => 'required|date|before:18 years ago',
            'date_hired'    => 'required|date',
            'avatar'        => 'nullable|image|mimes:png,jpeg,jpg,bmp,gif'      
        ];

        return $rules;
    }
}
