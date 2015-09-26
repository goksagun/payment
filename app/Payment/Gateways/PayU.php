<?php

namespace Payment\Gateways;

use Payment\Contracts\Gateway;


class PayU extends AbstractGateway implements Gateway
{
    /**
     * Gateway display name.
     *
     * @var string
     */
    protected $displayName = 'payu';

    /**
     * Gateway API endpoint.
     *
     * @var string
     */
    protected $endpoint = 'https://api.payu.com';

    /**
     * Gateway default currency.
     *
     * @var string
     */
    protected $defaultCurrency = 'TRY';

    /**
     * Gateway exchange differences.
     *
     * @var float
     */
    protected $exchangeDifference = 1.12;

    /**
     * Inject the configuration for a Gateway.
     *
     * @param $config
     */
    public function __construct(array $config)
    {
        $this->config  = $config;
    }

    /**
     * Make transaction.
     *
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

        // TODO Use PayU api to payment...
        return true;
    }
}