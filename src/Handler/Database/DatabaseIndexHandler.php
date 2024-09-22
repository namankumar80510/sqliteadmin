<?php

declare(strict_types=1);

namespace App\Handler\Database;

use App\Library\Database\Sleek;
use App\Library\View\ViewInterface;
use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class DatabaseIndexHandler
{

    public function __construct(private ViewInterface $renderer, private Sleek $sleek) {}

    public function __invoke(ServerRequestInterface $request): ResponseInterface
    {
        $databases = $this->sleek->getDatabases();
        return new HtmlResponse($this->renderer->render('database/index', ['databases' => $databases]));
    }
}
