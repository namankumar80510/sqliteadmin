<?php

declare(strict_types=1);

namespace App\Handler\Database;

use App\Library\Database\Sleek;
use App\Library\Session\Flash;
use App\Library\View\ViewInterface;
use Laminas\Diactoros\Response\RedirectResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class DatabaseCreateHandler
{
    public function __construct(private Sleek $sleek, private ViewInterface $renderer) {}

    public function __invoke(ServerRequestInterface $request): ResponseInterface
    {
        $data = $request->getParsedBody();
        $data['dbName'] = str_replace(' ', '', $data['dbName']);
        $this->sleek->createDatabase($data['dbName'], $data['dbPath']);
        Flash::set('success', 'Database created successfully');
        return new RedirectResponse('/');
    }
}
