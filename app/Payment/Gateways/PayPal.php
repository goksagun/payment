<?php

namespace Payment\Gateways;

use Payment\Contracts\Gateway;


class PayPal extends AbstractGateway implements Gateway
{
    /**
     * Gateway display name.
     *
     * @var string
     */
    protected $displayName = 'paypal';

    /**
     * Gateway API endpoint.
     *
     * @var string
     */
    protected $endpoint = 'https://api.paypal.com';

    /**
     * Gateway default currency.
     *
     * @var string
     */
    protected $defaultCurrency = 'EUR';

    /**
     * Gateway exchange differences.
     *
     * @var float
     */
    protected $exchangeDifference = 1.08;

    /**
     * Inject the configuration for a Gateway.
     *
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->config  = $config;
    }

    /**
     * @param $currency
     * @param $value
     * @return mixed
     */
    public function checkCurrency($currency, $value)
    {
        return $this->setValue($currency, $value);
    }

    /**
     * @param array $params
     * @return bool
     */
    public function pay(array $params = [])
    {
        if (!$this->checkStatus()) {
            return false;
        }

        $params['value'] = $this->checkCurrency($params['currency'], $params['value']);

        $this->setParams($params);

        // TODO Use PayPal api to payment...
        return true;
    }

    /**
     * @return bool
     */
    public function sendVoucher()
    {
        return $this->sendSuccessMail();
    }
}