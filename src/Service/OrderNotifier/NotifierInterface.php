<?php declare(strict_types=1);

namespace Service\OrderNotifier;

use Entity\Shop\Customer;

interface NotifierInterface
{
    public function notify(Customer $customer): void;
}
