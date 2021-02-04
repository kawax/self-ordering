<?php

namespace Revolution\Ordering\Http\Livewire\Order;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Livewire\Component;
use PayPay\OpenPaymentAPI\Controller\ClientControllerException;
use Revolution\Ordering\Contracts\Actions\Order;
use Revolution\Ordering\Payment\PayPay;

class PayPayCallback extends Component
{
    /**
     * @var string
     */
    public string $payment = '';

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
     * @return RedirectResponse|void
     * @throws ClientControllerException
     */
    public function check()
    {
        $response = rescue(fn () => app(PayPay::class)->getPaymentDetails($this->payment));

        $status = Arr::get($response, 'status');

        // PayPayではgetPaymentDetailsのステータスがCOMPLETEDを確認して注文送信。
        if (Str::of($status)->exactly(PayPay::COMPLETED)) {
            $options = [
                'payment'     => 'paypay',
                'paypay_data' => $response,
            ];

            app(Order::class)->order($options);

            return redirect()->route(config('ordering.redirect.from_payment'));
        }

        $this->status = $status;
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
        return view('ordering::livewire.order.paypay');
    }
}
