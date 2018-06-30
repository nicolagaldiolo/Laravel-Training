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
  return view('admin.index');
});

Route::get('/dashboard', function () {
  return view('admin_dashboard');
});

Route::resource('users', 'Admin\AdminUserController');
Route::patch('users/{id}/restore', 'Admin\AdminUserController@restore')->name('users.restore');