<?php

namespace Fixture;

use App\Entity\Order;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Persistence\ObjectManager;

class OrderFixture implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $orders = [
            new Order('1234567890123456', 100.15, false),
            new Order('123456789012345B', 200.50, true),
        ];

        foreach ($orders as $order) {
            $manager->persist($order);
        }
        $manager->flush();
    }
}
