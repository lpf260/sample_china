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
Route::get('/','StaticPagesController@home')->name('home');
Route::get('/help','StaticPagesController@help')->name('help')->middleware('age');
Route::get('/about','StaticPagesController@about')->name('about');

//注册
Route::get('/signup','UsersController@create')->name('signup');

//发送确认邮件
Route::get('/signup/confirm/{token}','UsersController@confirmEmail')->name('confirm_email');

//测试
Route::get('/test','TestController@test')->name('test');

//上传
Route::post('/upload','TestController@upload')->name('test.upload');

//测试加密解密
Route::get('/crypt','TestController@crypt')->name('test.crypt');

//Route::get('/login','LoginController@login')->name('login');

//用户路由 resource方法将遵从Restful架构为用户资源生成路由。该方法接收两个参数，第一个参数为资源名称，第二个参数为控制器名称
Route::resource('users','UsersController');
    /**
     *  resource等同于下面
     *  Route::get('/users', 'UsersController@index')->name('users.index');
     *  Route::get('/users/{user}', 'UsersController@show')->name('users.show');
     *  Route::get('/users/create', 'UsersController@create')->name('users.create');
     *  Route::post('/users', 'UsersController@store')->name('users.store');
     *  Route::get('/users/{user}/edit', 'UsersController@edit')->name('users.edit');
     *  Route::patch('/users/{user}', 'UsersController@update')->name('users.update');
     *  Route::delete('/users/{user}', 'UsersController@destroy')->name('users.destroy');
     */

Route::get('login', 'SessionsController@create')->name('login');
Route::post('login','SessionsController@store')->name('login');
Route::delete('logout', 'SessionsController@destroy')->name('logout');

//显示重置密码的邮箱发送页面
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');

//邮箱发送重设链接
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');

//密码更新页面
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');

//执行密码更新操作
Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');