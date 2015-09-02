<?php

namespace Payment\Contracts;


interface Factory
{
    /**
     * Create a new gateway instance..
     *
     * @param array $config
     * @return \Payment\Contracts\Gateway
     * @internal param \string[] $driver
     *
     */
    public function make(array $config);
}