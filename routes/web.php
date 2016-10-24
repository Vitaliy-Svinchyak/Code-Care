<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', 'IndexController@showIndex');
Route::get('/getInfo', 'IndexController@getInfo');

Route::resource('word', 'WordController',
    ['only' => ['store']]);
Route::resource('word/find', 'WordController@find');

Route::resource('hash', 'HashController',
    ['only' => ['store', 'index', 'show']]);