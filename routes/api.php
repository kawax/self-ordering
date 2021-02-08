<?php

use Illuminate\Support\Facades\Route;
use Revolution\Ordering\Http\Controllers\Api\MenusController;

Route::get('menus', MenusController::class)
     ->name('api.menus.index');
