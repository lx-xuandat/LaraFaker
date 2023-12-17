<?php

namespace App\Cores;

class Router
{
    protected $routes = [];
    public Request $request;
    public Response $response;
    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
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
                $controllerDependencies = [];

                $class = new \ReflectionMethod($callback[0], '__construct');
                foreach ($class->getParameters() as $parameter) {
                    $serviceName = $parameter->getType() . '';

                    //
                    $serviceDependencies = [];
                    $serviceReflection = new \ReflectionMethod($serviceName, '__construct');
                    foreach ($serviceReflection->getParameters() as $parameter) {
                        $modelName = $parameter->getType() . '';
                        $instantModel = new $modelName;
                        array_push($serviceDependencies, $instantModel);
                    }
                    $instantService = new $serviceName(...$serviceDependencies);
                    //

                    array_push($controllerDependencies, $instantService);
                }

                $controller = new ($callback[0])(...$controllerDependencies);
                $controller->action = $callback[1];
                Application::$app->controller = $controller;

                return $this->fireDependence(
                    $controller, $controller->action
                );
            }

            throw new \Exception("<b>Page $path not found.</b>", 404);
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function fireDependence($class, $method)
    {
        $fireArgs = array();

        $reflection = new \ReflectionMethod($class, $method);

        foreach ($reflection->getParameters() as $parameter) {
            $className = $parameter->getType() . '';
            $instant = new $className;
            array_push($fireArgs, $instant);
        }

        return call_user_func_array(array($class, $method), $fireArgs);
    }
}
