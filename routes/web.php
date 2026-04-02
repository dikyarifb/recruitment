<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
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

Route::get('/', [MainController::class, 'index']);
Route::get('/login', [MainController::class, 'login'])->name('login')->middleware('guest');
Route::post('/login', [MainController::class, 'login_post']);

Route::post('/apply', [MainController::class, 'store']);
Route::post('/test/iq', [MainController::class, 'store_iq']);
Route::post('/test/disc', [MainController::class, 'store_disc']);



Route::get('/employee/test/iq', [MainController::class, 'employee_iq_form'])->middleware('auth');
Route::get('/employee/test/disc', [MainController::class, 'employee_disc_form'])->middleware('auth');