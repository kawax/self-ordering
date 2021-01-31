<?php

namespace Revolution\Ordering\Http\Livewire\Order;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Livewire\Component;
use Revolution\Ordering\Contracts\Actions\AddCart;
use Revolution\Ordering\Contracts\Actions\ResetCart;
use Revolution\Ordering\Facades\Menu;

class Menus extends Component
{
    /**
     * @var Collection
     */
    public Collection $menus;

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
        return collect(session('cart', []))
            ->map(fn($id) => $this->menus->firstWhere('id', $id));
    }

    /**
     * カートに追加.
     *
     * @param  $id
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
     * 決済機能を含めるなら新しいルートを作ってconfigでリダイレクト先を変更する.
     *
     * @return RedirectResponse
     */
    public function redirectTo()
    {
        return redirect()
            ->route(config('ordering.redirect.from_menus'));
    }

    public function render()
    {
        return view('ordering::livewire.order.menus');
    }
}
