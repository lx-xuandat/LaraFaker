<?php
$dotenv = Dotenv\Dotenv::createImmutable(ROOT);
$dotenv->load();

$config = [];
foreach (glob(ROOT . '/config/*.php') as $file) {
    $config[basename($file, ".php")] = require_once $file;
}
define('CF', $config);

foreach (glob(ROOT . '/app/Helpers/*.php') as $file) {
    require_once($file);
}

$app = new App\Cores\Application($config);

return $app;
