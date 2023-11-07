<?php

namespace App\Cores;

class Router
{
    protected $routes = [];
    public Request $request;
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function get(string $path, array $callback)
    {
        $this->routes['get'][$path] = $callback;
    }

    public function post(string $path, array $callback)
    {
        $this->routes['post'][$path] = $callback;
    }

    public function resolve()
    {
        try {
            $method = $this->request->method();
            $path = $this->request->path();

            $callback = array_get($this->routes, $method . '.' . $path, false);

            // && class_exists($callback[0])

            if (is_array($callback)) {
                $controller = new $callback[0];
                $controller->action = $callback[1];
                Application::$app->controller = $controller;

                return call_user_func(
                    [$controller, $controller->action],
                    // ...$args
                    $this->request,
                );
            }

            return new \Exception("<b>Page $path not found.</b>", 404);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
