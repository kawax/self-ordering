<?php

use Illuminate\Support\Facades\Route;
use Revolution\Ordering\Http\Controllers\Api\MenusIndexController;

Route::get('menus', MenusIndexController::class)
     ->name('api.menus.index');
