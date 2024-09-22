<?php

use App\Library\Database\Sleek;
use App\Library\Database\Sqlite;
use App\Library\View\LeaguePlatesRenderer;
use App\Library\View\ViewInterface;

return [

    ViewInterface::class => LeaguePlatesRenderer::class,
    Sleek::class => Sleek::class,
    Sqlite::class => Sqlite::class,

];
