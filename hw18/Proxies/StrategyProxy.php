<?php
declare(strict_types=1);

namespace DesignPatterns\Proxies;

use Traversable;
use JetBrains\PhpStorm\Pure;
use DesignPatterns\Observers\Subject;
use DesignPatterns\Observers\Observer;
use DesignPatterns\Meals\MealInterface;
use DesignPatterns\Strategies\StrategyInterface;

class StrategyProxy implements StrategyInterface, Subject
{
    private const EVENT_NAME = 'cooking:finish';

    /**
     * @var StrategyInterface
     */
    private StrategyInterface $realStrategy;

    /**
     * @var Traversable
     */
    private Traversable $storage;

    /**
     * StrategyProxy constructor.
     *
     * @param StrategyInterface $realMeal
     * @param Traversable $storage
     */
    #[Pure]
    public function __construct(StrategyInterface $realMeal, Traversable $storage)
    {
        $this->realStrategy = $realMeal;
        $this->storage = $storage;
    }

    /**
     * @return MealInterface
     */
    public function prepareOrder(): MealInterface
    {
        $this->realStrategy->prepareOrder();
        $this->notify(self::EVENT_NAME);
    }

    /**
     * @param Observer $observer
     * @param string $event
     *
     * @return void
     */
    public function attach(Observer $observer, string $event = self::EVENT_NAME): void
    {
        $this->storage->attach($observer, $event);
    }

    /**
     * @param Observer $observer
     *
     * @return void
     */
    public function detach(Observer $observer): void
    {
        $this->storage->detach($observer);
    }

    /**
     * @param string $event
     *
     * @return void
     */
    public function notify(string $event): void
    {
        foreach ($this->storage as $item) {
            $observer = $this->storage->current();
            $observerEventName = $this->storage->getInfo();

            if ($observerEventName === $event) {
                $observer->update($event);
            }
        }
    }
}