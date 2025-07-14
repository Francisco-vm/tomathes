<?php

require_once __DIR__ . '/../app/core/app.php';

use App\Core\Router;

$router = new Router();
$router->dispatch();