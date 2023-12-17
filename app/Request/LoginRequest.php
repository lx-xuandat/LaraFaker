<?php

namespace App\Request;

use App\Cores\FormRequest;

class LoginRequest extends FormRequest
{

    protected function rules(): array
    {
        return [
            'username' => 'required',
            'password' => 'required',
        ];
    }

    protected function messages(): array
    {
        return [
            'username.required' => 'Yeu Cau nhap username',
            'password.required' => 'Yeu cau nhap mat khau'
        ];
    }
}
