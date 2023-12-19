<?php

namespace App\Request;

use App\Cores\FormRequest;

class LoginRequest extends FormRequest
{

    protected function rules(): array
    {
        return [
            'uname' => [
                'required',
                'min:8',
                'max:88'
            ],
            'psw' => [
                'required',
                'min:8',
                'max:88'
            ],
        ];
    }

    protected function messages(): array
    {
        return [
            'uname.required' => 'Yeu Cau nhap username',
            'psw.required' => 'Yeu cau nhap mat khau',
        ];
    }
}
