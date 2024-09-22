<?php

declare(strict_types=1);

namespace App\Middleware;

use App\Library\Session\Session;
use Laminas\Diactoros\Response\RedirectResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class AuthMiddleware implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $allowedRoutes = ['/login'];
        $continue = $handler->handle($request);

        if (Session::has('user_id') || in_array($request->getUri()->getPath(), $allowedRoutes)) {
            return $continue;
        }

        return new RedirectResponse('/login');
    }
}
