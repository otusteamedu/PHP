<?php
namespace Src\Observer;

use Src\Decorator\IngredientDecorator;
use Src\Decorator\Recipe;

class Observer implements \SplObserver
{
    private array $extraIngredients = ['cheese', 'sausages', 'tomatoes'];

    public function askForExtra(Recipe $meal): void
    {
        foreach ($this->extraIngredients as $ingredient) {
            $this->askToAddIngredient($meal, $ingredient);
        }
    }

    public function update(\SplSubject $subject)
    {
        $this->getDishDescription($subject);
    }

    private function getDishDescription(SubjectMeal $meal): void
    {
        $dish = $meal->getFoodName();
        $dishIngredients = $meal->ingredients;
        if (!empty($dishIngredients)) {
            $mealIngredientsCount = count($dishIngredients);
            $dish .= ' with extra ';
            foreach ($meal->ingredients as $key => $extraIngredient) {
                $dish .= $extraIngredient;
                if ($mealIngredientsCount > 1 && $key + 1 != $mealIngredientsCount) {
                    $dish .= ', ';
                }
            }
        }
        echo $dish . ' is ready!' . PHP_EOL;
    }

    private function askToAddIngredient(Recipe $meal, string $ingredient)
    {
        $answer = readline("Add some extra $ingredient ? yes/no ");
        if ($answer === 'yes') {
            $meal = new IngredientDecorator($meal);
            $meal->addIngredient($ingredient);
        }
    }
}