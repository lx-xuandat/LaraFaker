<?php

namespace App\Cores;

class Request
{
    function method() {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }

    function path() {
        return parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    }
}
