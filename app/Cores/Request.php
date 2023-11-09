<?php

namespace App\Cores;

class Request
{
    protected ?array $data = null;
    public function __construct() {
        $this->data = $this->setData();
    }

    public function method()
    {
        return strtolower($_SERVER['REQUEST_METHOD'] ?? 'cli');
    }

    public function path()
    {
        return parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    }

    public function isGet()
    {
        return $this->method() === 'get';
    }

    public function isPost()
    {
        return $this->method() === 'post';
    }

    private function setData()
    {
        $body = [];

        if ($this->isPost()) {
            foreach ($_POST as $key => $value) {
                $body[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
                unset($_POST[$key]);
            }
        }

        if ($this->isGet()) {
            foreach ($_GET as $key => $value) {
                $body[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
                unset($_GET[$key]);
            }
        }

        return $body;
    }

    public function input(string $keys, mixed $default = null) {
        return array_get($this->data, $keys, $default);
    }

    public function all() {
        return $this->data;
    }
}
