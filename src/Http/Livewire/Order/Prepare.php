<?php

namespace Revolution\Ordering\Http\Livewire\Order;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Livewire\Component;
use Revolution\Ordering\Contracts\Actions\Order;
use Revolution\Ordering\Facades\Menu;

class Prepare extends Component
{
    /**
     * @var Collection
     */
    public Collection $menus;

    /**
     * @var string
     */
    public string $memo = '';

    public function mount()
    {
        $this->menus = Collection::wrap(Menu::get());
    }

    /**
     * @return Collection
     */
    public function getItemsProperty(): Collection
    {
        return collect(session('cart', []))
            ->map(fn ($id) => $this->menus->firstWhere('id', $id));
    }

    /**
     * カートから削除.
     *
     * @param  int  $index
     */
    public function deleteCart(int $index)
    {
        $items = Arr::except(session('cart', []), [$index]);

        session(['cart' => $items]);
    }

    /**
     * @return RedirectResponse
     */
    public function back()
    {
        return redirect()->route('order', ['table' => session('table')]);
    }

    /**
     * @param $memo
     */
    public function updatedMemo($memo)
    {
        session(['memo' => $memo]);
    }

    /**
     * @return RedirectResponse
     */
    public function sendOrder()
    {
        app(Order::class)->order();

        return redirect()
            ->route(config('ordering.redirect.from_prepare'));
    }

    public function render()
    {
        return view('ordering::livewire.order.prepare');
    }
}
