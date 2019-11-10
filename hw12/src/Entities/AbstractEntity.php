<?php

declare(strict_types=1);

namespace RowDataGateway\Entities;

use RowDataGateway\Gateways\AbstractGateway;

abstract class AbstractEntity
{
    /** @var AbstractGateway */
    protected $gateway;

    /**
     * @param AbstractGateway $gateway
     * @param array $attrs
     */
    public function __construct(AbstractGateway $gateway, array $attrs = [])
    {
        $this->gateway = $gateway;

        if (! empty($attrs)) {
            $this->initAttributes($attrs);
        }
    }

    /**
     * @param array $attrs
     */
    protected function initAttributes(array $attrs): void
    {
        foreach ($attrs as $key => $value) {
            if ($key !== 'gateway') {
                $this->{$key} = $value;
            }
        }
    }
}
