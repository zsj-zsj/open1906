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

Route::get('/', function () {
    return view('welcome');
});

Route::get('phpinfo', function () {
    phpinfo();
});


Route::get('reg','Index\Login@reg');  //注册
Route::post('doreg','Index\Login@doreg');  //执行注册

Route::get('login','Index\Login@login');  //登录页面
Route::post('dologin','Index\Login@dologin');  //执行登录

Route::get('center','Index\Login@center');   //个人中心

