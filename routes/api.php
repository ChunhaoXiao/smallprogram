<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('login', 'LoginController@login');
Route::get('/profile', 'UserProfileController@index');
//Route::put('/user', );

Route::any('post/upload', 'UploadController@store');
Route::post('/post', 'PostController@store');
Route::get('/posts', 'PostController@index');

//Route::get('user/{user}', 'PostController@show');
Route::post('/favorite', 'FavoriteController@store');

Route::put('/user', 'UserProfileController@update');

Route::resource('/users', 'UserController')->only(['index','show']);

Route::get('/favorites', 'FavoriteController@index');
Route::put('/favorites', 'FavoriteController@update');
Route::put('messages', 'MessageController@update');
Route::resource('messages', 'MessageController')->only('index', 'show', 'store', 'destroy');
Route::resource('blacklists', 'BlacklistController');

Route::post('/collects', 'CollectController@store');
Route::get('/collects', 'CollectController@index');
// Route::post('messages', 'MessageController@store');
// Route::get('messages', 'MessageController@index');
// Route::delete('messages/{id}', 'MessageController@destroy');

