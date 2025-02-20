<?php

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../src/Router/Router.php';

use App\Router\Router;

$router = new Router();

$router->addRoute('GET', '/', 'HomeController@index');
$router->addRoute('GET', '/about', 'HomeController@about');

$router->addRoute('GET', '/user/{id}', 'HomeController@user');
$router->addRoute('GET', '/post/{id}/{slug}', 'HomeController@post');

$router->addRoute('POST', '/about/test', 'AboutController@test');

$method = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

$router->dispatch($method, $uri);
