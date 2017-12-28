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
Route::get('/help','StaticPagesController@help')->name('help');
Route::get('/about','StaticPagesController@about')->name('abou1t');

//注册
Route::get('/signup','UsersController@create')->name('signup');


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
