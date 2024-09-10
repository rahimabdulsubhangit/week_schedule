<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ExcelController;
use App\Http\Controllers\WeeklyHoursController;

Route::get('/read-excel', [ExcelController::class, 'readExcel']);
Route::post('/write-excel', [ExcelController::class, 'writeExcel']);
Route::get('/schedule', [WeeklyHoursController::class, 'index'])->name('weekly-hours.index');
Route::get('/weekly-hours/show', [WeeklyHoursController::class, 'show'])->name('weekly-hours.show');
Route::post('/weekly-hours/update', [WeeklyHoursController::class, 'update'])->name('weekly-hours.update');
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
    return view('home');

});


Route::post('create','App\Http\Controllers\weekController@create');
Route::get('team', 'App\Http\Controllers\weekController@team');
Route::get('emp', 'App\Http\Controllers\weekController@emp');
//Route::get('schedule', 'App\Http\Controllers\weekController@schedule');
Route::post('create_team','App\Http\Controllers\weekController@create_team');
Route::post('create_emp','App\Http\Controllers\weekController@create_emp');

