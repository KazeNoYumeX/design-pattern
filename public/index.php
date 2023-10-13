<?php

declare(strict_types=1);

use App\HelloWorld;
use App\MainPage;
use DI\ContainerBuilder;
use FastRoute\RouteCollector;
use Laminas\Diactoros\Response;
use Laminas\Diactoros\ServerRequestFactory;
use Middlewares\FastRoute;
use Middlewares\RequestHandler;
use Narrowspark\HttpEmitter\SapiEmitter;
use Relay\Relay;

use function DI\create;
use function DI\get;
use function FastRoute\simpleDispatcher;

require_once dirname(__DIR__).'/vendor/autoload.php';

$containerBuilder = new ContainerBuilder();
$containerBuilder->useAutowiring(false);
$containerBuilder->addDefinitions([
    MainPage::class => create(MainPage::class)
        ->constructor(get('Response')),
    HelloWorld::class => create(HelloWorld::class)
        ->constructor(get('Response')),
    'Response' => function () {
        return new Response();
    },
]);

/** @noinspection PhpUnhandledExceptionInspection */
$container = $containerBuilder->build();

$routes = simpleDispatcher(function (RouteCollector $r) {
    $r->get('/', MainPage::class);
    $r->get('/hello', HelloWorld::class);
});

$middlewareQueue[] = new FastRoute($routes);
$middlewareQueue[] = new RequestHandler($container);

/** @noinspection PhpUnhandledExceptionInspection */
$requestHandler = new Relay($middlewareQueue);
$response = $requestHandler->handle(ServerRequestFactory::fromGlobals());

$emitter = new SapiEmitter();

/** @noinspection PhpVoidFunctionResultUsedInspection */
return $emitter->emit($response);
