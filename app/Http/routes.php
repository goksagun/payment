<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

/**
 * Used for view payment form get request and form data post request.
 */
Route::get('/', 'PaymentController@getPayment');
Route::post('/pay', 'PaymentController@postPayment');

/**
 * Used for only debug and testing.
 */
Route::get('/debug', function () {
    $config = config('payment.gateways');

    $paypal = new \Payment\Gateways\PayPal($config['paypal']);
    $payu = new \Payment\Gateways\PayU($config['payu']);
    $paytrek = new \Payment\Gateways\PayTrek($config['paytrek']);

    $paytrek->setExchangeDifference(1.30);

    $params = [
        'name' => 'Burak Bolat',
        'gateway' => 'paypal',
        'value' => 100,
        'currency' => 'TRY',
    ];

    var_dump($payu->pay($params));

//    var_dump($payu->sendVoucher('accounting@testtest.com', 'noreplay@testtest.com'));

    var_dump($paypal);
    var_dump($payu);
    var_dump($paytrek);

    var_dump('paypal: '.$paypal->checkCurrency('TRY', 100));
    var_dump('payu: '.$payu->checkCurrency('TRY', 100));
    var_dump('paytrek: '.$paytrek->checkCurrency('TRY', 100));
});
