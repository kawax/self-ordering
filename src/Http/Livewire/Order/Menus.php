<?php

declare(strict_types=1);

namespace Revolution\Ordering\Http\Livewire\Order;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Livewire\Component;
use Livewire\Redirector;
use Revolution\Ordering\Contracts\Actions\AddCart;
use Revolution\Ordering\Contracts\Actions\ResetCart;
use Revolution\Ordering\Facades\Cart;
use Revolution\Ordering\Facades\Menu;

class Menus extends Component
{
    /**
     * @var Collection
     */
    public Collection $menus;

    /**
     * @param  Request  $request
     */
    public function mount(Request $request)
    {
        $this->menus = Collection::wrap(Menu::get());

        session(['table' => $request->table]);
    }

    /**
     * @return Collection
     */
    public function getItemsProperty(): Collection
    {
        return Cart::items(Cart::all(), $this->menus);
    }

    /**
     * カートに追加.
     *
     * @param  string|int  $id
     */
    public function addCart($id)
    {
        app(AddCart::class)->add($id);
    }

    /**
     * カートをリセット.
     */
    public function resetCart()
    {
        app(ResetCart::class)->reset();
    }

    /**
     * 次のページに移動.
     *
     * @return RedirectResponse|Redirector
     */
    public function redirectTo()
    {
        return redirect()->route(config('ordering.redirect.from_menus'));
    }

    public function render()
    {
        return view()->first([
            'ordering-theme::livewire.order.menus',
            'ordering::livewire.order.menus',
        ]);
    }
}
