<?php

declare(strict_types=1);

namespace Revolution\Ordering\Http\Livewire\Order;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Collection;
use Livewire\Component;
use Livewire\Redirector;
use Revolution\Ordering\Facades\Cart;
use Revolution\Ordering\Facades\Menu;

class History extends Component
{
    protected Collection $menus;

    public function boot()
    {
        $this->menus = Collection::wrap(Menu::get());
    }

    public function getHistoriesProperty(): Collection
    {
        return collect(session('history', []))->map([$this, 'replaceHistoryItems']);
    }

    public function replaceHistoryItems(array $history): array
    {
        $history['items'] = Cart::items($history['items'], $this->menus)->toArray();

        return $history;
    }

    public function deleteHistory(): void
    {
        session()->forget('history');
    }

    /**
     * @return RedirectResponse|Redirector
     */
    public function back()
    {
        return redirect()->route('order', ['table' => session('table')]);
    }

    public function render()
    {
        return view()->first([
            'ordering-theme::livewire.order.history',
            'ordering::livewire.order.history',
        ]);
    }
}
