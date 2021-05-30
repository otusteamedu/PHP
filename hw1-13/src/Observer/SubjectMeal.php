<?php
namespace Src\Observer;

use SplObserver;
use Src\AbstractFactory\AbstractFoodInterface;

abstract class SubjectMeal implements \SplSubject, AbstractFoodInterface
{

    public bool $cheese;

    public bool $sausages;

    public bool $tomatoes;

    public array $ingredients = [];

    private \SplObjectStorage $observers;

    public function __construct(){
        $this->cheese = false;
        $this->sausages = false;
        $this->tomatoes = false;
        $this->observers = new \SplObjectStorage();
    }

    public function attach(SplObserver $observer)
    {
        echo "Subject: Attached an observer.\n";
        $this->observers->attach($observer);
    }

    public function detach(SplObserver $observer)
    {
        $this->observers->detach($observer);
        echo "Subject: Detached an observer.\n";
    }

    public function notify()
    {
        echo "Subject: Notifying observers...\n";
        foreach ($this->observers as $observer) {
            /**@var Observer $observer**/
            $observer->update($this);
        }
    }

    public function getFoodName(): string
    {
        // TODO: Implement getFoodName() method.
    }

    public function addIngredient(string $ingredient)
    {
        $this->notify();
    }
}