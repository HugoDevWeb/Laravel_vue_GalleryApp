<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::resource('album', 'AlbumController')->only([
    'index', 'show', 'store'
]);

Route::get('photo/download/{id}', 'PhotoController@download');
Route::resource('photo', 'PhotoController')->only([
    'store'
]);

Route::prefix('auth')->group(function () {
    Route::post('login', 'UserController@login');
    Route::post('register', 'UserController@register');
    Route::post('logout', 'UserController@logout');
    Route::get('init', 'UserController@init');
});
