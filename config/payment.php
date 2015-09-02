<?php

return [

    'gateways' => [
        'paypal' => [
            'name' => 'PayPal',
            'value' => 'paypal',
            'merchant' => 'paypal_merchant',
            'secret' => 'paypal_secret',
            'active' => 0
        ],
        'payu' => [
            'name' => 'PayU',
            'value' => 'payu',
            'merchant' => 'payu_merchant',
            'secret' => 'payu_secret',
            'active' => 1
        ],
        'paytrek' => [
            'name' => 'PayTrek',
            'value' => 'paytrek',
            'merchant' => 'paytrek_merchant',
            'secret' => 'pytrek_secret',
            'active' => 1
        ],
    ]

];
