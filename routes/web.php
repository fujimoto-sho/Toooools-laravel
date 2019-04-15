<?php

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

Auth::routes();

Route::get('home', 'ProfileController@index');

// プロフィール
Route::get('profile', 'ProfileController@index');

// 退会
Route::get('user/withdraw', 'UserController@withdraw');
Route::post('user/withdraw', 'UserController@remove');

// パスワード変更
Route::get('user/pass_edit', 'UserController@pass_edit');
Route::post('user/pass_edit', 'UserController@pass_update');

// パスワード変更
Route::get('profile/edit', 'ProfileController@edit')
    ->middleware('auth');
Route::post('profile/edit', 'ProfileController@update')
    ->middleware('auth');

// 投稿一覧
Route::get('/', 'PostController@index');

// 投稿詳細
Route::get('post/show', 'PostController@show');
Route::post('post/show', 'PostController@reply')
    ->middleware('auth');

// 新規投稿
Route::get('post/create', 'PostController@create')
    ->middleware('auth');
Route::post('post/create', 'PostController@store')
    ->middleware('auth');

// 投稿編集
Route::get('post/edit', 'PostController@edit')
    ->middleware('auth');
Route::post('post/edit', 'PostController@update')
    ->middleware('auth');

// 投稿削除
Route::post('post/destroy', 'PostController@destroy')
    ->middleware('auth');

// いいね
Route::post('ajax/like', 'Ajax\LikeController@ajax');