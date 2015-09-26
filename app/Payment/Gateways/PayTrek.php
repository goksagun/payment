<?php

namespace Payment\Gateways;

use Payment\Contracts\Gateway;


class PayTrek extends AbstractGateway implements Gateway
{
    /**
     * Gateway display name.
     *
     * @var string
     */
    protected $displayName = 'paytrek';

    /**
     * Gateway API endpoint.
     *
     * @var string
     */
    protected $endpoint = 'https://api.paytrek.com';

    /**
     * Gateway default currency.
     *
     * @var string
     */
    protected $defaultCurrency = 'USD';

    /**
     * Gateway exchange differences.
     *
     * @var float
     */
    protected $exchangeDifference = 1.10;

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

        // TODO Use PayTrek api to payment...
        return true;
    }
}