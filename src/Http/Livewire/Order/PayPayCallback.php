<?php

namespace Revolution\Ordering\Http\Livewire\Order;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\Redirector;
use Revolution\Ordering\Contracts\Actions\Order;
use Revolution\Ordering\Payment\PayPay\PayPay;

class PayPayCallback extends Component
{
    /**
     * @var string
     */
    public string $payment;

    /**
     * @var string
     */
    public string $status;

    /**
     * @param  Request  $request
     */
    public function mount(Request $request)
    {
        $this->payment = $request->payment ?? '';
    }

    /**
     * @return RedirectResponse|Redirector|void
     */
    public function check()
    {
        $response = app(PayPay::class)->getPaymentDetails($this->payment);

        $this->status = Arr::get($response, 'data.status', '');

        // PayPayではgetPaymentDetailsのステータスがCOMPLETEDを確認して注文送信。
        if (! Str::of($this->status)->exactly(PayPay::COMPLETED)) {
            return;
        }

        $options = [
            'payment'     => 'paypay',
            'paypay_data' => $response,
        ];

        app(Order::class)->order($options);

        return redirect()->route(config('ordering.redirect.from_payment'));
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
        return view('ordering::livewire.order.paypay');
    }
}
