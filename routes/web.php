<?php

use Illuminate\Support\Facades\Route;

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



Auth::routes(['register'=>false]);

Route::get('/', 'PagesController@showIndexPage')->name('index');
Route::get('/login', 'PagesController@showLogin')->name('login');

Route::get('/dashboard/users', 'AdminController@showUsersPage');
Route::get('/dashboard/equipment', 'AdminController@showEquipmentPage');
Route::get('/dashboard/users/add', 'AdminController@showAddUserPage');
Route::POST('/dashboard/users/adduser', 'AdminController@addUser');


Route::get('/dashboard', 'HomeController@showDashboard')->name('dashboard');
Route::get('/dashboard/equipment/rent','HomeController@showRentEquipmentPage');