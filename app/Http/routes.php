<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
| post,get ,put ,delete
*/
Route::get('controlador', 'PruebaController@index');
Route::resource('movie', 'MovieController');

Route::get('prueba', function(){
		 return "holo desde routes.php";
});




Route::get('reviews', 'FrontController@reviews');




/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::get('password/email','Auth\PasswordController@getEmail');
Route::post('password/email','Auth\PasswordController@postEmail');

Route::get('password/reset/{token}','Auth\PasswordController@getReset');
Route::post('password/reset','Auth\PasswordController@postReset');


Route::group(['middleware' => ['web']], function () {
  //este route se puso aqui para que la variable session flash sea vigente en 
	//el proximo request
	Route::get('/', 'FrontController@index');
	Route::get('admin', 'FrontController@admin');
	Route::resource('log','LogController');
	Route::resource('usuario','UsuarioController');	
	Route::get('logout','LogController@logout');

	Route::resource('genero','GeneroController');	
	Route::resource('pelicula','MovieController');
	Route::resource('mail','MailController');
	Route::get('contacto', 'FrontController@contacto');

	
//	Route::auth();	

Route::get('/home', 'HomeController@index');


});

Route::auth();	

Route::get('/home', 'FrontController@admin');
