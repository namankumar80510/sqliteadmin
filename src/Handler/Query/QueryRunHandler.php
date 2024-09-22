<?php

declare(strict_types=1);

namespace App\Handler\Query;

use App\Library\Database\Sleek;
use App\Library\Database\Sqlite;
use App\Library\Session\Flash;
use App\Library\View\ViewInterface;
use Laminas\Diactoros\Response\HtmlResponse;
use Laminas\Diactoros\Response\RedirectResponse;

class QueryRunHandler
{
    public function __construct(
        private readonly Sqlite $sqlite,
        private readonly Sleek $sleek,
        private readonly ViewInterface $renderer
    ) {}

    public function __invoke($request)
    {
        $data = $request->getParsedBody();
        if (empty($data['query'])) {
            Flash::set('error', 'No query provided');
            return new RedirectResponse('/query');
        }
        
        try {
            $connection = $this->sqlite->getConnection($this->sqlite->getDatabasePath($data['databaseName']));
            // Use the query method directly
            $result = $connection->query($data['query'])->fetchAll();
            
            $data['result'] = $result;
            Flash::set('success', 'Query executed successfully.');
        } catch (\Exception $e) {
            Flash::set('error', 'Query error: ' . $e->getMessage());
        }
        
        $data['title'] = "Run query";
        $data['databases'] = $this->sleek->getDatabases();
        return new RedirectResponse('/query');
    }
}
