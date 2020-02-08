<?php

use Illuminate\Http\Request;
//use Illuminate\Routing\Route;
use app\Http\Controllers\AdminLoginController;
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

Route::resource('admin/posts',                              'PostController', ['except' => ['create', 'edit']]);
Route::post('admin/posts/{postId}/updatePost',               'PostController@update');
Route::resource('admin/users',                              'UserController', ['except' => ['create', 'edit']]);
Route::post('admin/login',                                  'AdminLoginController@login');
Route::post('admin/createAdmin',                            'AdminLoginController@createAdmin');
Route::post('admin/auth',                                   'AdminLoginController@authAdmin');


Route::resource('posts',                                    'PostController', ['except' => ['create', 'edit']]);
Route::resource('tech-news/posts',                          'PostController', ['except' => ['create', 'edit']]);
Route::post('likes',                                        'LikeController@addLike');
Route::post('email',                                        'EmailController@sendEmail');
Route::get('likes/{type}/{typeID}',                         'LikeController@getLikesByTypeAndId');
Route::get('search/{query}',                                'SearchController@searchPosts');;

Route::name('verify')->get('admin/users/verify/{token}',    'UserController@verify');
Route::name('resend')->get('admin/users/resend/{token}',    'UserController@resend');
