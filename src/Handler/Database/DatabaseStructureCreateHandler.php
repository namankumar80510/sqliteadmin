<?php

namespace App\Handler\Database;

use App\Library\Database\Sqlite;
use App\Library\Session\Flash;
use Laminas\Diactoros\Response\JsonResponse;
use Nette\Utils\FileSystem;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class DatabaseStructureCreateHandler
{

    public function __construct(
        private Sqlite $sqlite,
    ) {}

    public function __invoke(ServerRequestInterface $request, $args): ResponseInterface
    {
        $data = json_decode($request->getBody()->getContents(), true);
        if ($data === null && json_last_error() !== JSON_ERROR_NONE) {
            return new JsonResponse(['success' => false, 'error' => 'Invalid JSON data'], 400);
        }

        if (!isset($data['tableName']) || !isset($data['columns']) || !is_array($data['columns'])) {
            return new JsonResponse(['success' => false, 'error' => 'Missing required data'], 400);
        }

        $databaseName = $args['databaseName'];
        $tableName = $data['tableName'];
        $columns = $data['columns'];

        foreach ($columns as $column) {
            if (!isset($column['name']) || !isset($column['type'])) {
                return new JsonResponse(['success' => false, 'error' => 'Invalid column data'], 400);
            }
        }

        try {
            $this->sqlite->createTable($databaseName, $tableName, $columns);
            Flash::set('success', "Table '{$tableName}' created successfully");
            return new JsonResponse(['success' => true]);
        } catch (\Exception $e) {
            return new JsonResponse(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }
}
