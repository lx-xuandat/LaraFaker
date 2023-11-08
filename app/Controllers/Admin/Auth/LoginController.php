<?php

namespace App\Controllers\Admin\Auth;

use App\Cores\Controller;
use App\Cores\Request;
use App\Models\User;

class LoginController extends Controller
{
    public function getLogin(Request $request)
    {
        $params = [
            'title' => 'datlx197',
            'params' => 'datlx',
        ];

        return view('admin.login', $params);
    }

    public function postLogin(Request $request)
    {
        $email = $request->input('uname');
        $password = $request->input('psw');
        $remember = $request->input('remember');
        // syuttenba@gmail.com
        // $2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi
        $auth = User::where([
            'email' => $email,
            // 'password' => $password,
        ])->first();

        if ($auth) {
            return 'login thanh cong';
        }
    }
}
