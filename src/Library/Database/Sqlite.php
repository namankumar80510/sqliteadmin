<?php

declare(strict_types=1);

namespace App\Library\Database;

use Dibi\Connection;

class Sqlite
{

    public function __construct(private Sleek $sleek) {}

    public function getConnection(string $databasePath): Connection
    {
        return new Connection([
            'driver' => 'sqlite',
            'database' => $databasePath,
        ]);
    }

    public function getDatabasePath(string $databaseName): string
    {
        return $this->sleek->getDatabase($databaseName)['path'];
    }

    public function createTable(string $databaseName, string $tableName, array $columns): void
    {
        $connection = $this->getConnection($this->getDatabasePath($databaseName));
        
        $sql = "CREATE TABLE IF NOT EXISTS `$tableName` (";
        $columnDefinitions = [];
        
        foreach ($columns as $column) {
            $def = "`{$column['name']}` {$column['type']}";
            
            if (!$column['nullable']) {
                $def .= " NOT NULL";
            }
            
            if (isset($column['defaultValue']) && $column['defaultValue'] !== '') {
                $def .= " DEFAULT " . $connection->quote($column['defaultValue']);
            }
            
            if ($column['primaryKey']) {
                $def .= " PRIMARY KEY";
            }
            
            $columnDefinitions[] = $def;
        }
        
        $sql .= implode(', ', $columnDefinitions) . ")";
        
        $connection->query($sql);
    }

}
