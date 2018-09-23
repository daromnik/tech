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

Route::group([], function()
{
    Route::get("/", "Users\AuthController@index")->name("login");

    Route::post("/", "Users\AuthController@login");

    Route::get("/logout", "Users\AuthController@logout")->name("logout");
});

Route::prefix("users")->group(function()
{
    Route::get("/", "Users\UsersController@list")->name("userList");

    Route::get("add", "Users\UsersController@add")->name("userAdd");

    Route::post("add", "Users\UsersController@addPost");

    Route::get("edit/{id}", "Users\UsersController@edit")->name("userEdit");

    Route::post("edit/{id}", "Users\UsersController@editPost");

    Route::get("delete/{id}", "Users\UsersController@delete")->name("userDelete");
});

Route::prefix("roles")->group(function()
{
    Route::get("/", "Users\RolesController@list")->name("roleList");

    Route::get("add", "Users\RolesController@add")->name("roleAdd");

    Route::post("add", "Users\RolesController@addPost");

    Route::get("edit/{id}", "Users\RolesController@edit")->name("roleEdit");

    Route::post("edit/{id}", "Users\RolesController@editPost");

    Route::get("delete/{id}", "Users\RolesController@delete")->name("roleDelete");
});

Route::resource("/projects", "Projects\ProjectController");
Route::resource("/groups", "Projects\GroupController");

Route::post("/queries/load", "Projects\QueryController@loadQueries")->name("loadQueries");

Route::get("/settings", "Settings\SettingsController@index")->name("settings");
