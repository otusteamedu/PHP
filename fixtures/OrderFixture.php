<?php

namespace Fixture;

use App\Entity\OrderEntity;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Persistence\ObjectManager;

class OrderFixture implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $orders = [
            new OrderEntity('1234567890123456', 100.15, false),
            new OrderEntity('123456789012345B', 200.50, true),
        ];

        foreach ($orders as $order) {
            $manager->persist($order);
        }
        $manager->flush();
    }
}
