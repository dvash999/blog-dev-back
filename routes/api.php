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

Route::resource('admin/manage-posts', 'PostController', ['except' => ['create', 'edit']]);
Route::resource('admin/manage-users', 'ManageUsersController', ['except' => ['create', 'edit']]);
Route::name('verify')->get('admin/users/verify/{token}', 'ManageUsersController@verify');
Route::name('resend')->get('admin/users/resend/{token}', 'ManageUsersController@resend');
