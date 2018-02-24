<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $authorize = true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'username'   => 'required|string|max:20|unique:users',
            'email'      => 'required|email|max:255|unique:users',
            'password'   => 'required|min:8|confirmed',
            'first_name' => 'required|string|max:60',
            'last_name'  => 'required|string|max:60'
        ];

        switch ($this->method()) {
            case 'PUT':
            case 'PATCH':
                $userId             = $this->route()->parameter('user')->id;
                $rules['email']    .= sprintf(",email,%s", $userId);
                $rules['username'] .= sprintf(",username,%s", $userId);

                if (is_null($this->get('password'))) {
                    unset($rules['password']);
                    unset($rules['password_confirmation']);
                }
        }
        
        return $rules;
    }
}
