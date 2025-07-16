<?php

declare(strict_types=1);

namespace Revolution\Ordering\Http\Livewire\Order;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Collection;
use Livewire\Component;
use Livewire\Redirector;
use Revolution\Ordering\Contracts\Payment\PaymentMethodFactory;
use Revolution\Ordering\Facades\Cart;
use Revolution\Ordering\Facades\Payment;

class Prepare extends Component
{
    public string $memo = '';

    public Collection $payments;

    public string $payment_method = 'cash';

    public function mount()
    {
        $this->payments = app(PaymentMethodFactory::class)->methods();
    }

    public function getItemsProperty(): Collection
    {
        return Cart::items();
    }

    /**
     * カートから削除.
     */
    public function deleteCart(int $index)
    {
        Cart::delete($index);
    }

    /**
     * @return RedirectResponse|Redirector
     */
    public function back()
    {
        return redirect()->route('order', ['table' => session('table')]);
    }

    public function updatedMemo(string $memo)
    {
        session(['memo' => $memo]);
    }

    /**
     * @return RedirectResponse|Redirector
     */
    public function redirectTo()
    {
        return Payment::driver($this->payment_method)->redirect();
    }

    public function render()
    {
        return view()->first([
            'ordering-theme::livewire.order.prepare',
            'ordering::livewire.order.prepare',
        ]);
    }
}
