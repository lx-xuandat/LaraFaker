<?php

namespace App\Controllers\Customer;
use App\Cores\Controller;

class HomeController extends Controller
{
    public function __construct() {
        
    }

    public function index() {
        return view('home.index');
    }
}
