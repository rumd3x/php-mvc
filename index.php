<?php
define('BASE_PATH', basename(__DIR__));
$environment_file = 'environment.json';
foreach (json_decode(file_get_contents($environment_file), TRUE) as $key => $value) {
    define($key, $value);
}

require SYSTEM_FOLDER . '/Loader.php';

if (SHOW_ERRORS) {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
} else {
    ini_set('display_errors', 0);
    ini_set('display_startup_errors', 0);
    error_reporting(0);
}

Loader::system('Core');