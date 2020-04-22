<?php

use Illuminate\Support\Facades\Route;

Route::get('login', 'LoginController@index')->name('login');
Route::post('login', 'LoginController@login')->name('postLogin');
Route::get('logout', 'LoginController@logout')->name('logout');

Route::middleware('admin.auth')->group(function () {
    Route::get('/', 'IndexController@index')->name('home');
    Route::get('profile', 'ProfileController@index')->name('profile.index');
    Route::post('profile', 'ProfileController@update')->name('profile.update');
    Route::resource('auth_permission', 'AuthPermissionController');
    Route::resource('auth_role', 'AuthRoleController');
    Route::get('auth_role_permission/{auth_role}', 'AuthRolePermissionController@index')->name('auth_role_permission.index');
    Route::post('auth_role_permission/{auth_role}', 'AuthRolePermissionController@update')->name('auth_role_permission.update');
    Route::resource('admin', 'AdminController');
    Route::resource('admin_menu', 'AdminMenuController');
    Route::resource('user', 'UserController');
});
