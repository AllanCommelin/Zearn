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
Route::get('/admin/create/user', 'AdminController@createUser')->name('create_user');
Route::post('/admin/store/user', 'AdminController@storeUser')->name('store_user');
Route::get('/admin/edit/user/{user}', 'AdminController@editUser');
Route::put('/admin/edit/user/{user}', 'AdminController@updateUser')->name('update_user');
Route::delete('/admin/edit/user/{user}', 'AdminController@deleteUser')->name('delete_user');
Route::get('/admin/create/lesson', 'AdminController@createLesson')->name('create_lesson');
Route::post('/admin/create/lesson', 'AdminController@storeLesson')->name('store_lesson');
Route::get('/admin/edit/lesson/{lesson}', 'AdminController@editLesson');
Route::put('/admin/edit/lesson/{lesson}', 'AdminController@updateLesson');
Route::post('/admin/session', 'AdminController@createSession')->name('create_session');
Route::delete('/admin/lesson/{lesson}', 'AdminController@deleteLesson')->name('delete_lesson');

//Student routes
Route::get('/student/home', 'StudentController@homeStudent')->name('homeStudent');
Route::get('/student/sessions', 'StudentController@studentSessions')->name('studentSessions');
Route::get('/student/lesson/{lesson}', 'StudentController@lessonSessions')->name('lessonSessions');
Route::post('/student/session/subscribe', 'StudentController@sessionSubscribe')->name('sessionSubscribe');
Route::delete('/student/session/unsubscribe/{id}', 'StudentController@sessionUnsubscribe')->name('sessionUnsubscribe');

//Professor routes
Route::get('/lesson', 'ProfessorController@index')->name('professor.index');
Route::get('/lesson/{lesson}', 'ProfessorController@single')->name('professor.single');
Route::post('/lesson/{lesson}/session/student-session/{studentSession}', 'ProfessorController@handleMark')->name('professor.handle_mark');
Route::post('/lesson/{lesson}/session/{session}', 'ProfessorController@handleReport')->name('professor.handle_report');
