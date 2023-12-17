<?php

namespace App\Services;

use App\Cores\Application;
use App\Models\User;

class AuthService extends BaseService
{
    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function login($username, $password)
    {
        $user = $this->model->where('email', $username)->first();

        // $user->password = password_hash($password, PASSWORD_DEFAULT);
        // $user->save();

        if ($user !== null && password_verify($password, $user->password)) {
            Application::$app->auth('user', $user);
            return true;
        }

        return false;
    }
}
