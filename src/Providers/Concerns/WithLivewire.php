<?php

declare(strict_types=1);

namespace Revolution\Ordering\Providers\Concerns;

use Livewire\Livewire;
use Revolution\Ordering\Http\Livewire\Dashboard\QrCodeGenerator;
use Revolution\Ordering\Http\Livewire\Order\History;
use Revolution\Ordering\Http\Livewire\Order\Menus;
use Revolution\Ordering\Http\Livewire\Order\PayPayCallback;
use Revolution\Ordering\Http\Livewire\Order\Prepare;

trait WithLivewire
{
    protected function registerLivewire(): void
    {
        if (! class_exists(Livewire::class)) {
            return; // @codeCoverageIgnore
        }

        Livewire::component('ordering.menus', Menus::class);
        Livewire::component('ordering.prepare', Prepare::class);
        Livewire::component('ordering.history', History::class);
        Livewire::component('ordering.paypay', PayPayCallback::class);
        Livewire::component('ordering.qr-code-generator', QrCodeGenerator::class);
    }
}
