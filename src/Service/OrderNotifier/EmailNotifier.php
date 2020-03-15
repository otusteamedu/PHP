<?php declare(strict_types=1);

namespace Service\OrderNotifier;

use Entity\Shop\Customer;

class EmailNotifier implements NotifierInterface
{
    public function notify(Customer $customer): void
    {
        //send email
    }
}
