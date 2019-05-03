<?php

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

$router->group(['prefix' => 'api', 'middleware' => 'auth'], function () use ($router) {
  $router->post('admin/product',  ['uses' => 'ProductController@create']);
  $router->get('admin/product',  ['uses' => 'ProductController@showAllProducts']);

  $router->get('product',['uses' => 'ProductController@getProduct']);
});