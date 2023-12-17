<?php

namespace App\Cores;

class Response
{
    public function setStattusCode(int $code)
    {
        http_response_code($code);
    }

    public function redirect($url)
    {
        header('Location: ' . $url);
        exit;
    }
}
