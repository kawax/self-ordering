<?php

use Illuminate\Support\Facades\Route;
use Revolution\Ordering\Http\Controllers\LoginController;
use Revolution\Ordering\Http\Controllers\LogoutController;
use Revolution\Ordering\Http\Middleware\TableMiddleware;

Route::view('login', 'ordering::auth.login')->name('login');
Route::post('login', LoginController::class);
Route::post('logout', LogoutController::class)->name('logout');

Route::view('dashboard', 'ordering::dashboard')
     ->middleware(['auth:ordering'])
     ->name('dashboard');

Route::view('table', 'ordering::table')->name('table');

Route::view('order/{table?}', 'ordering::order.index')
     ->name('order')
     ->middleware(TableMiddleware::class);

Route::view('prepare', 'ordering::prepare.index')
     ->name('prepare');

Route::view('history', 'ordering::history.index')
     ->name('history');

Route::view('payment/paypay/{payment}', 'ordering::payment.paypay')
     ->name('paypay.callback');
