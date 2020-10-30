<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/
$router->post('/auth/login', 'AuthController@login');
$router->post('/auth/register', 'AuthController@store');
$router->post('/auth/logout', 'AuthController@logout');
$router->post('/auth/refresh', 'AuthController@refresh');
$router->post('/auth/token', 'AuthController@respondWithToken');
$router->post('/auth/me', 'AuthController@me');

$router->get('/teste', 'ExampleController@getAll');

$router->get('/', function () use ($router) {
    return $router->app->version();
});
