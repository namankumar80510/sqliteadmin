<?php

namespace App\Handler\Query;

use App\Handler\AbstractHandler;
use App\Library\Database\Sleek;
use App\Library\View\ViewInterface;
use Laminas\Diactoros\Response\HtmlResponse;

class QueryIndexHandler
{

    public function __construct(private readonly ViewInterface $renderer, private readonly Sleek $sleek)
    {
    }

    public function __invoke()
    {
        $databases = $this->sleek->getDatabases();
        return new HtmlResponse($this->renderer->render('query/index', ['databases' => $databases]));
    }
}
