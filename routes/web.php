<?php

use Illuminate\Support\Facades\Route;
use Revolution\Ordering\Contracts\Actions\Login;
use Revolution\Ordering\Contracts\Actions\Logout;
use Revolution\Ordering\Http\Middleware\TableMiddleware;

Route::view('login', 'ordering::auth.login')->name('login');
Route::post('login', Login::class);
Route::post('logout', Logout::class)->name('logout');

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
