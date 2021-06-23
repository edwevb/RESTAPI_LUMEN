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
	// return $router->app->version();
	return response()->json(['message' => 'REST API KA20']);
});
$router->group(['prefix' => 'api/'], function () use ($router){
	$router->post("/register", "AuthController@register");
	$router->post("/login", "AuthController@authenticate");
	$router->get('/mahasiswa', 'MahasiswaController@index');
	$router->get('/mahasiswa/{id}', 'MahasiswaController@show');
});

$router->group(['prefix'=>'api/', 'middleware' => 'auth'],
	function () use ($router){
		$router->post('/mahasiswa', 'MahasiswaController@store');
		$router->put('/mahasiswa/{id}', 'MahasiswaController@update');
		$router->delete('/mahasiswa/{id}', 'MahasiswaController@destroy');
		// $router->get('/mahasiswa/detail', 'MahasiswaController@detail');
		$router->post('/mahasiswa/detail/{id}', 'MahasiswaController@detailCreate');
	});

