<?php

declare(strict_types=1);

namespace App\Handler\Database;

use App\Library\Database\Sqlite;
use App\Library\Session\Flash;
use Laminas\Diactoros\Response\JsonResponse;
use Laminas\Diactoros\Response\RedirectResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class TableEditUpdateHandler
{
    public function __construct(
        private Sqlite $sqlite
    ) {}

    public function __invoke(ServerRequestInterface $request): ResponseInterface
    {
        $databaseName = $request->getAttribute('databaseName');
        $tableName = $request->getAttribute('tableName');
        $postData = $request->getParsedBody();

        try {
            $this->updateTable($databaseName, $tableName, $postData);
            Flash::set('success', "Table '{$tableName}' updated successfully");
        } catch (\Exception $e) {
            Flash::set('error', "Failed to update table: " . $e->getMessage());
        }

        // return json
        return new JsonResponse(['success' => true]);
    }

    private function updateTable(string $databaseName, string $tableName, array $postData): void
    {
        $connection = $this->sqlite->getConnection($this->sqlite->getDatabasePath($databaseName));

        // Start a transaction
        $connection->begin();

        try {
            // Create a new temporary table with the updated structure
            $newTableName = $tableName . '_new';
            $this->createNewTable($connection, $newTableName, $postData);

            // Copy data from the old table to the new table
            $this->copyTableData($connection, $tableName, $newTableName);

            // Drop the old table
            $connection->query("DROP TABLE IF EXISTS `$tableName`");

            // Rename the new table to the original table name
            $connection->query("ALTER TABLE `$newTableName` RENAME TO `$tableName`");

            // Commit the transaction
            $connection->commit();
        } catch (\Exception $e) {
            // Rollback the transaction if any error occurs
            $connection->rollback();
            throw $e;
        }
    }

    private function createNewTable(\Dibi\Connection $connection, string $tableName, array $postData): void
    {
        $sql = "CREATE TABLE `$tableName` (";
        $columnDefinitions = [];

        foreach ($postData['columns'] as $column) {
            $def = "`{$column['name']}` {$column['type']}";
            
            if (!isset($column['nullable']) || $column['nullable'] !== 'on') {
                $def .= " NOT NULL";
            }
            
            if (!empty($column['default'])) {
                $def .= " DEFAULT " . $connection->quote($column['default']);
            }
            
            if (isset($column['primary_key']) && $column['primary_key'] === 'on') {
                $def .= " PRIMARY KEY";
            }
            
            $columnDefinitions[] = $def;
        }

        $sql .= implode(', ', $columnDefinitions) . ")";
        $connection->query($sql);
    }

    private function copyTableData(\Dibi\Connection $connection, string $oldTable, string $newTable): void
    {
        $columns = $connection->query("PRAGMA table_info(`$oldTable`)")->fetchAll();
        $columnNames = array_column($columns, 'name');
        $columnList = implode(', ', array_map(fn($col) => "`$col`", $columnNames));

        $connection->query("INSERT INTO `$newTable` ($columnList) SELECT $columnList FROM `$oldTable`");
    }
}
