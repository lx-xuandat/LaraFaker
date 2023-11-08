<?php

namespace App\Cores;

use App\Cores\Request;
use App\Cores\Router;
use Illuminate\Database\Capsule\Manager as CapsuleManager;

class Application
{
    public static array $config;
    public static Application $app;
    public Router $router;
    public Request $request;
    public ?Controller $controller = null;
    public ?CapsuleManager $capsule = null;

    public function __construct(array $config)
    {
        self::$config = $config;
        self::$app = $this;

        $this->request = new Request();
        $this->router = new Router($this->request);

        $this->capsule = new CapsuleManager;
        $this->capsule->addConnection([
            "driver" => $_ENV['DB_CONNECTION'],
            "host" => $_ENV['DB_HOST'],
            "database" => $_ENV['DB_DATABASE'],
            "username" => $_ENV['DB_USERNAME'],
            "password" => $_ENV['DB_PASSWORD'],
        ]);
        $this->capsule->setAsGlobal();
        $this->capsule->bootEloquent();
    }

    public function run()
    {
        echo $this->router->resolve();
    }
}
