<?php

namespace Revolution\Ordering\Http\Livewire\Order;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Livewire\Component;
use Revolution\Ordering\Facades\Menu;
use Revolution\Ordering\Facades\Payment;
use Revolution\Ordering\Payment\PaymentMethod;

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

    /**
     * @var Collection
     */
    public Collection $payments;

    /**
     * @var string
     */
    public string $payment_method = 'cash';

    public function mount()
    {
        $this->menus = Collection::wrap(Menu::get());

        $this->payments = app(PaymentMethod::class)->get();
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
    public function redirectTo()
    {
        return Payment::driver($this->payment_method)->redirect();
    }

    public function render()
    {
        return view('ordering::livewire.order.prepare');
    }
}
