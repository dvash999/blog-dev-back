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

Route::resource('admin/posts',      'PostController', ['except' => ['create', 'edit']]);
Route::resource('admin/users',      'UserController', ['except' => ['create', 'edit']]);
Route::resource('posts',            'PostController', ['except' => ['create', 'edit']]);
Route::resource('tech-news/posts',  'PostController', ['except' => ['create', 'edit']]);
Route::resource('likes',            'LikeController', ['except' => ['create', 'edit']]);
Route::get('likes/{type}/{typeID}', 'LikeController@getLikesByTypeAndId');

Route::name('verify')->get('admin/users/verify/{token}', 'UserController@verify');
Route::name('resend')->get('admin/users/resend/{token}', 'UserController@resend');
