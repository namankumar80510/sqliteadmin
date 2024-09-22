<?php

declare(strict_types=1);

namespace App;

use App\Handler\Auth\LoginHandler;
use App\Library\Router\RoutingStrategy;
use App\Library\View\LeaguePlatesRenderer;
use App\Library\View\ViewInterface;
use Dikki\DotEnv\DotEnv;
use Laminas\Diactoros\ServerRequestFactory;
use Laminas\HttpHandlerRunner\Emitter\SapiEmitter;
use League\Route\Router;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Tracy\Debugger;

class Bootstrap
{
    public static function run(): void
    {
        self::loadEnvironment();
        self::createDirectories();
        self::configureDebugger();
        $container = self::buildContainer();
        $request = ServerRequestFactory::fromGlobals();
        $router = self::configureRouter($container);
        $response = $router->dispatch($request);
        self::emitResponse($response);
    }

    private static function loadEnvironment(): void
    {
        (new DotEnv(dirname(__DIR__)))->load();
    }

    private static function createDirectories(): void
    {
        foreach (config('paths') as $key => $path) {
            if (!file_exists($path)) {
                mkdir($path, 0755, true);
            }
        }
    }

    private static function configureDebugger(): void
    {
        $debuggerMode = env('APP_ENV', 'production') === 'development' ? Debugger::Development : Debugger::Production;
        Debugger::enable($debuggerMode, config('paths.logs'));
    }

    private static function buildContainer(): ContainerBuilder
    {
        $container = new ContainerBuilder();
        $container->setParameter('paths', config('paths'));
        $services = config('services');
        foreach ($services as $name => $class) {
            $container->register($name, $class)->setPublic(true)->setAutowired(true);
        }
        foreach (config('routes.routes') as $route) {
            $container->autowire($route['handler'], $route['handler'])->setPublic(true)->setAutowired(true);
        }
        $container->compile();
        return $container;
    }

    private static function configureRouter(ContainerBuilder $container): Router
    {
        $router = new Router();
        $strategy = new RoutingStrategy();
        $strategy->setContainer($container);
        $router->setStrategy($strategy);
        if (config('routes.middlewares')) {
            $router->middlewares(config('routes.middlewares'));
        }

        foreach (config('routes.routes') as $path => $route) {
            $router->map(
                $route['method'] ?? 'GET',
                $path,
                $route['handler']
            )->middlewares($route['middlewares'] ?? []);
        }

        return $router;
    }

    private static function emitResponse($response): void
    {
        (new SapiEmitter())->emit($response);
    }
}
