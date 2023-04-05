<?php

use App\Framework\DIC\DIC;
use App\Framework\Route\Router;

header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Credentials: true");
header('Access-Control-Allow-Headers: authorization, content-type');

session_start();
require_once dirname(__DIR__) . "/vendor/autoload.php";

try {
    (new DIC())
        ->injectParameters(dirname(__FILE__, 2) . '/config/parameters.yaml')
        ->run(dirname(__FILE__, 2) . "/src");
} catch (ReflectionException $e) {
    echo 'DIC Error: ' . $e->getMessage();
}

try {
    (new Router())
        ->getRoutesFromAttributes(dirname(__FILE__, 2) . "/src/Controllers")
        ->run();
} catch (ReflectionException $e) {
    echo 'Router Error: ' . $e->getMessage();
}

