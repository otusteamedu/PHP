<?php


namespace Src\Services;


use Src\AbstractFactory\AbstractFood;
use Src\AbstractFactory\BaseMeal;
use Src\Decorator\IngredientDecorator;

class KitchenService implements \SplObserver
{
    private array $extraIngredients = ['cheese', 'onion', 'pickles'];

    public function askForExtra(AbstractFood $meal): void
    {
        foreach ($this->extraIngredients as $ingredient) {
            $this->askForExtraIngredient($meal, $ingredient);
        }
    }

    public function update(\SplSubject $subject)
    {
        $this->getMealDescription($subject);
    }

    private function getMealDescription(BaseMeal $meal): void
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

    private function askForExtraIngredient(AbstractFood $meal, string $ingredient)
    {
        $answer = readline("Add some extra $ingredient ? yes/no ");
        if ($answer === 'yes') {
            $meal = new IngredientDecorator($meal);
            $meal->addIngredient($ingredient);
        }
    }
}