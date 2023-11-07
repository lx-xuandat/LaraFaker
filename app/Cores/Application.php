<?php

namespace App\Cores;

use App\Cores\Request;
use App\Cores\Router;

class Application
{
    public static array $config;
    public static Application $app;
    public Router $router;
    public Request $request;
    public ?Controller $controller = null;

    public function __construct(array $config)
    {
        self::$config = $config;
        self::$app = $this;

        $this->request = new Request();
        $this->router = new Router($this->request);
    }

    public function run()
    {
        echo $this->router->resolve();
    }
}
