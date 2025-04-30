<?php

namespace Router;

$router = new Router();
require BASE_PATH . "src/Router/routes.php";

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

$router->route($uri, $method);
