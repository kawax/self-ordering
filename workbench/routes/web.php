<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Include self-ordering routes - using proper middleware
Route::middleware(['web'])->group(function () {
    Route::view('login', 'ordering::auth.login')->name('login');
    Route::view('table', 'ordering::table')->name('table');
    Route::view('order/{table?}', 'ordering::order.index')->name('order');
    Route::view('prepare', 'ordering::prepare.index')->name('prepare');
    Route::view('history', 'ordering::history.index')->name('history');
});
