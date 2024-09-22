<?php

declare(strict_types=1);

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
ini_set('error_reporting', E_ALL);

require_once dirname(__DIR__) . '/vendor/autoload.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

date_default_timezone_set(config('app.timezone'));

App\Bootstrap::run();
