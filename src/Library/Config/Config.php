<?php

declare(strict_types=1);

namespace App\Library\Config;

use Dikki\Config\Config as DikkiConfig;
use Dikki\Config\PhpArrayParser;

class Config
{

    private static ?DikkiConfig $instance = null;

    public static function getInstance(): DikkiConfig
    {
        if (self::$instance === null) {
            self::$instance = new DikkiConfig(new PhpArrayParser(dirname(__DIR__, 3) . '/config'));
        }
        return self::$instance;
    }

    public static function get(string $key): mixed
    {
        return self::getInstance()->get($key);
    }
}
