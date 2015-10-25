<?php

namespace Payment\Gateways;

use Carbon\Carbon;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Mail;


abstract class AbstractGateway
{
    /**
     * Gateway display name.
     *
     * @var string
     */
    protected $displayName;

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
     * Gateway default currency.
     *
     * @var string
     */
    protected $defaultCurrency;

    /**
     * Gateway exchange differences.
     *
     * @var float
     */
    protected $exchangeDifference;

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
    public function checkStatus()
    {
        if (!$this->config['active']) {
            return false;
        }
        return true;
    }

    /**
     * Set gateway status active or inactive.
     *
     * @param int|bool $active
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
        return $this->displayName;
    }

    /**
     * Get gateway default currency.
     *
     * @return string
     */
    public function getDefaultCurrency()
    {
        return $this->defaultCurrency;
    }

    /**
     * Set gateway exchange difference.
     *
     * @param int|float $exchangeDifference
     */
    public function setExchangeDifference($exchangeDifference)
    {
        $this->exchangeDifference = $exchangeDifference;
    }

    /**
     * Set gateway params.
     *
     * @param array $params
     */
    protected function setParams($params)
    {
        $this->params = $params;
    }

    /**
     * Get gateway params.
     *
     * @return array
     */
    protected function getParams()
    {
        return $this->params;
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
    public function sendVoucher($to, $from)
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
        $data['date'] = Carbon::now()->format('Y-m-d H:i:s');

        Mail::send('emails.success', $data, function (Message $m) use ($userData) {
            $m->from($userData['from'], 'Multi Gateway Payment');
            $m->to($userData['to'])->subject('Payment Successful');
        });
        return true;
    }

    /**
     * Check currency and if exchange difference is different default calculate new value.
     *
     * @param $currency
     * @param $value
     * @return mixed
     */
    public function checkCurrency($currency, $value)
    {
        return $this->setValue($currency, $value);
    }
}