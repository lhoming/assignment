<?php
use Slim\Factory\AppFactory;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Routing\RouteContext;


$app = AppFactory::create();
$app->setBasePath("/assignment1");

$app->get('/', "App\Controllers\HomeController:index");
$app->get('/login', "App\Controllers\Auth\LoginController:getLogin")->setName('get-login');
$app->post('/login', "App\Controllers\Auth\LoginController:login");
$app->post('/logout', "App\Controllers\Auth\LoginController:logout");

$app->get('/verified', "App\Controllers\Home\DashboardController:verified")->setName('verified');
$app->get('/verify-2FA', "App\Controllers\Home\DashboardController:verify")->setName('verify');
$app->get('/dashboard', "App\Controllers\Home\DashboardController:index")->setName('dashboard');

$app->addErrorMiddleware(false, true, true);


$app->run();