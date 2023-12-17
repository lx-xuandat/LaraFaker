<?php

namespace App\Cores;

use App\Cores\Request;
use App\Cores\Router;
use Illuminate\Database\Capsule\Manager as CapsuleManager;
use Illuminate\Database\Eloquent\Model;

class Application
{
    public Session $session;
    public ?Migrate $migrate = null;
    public static array $config;
    public static Application $app;
    public Router $router;
    public Request $request;
    public Response $response;
    public ?Controller $controller = null;
    public ?CapsuleManager $capsule = null;

    private array $auth = [];

    public function __construct(array $config)
    {
        self::$config = $config;
        self::$app = $this;

        $this->session = new Session();
        $this->request = new Request();
        $this->response = new Response();
        $this->router = new Router($this->request, $this->response);

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
        try {
            echo $this->router->resolve();
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function auth(string $guardName, Model $user = null) {
        // setter
        if ($user !== null) {
            $this->auth[$guardName] = $user;
            $this->session->auth($guardName, $user->{$user->primaryKey});

            return true;
        }

        // getter
    }
}
