<?php

declare(strict_types=1);

namespace App\Order;

class CompanyOrder extends AbstractOrder implements OrderInterface
{
    public const TYPE = 'b2b';

    protected $company;

    public function __construct(array $data)
    {
        parent::__construct($data);
    }

    public function getCompany()
    {
        return $this->company;
    }

    public function setCompany($company)
    {
        $this->company = $company;
    }
}