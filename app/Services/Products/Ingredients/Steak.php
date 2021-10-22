<?php

namespace App\Services\Products\Ingredients;


use App\Exceptions\ErrorCodes;
use App\Exceptions\Orders\InvalidSteakStrategyException;
use App\Services\Factories\ProductFactory\IIngredient;
use App\Services\Strategy\CookingTechnology\ISteakStrategy;
use App\Services\Strategy\CookingTechnology\SteakHard;
use App\Services\Strategy\CookingTechnology\SteakMiddle;
use App\Services\Strategy\CookingTechnology\SteakSoft;


class Steak extends Ingredient implements IIngredient
{

    const INGREDIENT_NAME = 'Стейк';
    const STRONG_ROASTING = 'Сильная прожарка';
    const MIDDLE_ROASTING = 'Средняя прожарка';
    const SOFT_ROASTING   = 'Слабая прожарка';

    private ?ISteakStrategy $strategy;

    /**
     * @param IIngredient $ingredient
     */
    public function __construct(IIngredient $ingredient)
    {
        parent::__construct();
        $this->ingredient = $ingredient;
    }

    /**
     * @return $this
     * @throws InvalidSteakStrategyException
     */
    public function prepare(): Steak
    {
        parent::prepare();
        if (!$this->strategy) {
            throw new InvalidSteakStrategyException("Не выбрана степень прожарки", ErrorCodes::getCode(InvalidSteakStrategyException::class));
        }
        echo $this->strategy->prepare();
        return $this;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @return Steak
     */
    public function setType(string $type): Steak
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return $this
     */
    public function setStrategy(): Steak
    {
        $this->strategy = match ($this->type) {
            self::MIDDLE_ROASTING => new SteakMiddle(),
            self::SOFT_ROASTING   => new SteakSoft(),
            self::STRONG_ROASTING => new SteakHard(),
            default => null,
        };
        return $this;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $this->ingredientsList = $this->ingredient->toArray();
        $this->ingredientsList['Steak'] = parent::ingredientToArray();
        return $this->ingredientsList;
    }
}