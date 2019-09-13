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

//authentication routes
Route::get('auth/login', 'Auth\LoginController@showloginForm')->name('login');
Route::post('auth/login','Auth\LoginController@login');
Route::get('auth/logout', 'Auth\LoginController@logout')->name('logout');

//registration routes
Route::get('auth/register', 'Auth\RegisterController@showRegistrationForm');
Route::post('auth/register','Auth\RegisterController@Register');

//password reset routes
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');

//comments routes
Route::post('comments/{post_id}', 'CommentsController@store')->name('comments.store');
Route::get('comments/{comment}/edit', 'CommentsController@edit')->name('comments.edit');
Route::put('comments/{comment}', 'CommentsController@update')->name('comments.update');
Route::delete('comments/{comment}', 'CommentsController@destroy')->name('comments.destroy');

//pages routes
Route::resource('tags', 'TagController', ['except' => ['create']]);
Route::resource('categories', 'CategoryController', ['except' => ['create']]);
Route::get('blog/{slug}', ['as' => 'blog.single', 'uses' => 'BlogController@getSingle'])->where('slug', '[\w\d\-\_]+');
Route::get('blog', ['uses' => 'BlogController@getIndex', 'as' => 'blog.index']);
Route::get('contact', 'PagesController@getContact');
Route::post('contact', 'PagesController@postContact');
Route::get('about', 'PagesController@getAbout');
Route::get('/', 'PagesController@getIndex');
Route::resource('posts', 'PostController');
