<?php

namespace Revolution\Ordering\Providers\Concerns;

use Livewire\Livewire;
use Revolution\Ordering\Http\Livewire\Order\History;
use Revolution\Ordering\Http\Livewire\Order\Menus;
use Revolution\Ordering\Http\Livewire\Order\PayPayCallback;
use Revolution\Ordering\Http\Livewire\Order\Prepare;

trait WithLivewire
{
    protected function registerLivewire()
    {
        if (! class_exists(Livewire::class)) {
            return; // @codeCoverageIgnore
        }

        if (! empty($_ENV['LIVEWIRE_MANIFEST_PATH'])) {
            config(['livewire.manifest_path' => $_ENV['LIVEWIRE_MANIFEST_PATH']]); // @codeCoverageIgnore
        }

        Livewire::component('ordering.menus', Menus::class);
        Livewire::component('ordering.prepare', Prepare::class);
        Livewire::component('ordering.history', History::class);
        Livewire::component('ordering.paypay', PayPayCallback::class);
    }
}
