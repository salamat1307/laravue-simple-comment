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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/comments', 'CommentController@getIndex');
Route::post('/comments', 'CommentController@postComment');
Route::post('/comments/delete/{id}', 'CommentController@postDelete');
Route::post('/comments/update/{id}', 'CommentController@postUpdate');
