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

Route::prefix("users")->group(function()
{
    Route::get("/", "Users\UsersController@list")->name("userList");

    Route::get("add", "Users\UsersController@add")->name("userAdd");

    Route::post("add", "Users\UsersController@addPost");

    Route::get("update/{id}", "Users\UsersController@update")->name("userUpdate");

    Route::post("update/{id}", "Users\UsersController@updatePost");
});