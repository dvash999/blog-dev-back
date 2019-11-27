<?php

use Illuminate\Http\Request;
use app\Http\Controllers\PostController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::resource('admin/posts', 'PostController', ['except' => ['create', 'edit']]);
Route::resource('admin/users', 'UsersController', ['except' => ['create', 'edit']]);
Route::name('verify')->get('admin/users/verify/{token}', 'UsersController@verify');
Route::name('resend')->get('admin/users/resend/{token}', 'UsersController@resend');
