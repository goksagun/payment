<?php

namespace Payment;


use InvalidArgumentException;
use Payment\Contracts\Factory;

class Payment implements Factory
{
    /**
     * The current factory instances.
     *
     * @var \Payment\Contracts\Factory
     */
    protected $factories = [];

    /**
     * Create a new gateway instance.
     *
     * @param array $config
     *
     * @throws InvalidArgumentException
     * @return Factory|Contracts\Gateway
     *
     */
    public function make(array $config)
    {
        if (!isset($config['name'])) {
            throw new InvalidArgumentException('A gateway must be specified.');
        }

        return $this->factory($config);
    }

    /**
     * Get a factory instance by name.
     *
     * @param string $config
     *
     * @return Factory
     */
    public function factory($config)
    {
        if (isset($this->factories['name'])) {
            return $this->factories['name'];
        }

        $name = $config['name'];
        $class = "Payment\\Gateways\\{$name}";

        if (class_exists($class)) {
            return $this->factories['name'] = new $class($config);
        }

        throw new InvalidArgumentException("Unsupported factory [$name].");
    }
}