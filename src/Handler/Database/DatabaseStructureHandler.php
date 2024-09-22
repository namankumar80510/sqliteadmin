<?php

declare(strict_types=1);

namespace App\Handler\Database;

use App\Library\Database\Sqlite;
use App\Library\View\ViewInterface;
use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class DatabaseStructureHandler
{
    public function __construct(
        private Sqlite $sqlite,
        private ViewInterface $renderer
    ) {}

    public function __invoke(ServerRequestInterface $request): ResponseInterface
    {
        $databaseName = $request->getAttribute('databaseName');
        $databasePath = $this->getDatabasePath($databaseName);

        $connection = $this->sqlite->getConnection($databasePath);

        $tables = $this->getTables($connection);
        $tableStructures = $this->getTableStructures($connection, $tables);

        return new HtmlResponse($this->renderer->render('database/structure', [
            'databaseName' => $databaseName,
            'tables' => $tables,
            'tableStructures' => $tableStructures,
        ]));
    }

    private function getDatabasePath(string $databaseName): string
    {
        return $this->sqlite->getDatabasePath($databaseName);
    }

    private function getTables(\Dibi\Connection $connection): array
    {
        return $connection->query("SELECT name FROM sqlite_master WHERE type='table' AND name NOT LIKE 'sqlite_%'")->fetchAll();
    }

    private function getTableStructures(\Dibi\Connection $connection, array $tables): array
    {
        $structures = [];
        foreach ($tables as $table) {
            $structures[$table->name] = $connection->query("PRAGMA table_info(?)", $table->name)->fetchAll();
        }
        return $structures;
    }
}
