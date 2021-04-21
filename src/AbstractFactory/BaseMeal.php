<?php


namespace Src\AbstractFactory;


class BaseMeal implements AbstractFood, \SplSubject
{
    public string $mealName;

    public bool $extraCheese;

    public bool $extraOnion;

    public bool $extraPickles;

    public array $ingredients = [];

    private \SplObjectStorage $observers;

    public function __construct()
    {
        $this->extraCheese = false;
        $this->extraOnion = false;
        $this->extraPickles = false;
        $this->observers = new \SplObjectStorage();
    }

    public function getFoodName(): string
    {
        // TODO: Implement getFoodName() method.
    }

    public function addIngredient()
    {
        $this->notify();
        // TODO: Implement addIngredient() method.
    }

    public function attach(\SplObserver $observer)
    {
        echo "Kitchen got the order.\n";

        $this->observers->attach($observer);
    }

    public function detach(\SplObserver $observer): void
    {
        $this->observers->detach($observer);
        echo "Subject: Detached an observer.\n";
    }

    public function notify()
    {
        echo "Kitchen notifying the client \n";
        foreach ($this->observers as $observer) {
            $observer->update($this);
        }
    }
}