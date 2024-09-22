<?php

declare(strict_types=1);

use App\Library\Config\Config;
use App\Library\Session\Session;

if (!function_exists('env')) {
    function env(string $key, mixed $default = null): mixed
    {
        return $_ENV[$key] ?? $default;
    }
}

if (!function_exists('config')) {
    function config(string $key): mixed
    {
        return Config::get($key);
    }
}

if (!function_exists('is_logged_in' )) {
    function is_logged_in(): bool
    {
        return Session::get('user_id') !== null;
    }
}
