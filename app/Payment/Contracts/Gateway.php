<?php

namespace Payment\Contracts;

interface Gateway {

    /**
     * Make transaction..
     *
     * @param array $params
     * @return mixed
     */
    public function pay(array $params = []);
}