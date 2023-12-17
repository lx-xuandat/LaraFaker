<?php

session_start();

/**
 * Load params command to $_REQUEST
 */
if (php_sapi_name() === 'cli') {
    $argv = $_SERVER['argv'];
    parse_str(implode('&', array_slice($argv, 1)), $_REQUEST);

    //$ php public/index.php a=5 b=6 c=40
    // var_dump($_REQUEST);
}

/**
 * Helper get value item in array
 * array_get($arr, 'mail.email', 'def@mail.com') return $arr['mail']['email'] ?? 'def@mail.com'
 *
 * @param array $arr
 * @param string $keys 
 * @param mixed $default
 * @return string|null
 */
function array_get(array $arr, string $keys, mixed $default = null)
{
    $exist = true;
    $nested = explode('.', $keys);
    $arrNested = $arr;

    foreach ($nested as $key) {
        if (is_array($arrNested) && array_key_exists($key, $arrNested)) {
            $arrNested = $arrNested[$key];
        } else {
            $exist = false;
            break;
        }
    }

    return $exist ? $arrNested : $default;
}

function view(string $file, array $params = []): mixed
{
    try {
        if (file_exists(ROOT . '/resources/views/' . str_replace('.', '/', $file) . '.blade.php')) {
            ob_start();
            extract($params);
            include(ROOT . '/resources/views/' . str_replace('.', '/', $file) . '.blade.php');

            return ob_get_clean();
        }

        throw new \Exception("View $file not found", 404);
    } catch (\Exception $th) {
        return $th;
    }
}

/**
 * Load config
 */
$config = [];
foreach (glob(ROOT . '/config/*.php') as $file) {
    $config[basename($file, ".php")] = require_once $file;
}
define('CF', $config);

/**
 * Load function helper
 */
foreach (glob(ROOT . '/app/Helpers/*.php') as $file) {
    require_once($file);
}

$app = new App\Cores\Application($config);

/**
 * Load route link
 */
foreach (glob(ROOT . '/routes/*.php') as $file) {
    require_once($file);
}

return $app;
