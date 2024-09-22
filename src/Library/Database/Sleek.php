<?php

declare(strict_types=1);

namespace App\Library\Database;

use App\Enum\SleekEnum;
use SleekDB\Store;

class Sleek
{
    public function getSleekDb(SleekEnum $name): Store
    {
        return new Store($name->value, config('paths.sleekdb'), ['timeout' => false]);
    }

    public function getUser(string $username): array
    {
        return $this->getSleekDb(SleekEnum::USERS)->findOneBy(['username', '=', $username]);
    }

    public function createUser(string $username, string $password): void
    {
        $this->getSleekDb(SleekEnum::USERS)->insert(['username' => $username, 'password' => $password]);
    }

    public function getDatabases(): array
    {
        return $this->getSleekDb(SleekEnum::DATABASES)->findAll();
    }

    public function getDatabase(string $name): array
    {
        return $this->getSleekDb(SleekEnum::DATABASES)->findOneBy(['name', '=', $name]);
    }

    public function createDatabase(string $name, string $path): void
    {
        $this->getSleekDb(SleekEnum::DATABASES)->insert(['name' => $name, 'path' => $path]);
    }
}
