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

Route::get('/dashboard/users', 'AdminController@showUsersPage')->name('users');
Route::get('/dashboard/equipment', 'AdminController@showEquipmentPage')->name('equipment');
Route::get('/dashboard/equipment/add', 'AdminController@showAddEquipmentPage');
Route::post('/dashboard/equipment/addequipment', 'AdminController@addEquipment');
Route::post('/dashboard/equipment/print', 'AdminController@printLabel');
Route::post('/dashboard/equipment/printbulk', 'AdminController@printBulkLabel');
Route::post('/dashboard/equipment/delete', 'AdminController@deleteEquipment');
Route::get('/dashboard/users/add', 'AdminController@showAddUserPage');
Route::post('/dashboard/users/adduser', 'AdminController@addUser');

Route::get('/dashboard/statistics', 'AdminController@showStatisticsPage')->name('statistics');


Route::get('/dashboard', 'HomeController@showDashboard')->name('dashboard');
Route::get('/dashboard/equipment/rent','AdminController@showRentEquipmentPage');
Route::get('/dashboard/equipment/return','AdminController@showReturnEquipmentPage');
Route::get('/dashboard/user/report','AdminController@showUserReportPage');

Route::post('/dashboard/equipment/rent/confirm', 'AdminController@rentEquipment');
Route::post('/dashboard/equipment/return/confirm', 'AdminController@returnEquipment');