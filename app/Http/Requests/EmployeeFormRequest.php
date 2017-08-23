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
            'lastname'      => 'required|max:60',
            'middlename'    => 'nullable|max:60',
            'firstname'     => 'required|max:60',
            'address'       => 'required|max:255',
            'city_id'       => 'required|integer|exists:city,id',
            'state_id'      => 'required|integer|exists:state,id',
            'country_id'    => 'required|integer|exists:country,id',
            'department_id' => 'required|integer|exists:department,id',
            'division_id'   => 'required|integer|exists:division,id',
            'zip'           => 'nullable|max:10',       
            'age'           => 'required|integer|between:18,100',
            'birthdate'     => 'required|date|before:18 years ago',
            'date_hired'    => 'required|date',
            'avatar'        => 'nullable|image|mimes:png,jpeg,jpg,bmp,gif'      
        ];

        if($this->isMethod('put')) {
            $rules['id']    = 'required|integer|exists:employees';
        } elseif ($this->isMethod('delete')) {
            $rules = [
                'id' => 'required|integer|exists:employees'
            ];
        }
    }
}
