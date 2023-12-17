<?php

namespace App\Controllers\Admin\Auth;

use App\Cores\Controller;
use App\Cores\Request;
use App\Cores\Response;
use App\Models\User;
use App\Request\LoginRequest;
use App\Services\AuthService;
use App\Services\UserService;

class LoginController extends Controller
{
    public function __construct(
        private UserService $userService,
        private AuthService $authService
    ) {
        $this->userService = $userService;
        $this->authService = $authService;
    }

    public function getLogin()
    {
        return view('admin.login');
    }

    public function postLogin(LoginRequest $request, Response $response)
    {
        try {
            $email = $request->input('uname');
            $password = $request->input('psw');
            $remember = $request->input('remember');

            if ($this->authService->login($email, $password)) {
                return $response->redirect('/');
            } else {
                // check request is ajax method
                $data = ['name' => 'God', 'age' => -1];
                header('Content-type: application/json');
                return json_encode($data);
            }

            // throw new \Exception('Login fail');
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
