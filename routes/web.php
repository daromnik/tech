<?php

Route::get("/", "Users\AuthController@index")->name("login");

//Route::post("/", "Users\AuthController@login");

//Route::get("/logout", "Users\AuthController@logout")->name("logout");


Route::post('/login', 'Users\AuthController@login')->name("auth");
Route::post('/logout', 'Users\AuthController@logout')->name('logout');
Route::post('/register', 'Users\UsersController@register')->name('register');;

Route::resource("/users", "Users\UsersController");
Route::resource("/roles", "Users\RolesController");

Route::resource("/projects", "Projects\ProjectController");

Route::resource("/groups", "Projects\GroupController");

Route::resource("/indicators", "Projects\IndicatorController");

Route::post("/queries/load", "Projects\QueryController@loadQueries")->name("loadQueries");

Route::get("/settings", "Settings\SettingsController@index")->name("settings");

//Auth::routes();
