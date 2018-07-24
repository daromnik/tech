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

//Route::get('/', function () {
//    return view('welcome');
//});
//Route::get('/contacts/', 'ContactsController@index');
//Route::post('/contacts/', 'ContactsController@store');

Route::get("/", "Users\AuthController@index");

Route::post("/", "Users\AuthController@login");

Route::get("/users/", "Users\UsersController@list")->name("userList");

Route::get("/users/add/", "Users\UsersController@add");

Route::post("/users/add/", "Users\UsersController@addPost");