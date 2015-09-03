<?php
/**
 * Created by PhpStorm.
 * User: burak
 * Date: 02.09.2015
 * Time: 12:53
 */

namespace Payment\Gateways;

use Carbon\Carbon;
use Mail;


abstract class AbstractGateway
{
    /**
     * Configuration options.
     *
     * @var array
     */
    protected $config;

    /**
     * Gateway params to request.
     *
     * @var array
     */
    protected $params = [];

    /**
     * Inject the configuration for a Gateway.
     *
     * @param array $config
     */
    abstract public function __construct(array $config);


    /**
     * Check gateway status.
     *
     * @throws \Exception
     * @return bool
     */
    protected function checkStatus()
    {
        if (!$this->config['active']) {
//            throw new \Exception("Selected gateway not active!");
            return false;
        }
        return true;
    }

    /**
     * Set gateway status active or inactive.
     *
     * @param int|boll $active
     */
    public function setStatus($active)
    {
        $this->config['active'] = $active;
    }

    /**
     * Get gateway display name.
     *
     * @return string
     */
    public function getDisplayName()
    {
        return property_exists($this, 'displayName') ? $this->displayName : '';
    }

    /**
     * Get gateway default currency.
     *
     * @return string
     */
    protected function getDefaultCurrency()
    {
        return property_exists($this, 'defaultCurrency') ? $this->defaultCurrency : '';
    }

    /**
     * Set gateway exchange difference.
     *
     * @param int|float $exchangeDifference
     */
    public function setExchangeDifference($exchangeDifference)
    {
        property_exists($this, 'exchangeDifference') ? $this->exchangeDifference = $exchangeDifference : '';
    }

    /**
     * Set gateway params.
     *
     * @param array $params
     */
    protected function setParams($params)
    {
        property_exists($this, 'params') ? $this->params = $params : '';
    }

    /**
     * Get gateway params.
     *
     * @return array
     */
    protected function getParams()
    {
        return property_exists($this, 'params') ? $this->params : [];
    }

    /**
     * Set value and calculate exchange difference if default exchange is different.
     *
     * @param $currency
     * @param $value
     * @return mixed
     */
    protected function setValue($currency, $value)
    {
        if ($this->defaultCurrency !== $currency) {
            return floatval($value * $this->exchangeDifference);
        } else {
            return floatval($value);
        }
    }

    /**
     * Send success payment mail.
     *
     * @param $to
     * @param $from
     * @return bool
     */
    protected function sendSuccessMail($to, $from)
    {
        $userData = [
            'to' => $to,
            'from' => $from,
        ];

        $data = [];

        $params = $this->getParams();

        $data['subject'] = "Payment Successful";
        $data['name'] = $params['name'];
        $data['value'] = $params['value'];
        $data['currency'] = $params['currency'];
        $data['date'] = Carbon::now()->format('Y-m-d H:i.s');

        Mail::send('emails.success', $data, function ($m) use ($userData) {
            $m->from($userData['from'], 'Multi Gateway Payment');
            $m->to($userData['to'])->subject('Payment Successful');
        });
        return true;
    }
}