<?php declare(strict_types=1);

namespace Service\OrderNotifier;

use Entity\Shop\Customer;

class SmsNotifier implements NotifierInterface
{
    public function notify(Customer $customer): void
    {
        //send SMS
    }
}
