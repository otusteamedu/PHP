<?php


namespace App\Observer;

use App\Service\Mailer\EmailSenderInterface;
use App\Service\Mailer\EmailService;
use App\Service\Product\Order\ProductOrder;
use Psr\Container\ContainerInterface;

class OrderObserver implements OrderObserverInterface
{
    private EmailSenderInterface $mailer;

    /**
     * OrderObserver constructor.
     */
    public function __construct(ContainerInterface $container)
    {
        $this->mailer = $container->get(EmailService::class);
    }


    public function update(ProductOrder $order): void
    {
        $this->mailer->sendEmail(
            $order->getCustomerEmail(),
            $this->getSubject($order),
            $order->getState()
        );
    }

    private function getSubject(ProductOrder $order): string
    {
        return 'Ваш заказ ' . $order->getNumber();
    }
}
