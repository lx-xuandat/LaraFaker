<?php

namespace App\Controllers\Admin\Auth;

use App\Cores\Controller;
use App\Cores\Request;

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
}
