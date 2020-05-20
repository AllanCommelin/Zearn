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

/* --------------------------- SESSION CONTROLLER --------------------------- */

Route::get('/lesson/{lesson}', 'ProfessorController@single')->name('professor.single');
Route::post('/lesson/{lesson}/session/student-session/{studentSession}', 'ProfessorController@handleMark')->name('professor.handle_mark');
Route::post('/lesson/{lesson}/session/{session}', 'ProfessorController@handleReport')->name('professor.handle_report');