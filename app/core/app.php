<?php

require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../helpers/markdown.php';


use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
$dotenv->load();

date_default_timezone_set($_ENV['APP_TIMEZONE'] ?? 'UTC');

if (($_ENV['APP_ENV'] ?? 'production') === 'local') {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
} else {
    ini_set('display_errors', 0);
    error_reporting(0);
}