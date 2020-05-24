<?php

namespace App\Repository;

use App\Entity\OrderEntity;
use Doctrine\ORM\EntityManagerInterface;

class OrderRepository
{
    /** @var \Doctrine\ORM\EntityManagerInterface */
    private $em;

    /**
     * @param \Doctrine\ORM\EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @param string $orderNumber
     * @param float $sum
     * @return bool
     */
    public function setOrderIsPaid(string $orderNumber, float $sum): bool
    {
        $order = $this->findByOrderNumber($orderNumber);
        if ($order->getSum() !== $sum) {
            throw new \DomainException("Order #{$orderNumber} - sum is not match.");
        }

        if ($order->getIsPaid() === true) {
            throw new \DomainException("Order #{$orderNumber} been paid.");
        }

        $order->setIsPaid(true);

        $this->em->persist($order);
        $this->em->flush();

        return true;
    }

    /**
     * @param string $orderNumber
     * @return \App\Entity\OrderEntity
     */
    public function findByOrderNumber(string $orderNumber): OrderEntity
    {
        $repository = $this->em->getRepository(OrderEntity::class);
        /** @var \App\Entity\OrderEntity $order */
        if (($order = $repository->findOneBy(['number' => $orderNumber])) !== null) {
            return $order;
        }

        throw new \DomainException("Order #{$orderNumber} not found.");
    }
}
