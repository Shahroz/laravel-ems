<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\City;

class CityFormRequest extends FormRequest
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
            'name'     => 'required|max:60|unique:city',
            'state_id' => 'required|integer|exists:state,id',
        ];

        if($this->isMethod('put')) {
            $rules['id']   = 'required|integer|exists:city';
            $city          = (new City)->getCityInfo($this->get('id', 0));
            if (!empty($city)) {
                $rules['name'] .= ',' . $city['id'];   
            }
        } elseif ($this->isMethod('delete')) {
            $rules = [
                'id' => 'required|integer|exists:city'
            ];
        }

        return $rules;
    }
}
