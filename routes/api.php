<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Revolution\Ordering\Contracts\Actions\Api\MenusIndex;

Route::get('menus', MenusIndex::class)
     ->name('api.menus.index');
