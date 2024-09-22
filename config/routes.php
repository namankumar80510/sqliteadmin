<?php

use App\Handler\Auth\LoginHandler;
use App\Handler\Auth\LogoutHandler;
use App\Handler\Database\DatabaseCreateHandler;
use App\Handler\Database\DatabaseIndexHandler;
use App\Handler\Database\DatabaseStructureCreateHandler;
use App\Handler\Database\DatabaseStructureHandler;
use App\Handler\Database\TableDataHandler;
use App\Handler\Database\TableEditHandler;
use App\Handler\Database\TableEditUpdateHandler;
use App\Handler\Query\QueryIndexHandler;
use App\Handler\Query\QueryRunHandler;
use App\Middleware\AuthMiddleware;

return [
    // global middlewares
    'middlewares' => [
        new AuthMiddleware(),
    ],
    // routes
    'routes' => [
        // database
        '/' => [
            'handler' => DatabaseIndexHandler::class,
            'method' => 'GET',
        ],
        '/database/create' => [
            'handler' => DatabaseCreateHandler::class,
            'method' => 'POST',
        ],
        '/database/{databaseName}/structure' => [
            'handler' => DatabaseStructureHandler::class,
            'method' => 'GET',
        ],
        '/database/{databaseName}/structure/create' => [
            'handler' => DatabaseStructureCreateHandler::class,
            'method' => 'POST',
        ],
        '/database/{databaseName}/table/{tableName}/edit' => [
            'handler' => TableEditHandler::class,
            'method' => 'GET',
        ],
        '/database/{databaseName}/table/{tableName}/update' => [
            'handler' => TableEditUpdateHandler::class,
            'method' => 'POST',
        ],
        '/database/{databaseName}/table/{tableName}/data' => [
            'handler' => TableDataHandler::class,
            'method' => 'GET',
        ],
        
        // query
        '/query' => ['handler' => QueryIndexHandler::class],
        '/query/run' => ['handler' => QueryRunHandler::class, 'method' => 'POST'],

        // auth
        '/login' => ['handler' => LoginHandler::class],
        '/login/post' => ['handler' => LoginHandler::class, 'method' => 'POST'],
        '/logout' => ['handler' => LogoutHandler::class],
    ]
];
