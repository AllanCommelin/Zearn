<?php

use Illuminate\Support\Facades\Auth;
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


/*
 |
 | Student Controller Routes
 |
 */
Route::get('/student/home', 'StudentController@homeStudent')->name('homeStudent');
Route::get('/student/sessions', 'StudentController@studentSessions')->name('studentSessions');
Route::get('/student/lesson/{lesson}', 'StudentController@lessonSessions')->name('lessonSessions');
Route::post('/student/session/subscribe', 'StudentController@sessionSubscribe')->name('sessionSubscribe');
Route::delete('/student/session/unsubscribe/{id}', 'StudentController@sessionUnsubscribe')->name('sessionUnsubscribe');

/* --------------------------- SESSION CONTROLLER --------------------------- */

Route::get('/lesson/{lesson}', 'ProfessorController@single')->name('professor.single');
Route::post('/lesson/{lesson}/session/student-session/{studentSession}', 'ProfessorController@handleMark')->name('professor.handle_mark');
Rout
