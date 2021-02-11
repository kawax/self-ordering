<?php

namespace Revolution\Ordering\Http\Livewire\Order;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Collection;
use Livewire\Component;
use Livewire\Redirector;
use Revolution\Ordering\Facades\Cart;
use Revolution\Ordering\Facades\Menu;

class History extends Component
{
    /**
     * @var Collection
     */
    protected Collection $menus;

    public function mount()
    {
        $this->menus = Collection::wrap(Menu::get());
    }

    /**
     * @return Collection
     */
    public function getHistoriesProperty(): Collection
    {
        return collect(session('history', []))->map([$this, 'replaceHistoryItems']);
    }

    /**
     * @param  array  $history
     *
     * @return array
     */
    public function replaceHistoryItems(array $history): array
    {
        $history['items'] = Cart::items($history['items'], $this->menus)->toArray();

        return $history;
    }

    /**
     * @return void
     */
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
        return view('ordering::livewire.order.history');
    }
}
