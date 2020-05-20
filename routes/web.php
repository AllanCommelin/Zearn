<?php

use Illuminate\Support\Facades\Route;

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

//Admin routes
Route::get('/admin/home', 'AdminController@index')->name('home_admin');
Route::get('/admin/edit/{user}', 'AdminController@editUser');
Route::put('/admin/edit/user/{user}', 'AdminController@updateUser');
Route::delete('/admin/edit/user/{user}', 'AdminController@deleteUser');