<?php

namespace App\Http\Controllers;

use Payment\Payment;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class PaymentController extends Controller
{
    /**
     * Display payment form.
     *
     * @return Response
     */
    public function getPayment()
    {
        $gateways = $this->gatewayList();

        return view('pay', compact('gateways'));
    }

    /**
     * Make payment.
     *
     * @param Request $request
     * @return array
     */
    public function postPayment(Request $request)
    {
        $this->validateData($request);

        $gateway = $request->input('gateway');

        $config = config("payment.gateways.{$gateway}");

        // Create a new PaymentFactory
        $payment = new Payment();

        // Get a specific gateway
        $transaction = $payment->make($config);

        // Change PayPal gateway exchange difference
        if ($gateway == 'paypal') {
            $transaction->setExchangeDifference(1.111);
        }

        // Set PayU gateway inactive
        // if ($gateway == 'payu') {
        //     $transaction->setStatus(0);
        // }

        $params = $request->except('_token');

        if ($transaction->pay($params)) {
            // Send success email
            // $transaction->sendVoucher('accounting@testtest.com', 'noreplay@testtest.com');

            return redirect()->back()->withAlerts(['success' => "Payment successful."]);
        };

        return redirect()->back()->withAlerts(['danger' => "Payment failed."]);
    }

    /**
     * Validate request data.
     *
     * @param Request $request
     */
    protected function validateData(Request $request)
    {
        $rules = [
            'name' => 'required',
            'gateway' => 'required',
            'value' => 'required',
            'currency' => 'required',
        ];

        $this->validate($request, $rules);
    }

    /**
     * Get gateway list and remove inactive.
     *
     * @return mixed
     */
    protected function gatewayList()
    {
        $gateways = config('payment.gateways');

        foreach ($gateways as $key => $gateway) {
            if ($gateway['active'] == 0) {
                unset($gateways[$key]);
            }
        }
        return $gateways;
    }
}
