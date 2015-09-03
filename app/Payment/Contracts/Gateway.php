<?php

namespace Payment\Contracts;

interface Gateway {

    /**
     * Check currency and set value..
     *
     * @param $currency
     * @param $value
     * @return mixed
     */
    public function checkCurrency($currency, $value);

    /**
     * Make transaction..
     *
     * @param array $params
     * @return mixed
     */
    public function pay(array $params = []);

    /**
     * Send email..
     *
     * @param $to
     * @param $from
     * @return mixed
     */
    public function sendVoucher($to, $from);
}