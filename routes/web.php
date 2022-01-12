<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HostController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\GraphDeviceController;
use App\Http\Controllers\GraphSessionController;
use App\Http\Controllers\Auth\RegisterController;
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
// Route::get('/', function () {
//     return view('home');
// })->name('home');

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

Route::get('/host', [HostController::class, 'index'])->name('host');
Route::post('/upload', [HostController::class, 'upload'])->name('upload');
Route::get('/show', [HostController::class, 'show'])->name('show');
Route::get('/detail/{host}', [HostController::class, 'detail'])->name('detail');

Route::get('/graph0', [GraphDeviceController::class, 'index'])->name('graph0');
Route::get('/graph0/{id}', [GraphDeviceController::class, 'scope']);
Route::post('/graph0/search', [GraphDeviceController::class, 'search'])->name('search');
Route::post('/detail', [GraphDeviceController::class, 'detail_to_show'])->name('detail0');
Route::get('/graph1', [GraphSessionController::class, 'index'])->name('graph1');
Route::get('/graph1/{id}', [GraphSessionController::class, 'scope']);

Route::post('/logout', [LogoutController::class, 'store'])->name('logout');

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'store']);

Route::get('/register', [RegisterController::class, 'index'])->name('register');
Route::post('/register', [RegisterController::class, 'store']);
