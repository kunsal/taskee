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

Route::get('/user/register', 'UserController@showRegistrationPage');
Route::post('/user/register', 'UserController@register');

Route::get('user/login', 'UserLoginController@showLoginPage')->name('login');
Route::post('user/login', 'UserLoginController@login');

Route::group(['middleware' => 'auth'], function(){
    Route::get('tasks', 'TaskController@index');
    Route::get('tasks/create', 'TaskController@create');
    Route::post('tasks/create', 'TaskController@store');
    Route::get('tasks/edit/{task}', 'TaskController@edit');
    Route::put('tasks/edit/{task}', 'TaskController@update');
    Route::patch('tasks/status/{task}/{status}', 'TaskController@updateStatus');
});

