<?php

namespace Revolution\Ordering\Http\Livewire\Order;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Collection;
use Livewire\Component;
use Revolution\Ordering\Facades\Menu;

class History extends Component
{
    /**
     * @var Collection
     */
    private Collection $menus;

    public function mount()
    {
        $this->menus = Collection::wrap(Menu::get());
    }

    /**
     * @return Collection
     */
    public function getHistoriesProperty(): Collection
    {
        return collect(session('history', []))->map(function ($history) {
            $history['items'] = collect($history['items'])
                ->map(fn ($id) => $this->menus->firstWhere('id', $id))
                ->toArray();

            return $history;
        });
    }

    public function deleteHistory()
    {
        session()->forget('history');
    }

    /**
     * @return RedirectResponse
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
