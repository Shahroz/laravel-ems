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
            'username'   => 'required|max:20|unique:users',
            'email'      => 'required|email|max:255|unique:users',
            'password'   => 'required|min:8|confirmed',
            'first_name' => 'required|max:60',
            'last_name'  => 'required|max:60'
        ];

        switch ($this->method()) {
            case 'PUT':
            case 'PATCH':
                $rules['id']       = 'required|integer|exists:users';
                $user              = (new User)->getUserInfo($this->get('id', 0), ['id']);
                if (empty($user)) {
                    return $rules;
                }

                $userId            = $user['id'];
                $rules['email']    = 'required|integer|unique:users,' . $userId;
                $rules['username'] = 'required|integer|exists:users,' . $userId;

                if (!$this->has('password')) {
                    unset($rules['password']);
                    unset($rules['password_confirmation']);
                }
        }

        return $rules;
    }
}
