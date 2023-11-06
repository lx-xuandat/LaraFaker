<?php

session_start();

define("ROOT", dirname(__DIR__));

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

require_once ROOT . '/vendor/autoload.php';
$app = require_once ROOT . '/bootstrap/app.php';

$app->run();
