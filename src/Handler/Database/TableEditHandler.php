<?php

declare(strict_types=1);

namespace App\Handler\Database;

use App\Library\Database\Sqlite;
use App\Library\View\ViewInterface;
use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class TableEditHandler
{
    public function __construct(
        private Sqlite $sqlite,
        private ViewInterface $renderer
    ) {}

    public function __invoke(ServerRequestInterface $request): ResponseInterface
    {
        $databaseName = $request->getAttribute('databaseName');
        $tableName = $request->getAttribute('tableName');
        $databasePath = $this->getDatabasePath($databaseName);

        $connection = $this->sqlite->getConnection($databasePath);

        $tableStructure = $this->getTableStructure($connection, $tableName);

        return new HtmlResponse($this->renderer->render('database/table_edit', [
            'databaseName' => $databaseName,
            'tableName' => $tableName,
            'tableStructure' => $tableStructure,
        ]));
    }

    private function getDatabasePath(string $databaseName): string
    {
        return $this->sqlite->getDatabasePath($databaseName);
    }

    private function getTableStructure(\Dibi\Connection $connection, string $tableName): array
    {
        return $connection->query("PRAGMA table_info(?)", $tableName)->fetchAll();
    }
}
