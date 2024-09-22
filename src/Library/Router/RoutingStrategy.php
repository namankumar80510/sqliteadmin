<?php

declare(strict_types=1);

namespace App\Library\Router;

use App\Middleware\NotFoundMiddleware;
use League\Route\Strategy\ApplicationStrategy;
use Psr\Http\Server\MiddlewareInterface;
use League\Route\Http\Exception\NotFoundException;

class RoutingStrategy extends ApplicationStrategy
{
    public function getNotFoundDecorator(NotFoundException $exception): MiddlewareInterface
    {
        return new NotFoundMiddleware();
    }
}
