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



$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->post('/auth/login', 'AuthController@login');


$router->group(['middleware' => 'auth'], function () use ($router) {
    $router->get('/usuario', "AuthController@getAll");
    $router->post('/auth/register', 'AuthController@store');
    $router->put('/auth/register/{id}', 'AuthController@update');
    $router->put('/auth/register/password/{id}', 'AuthController@updatePassword');
    $router->post('/auth/logout', 'AuthController@logout');
    $router->post('/auth/refresh', 'AuthController@refresh');
    $router->post('/auth/token', 'AuthController@respondWithToken');
    $router->post('/auth/me', 'AuthController@me');
   
    $router->get('/auth/usuario/{id}', "AuthController@get");
    $router->delete('/auth/usuario/destroy/{id}', "AuthController@destroy");
});
