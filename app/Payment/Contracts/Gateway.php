<?php

namespace Payment\Contracts;

interface Gateway {

    /**
     * @param $currency
     * @param $value
     * @return mixed
     */
    public function checkCurrency($currency, $value);

    /**
     * @param array $params
     * @return mixed
     */
    public function pay(array $params = []);

    /**
     * @return mixed
     */
    public function sendVoucher();
}