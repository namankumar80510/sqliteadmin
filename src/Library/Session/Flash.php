<?php

declare(strict_types=1);

namespace App\Library\Session;

class Flash
{
    private const FLASH_KEY = '_flash';

    public static function set(string $key, $value): void
    {
        if (!isset($_SESSION[self::FLASH_KEY])) {
            $_SESSION[self::FLASH_KEY] = [];
        }
        $_SESSION[self::FLASH_KEY][$key] = $value;
    }

    public static function get(string $key, $default = null)
    {
        if (isset($_SESSION[self::FLASH_KEY][$key])) {
            $value = $_SESSION[self::FLASH_KEY][$key];
            unset($_SESSION[self::FLASH_KEY][$key]);
            return $value;
        }
        return $default;
    }

    public static function has(string $key): bool
    {
        return isset($_SESSION[self::FLASH_KEY][$key]);
    }

    public static function all(): array
    {
        $flash = $_SESSION[self::FLASH_KEY] ?? [];
        $_SESSION[self::FLASH_KEY] = [];
        return $flash;
    }

    public static function clear(): void
    {
        $_SESSION[self::FLASH_KEY] = [];
    }
}
