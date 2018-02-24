<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DepartmentFormRequest extends FormRequest
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
            'name' => 'required|max:60|unique:departments'
        ];

        switch ($this->method()) {
            case 'PUT':
            case 'PATCH':
                $departmentId   = $this->route()->parameter('department')->id;
                $rules['name'] .= sprintf(',name,%s', $departmentId);
                break;  
        }

        return $rules;
    }
}
