<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\City;

class CityFormRequest extends FormRequest
{
    private $methods = [
        'POST', 'PUT', 'PATCH', 'DELETE'
    ];
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
            'name'     => 'required|max:60|unique:city',
            'state_id' => 'required|integer|exists:state,id',
        ];

        if(in_array($this->method(), $this->methods)) {
            $id = $this->route()->parameter('city');
            if(!empty($id)) {
                if(isset($this->name)) {
                    $rules['name'] .= ',name,' . $id;
                }
            } else {
                $rules['id']   = 'required|integer|exists:city';
            }
        } elseif ($this->isMethod('delete')) {
            $id = $this->route()->parameter('city');
            if(empty($id)) {
                $rules = [
                    'id' => 'required|integer|exists:city'
                ];
            }
        }

        return $rules;
    }
}
