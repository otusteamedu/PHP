<?php


namespace Src\Services;


use Src\AbstractFactory\AbstractFood;
use Src\AbstractFactory\BaseMeal;
use Src\Decorator\CheeseDecorator;
use Src\Decorator\OnionDecorator;
use Src\Decorator\PicklesDecorator;

class KitchenService implements \SplObserver
{
    public function askForExtra(AbstractFood $meal): void
    {
        $this->askForExtraCheese($meal);
        $this->askForExtraOnion($meal);
        $this->askForExtraPickles($meal);
    }

    public function update(\SplSubject $subject)
    {
        $this->getMealDescription($subject);
    }

    private function getMealDescription(BaseMeal $meal) : void
    {
        $mealName = $meal->getFoodName();
        $mealIngredients = $meal->ingredients;
        if (!empty($mealIngredients)) {
            $mealIngredientsCount = count($mealIngredients);
            $mealName .= ' with extra ';
            foreach ($meal->ingredients as $key => $extraIngredient) {
                $mealName .= $extraIngredient;
                if ($mealIngredientsCount > 1 && $key + 1 != $mealIngredientsCount) {
                    $mealName .= ', ';
                }
            }
        }
        echo $mealName . ' is ready!' . PHP_EOL;
    }

    private function askForExtraCheese(AbstractFood $meal)
    {
        $addCheese = readline('Add some extra cheese? yes/no ');
        if ($addCheese === 'yes') {
            $meal = new CheeseDecorator($meal);
            $meal->addIngredient();
        }
    }

    private function askForExtraOnion(AbstractFood $meal)
    {
        $addOnion = readline('Add some extra onion? yes/no ');
        if ($addOnion === 'yes') {
            $meal = new OnionDecorator($meal);
            $meal->addIngredient();
        }
    }

    private function askForExtraPickles(AbstractFood $meal)
    {
        $addPickles = readline('Add some extra pickles? yes/no ');
        if ($addPickles === 'yes') {
            $meal = new PicklesDecorator($meal);
            $meal->addIngredient();
        }
    }
}