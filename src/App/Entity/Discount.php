<?php

namespace App\Entity;

use App\EntityFilter\DiscountFilter;
use App\EntityFilter\IEntityFilter;
use App\EntityInterface\IDiscount;
use App\EntityInterface\IEntity;
use App\EntityInterface\IFetchAssoc;
use App\EntityRepository\DiscountRepository;
use PDO;

class Discount extends CommonEntity implements IDiscount, IFetchAssoc
{
    private string $label = '';
    private float $value = 0.0;
    private int $percents = 0;

    /**
     * Discount constructor.
     * @param PDO $pdo
     */
    public function __construct(PDO $pdo)
    {
        $this->repository = new DiscountRepository($pdo);
    }

    /**
     * @return array
     */
    public function fetchToAssoc(): array
    {
        return [
            'label'    => $this->label,
            'value'    => $this->value,
            'percents' => $this->percents,
        ];
    }

    /**
     * @inheritDoc
     */
    public function getValue(?float $value = null): float
    {
        if ($value && $this->percents) {
            return $value * $this->percents * 0.01;
        } else {
            return $this->value;
        }
    }

    /**
     * @inheritDoc
     */
    public static function getEntitiesByFilter(
        PDO $pdo,
        IEntityFilter $filter
    ): array {
        return DiscountRepository::getEntitiesByFilter($pdo, $filter);
    }

    /**
     * @param PDO $pdo
     * @param int $id
     * @return Discount
     */
    public static function getById(PDO $pdo, int $id): IEntity
    {
        return self::getEntitiesByFilter($pdo, new DiscountFilter($id))[0] ??
               new Discount($pdo);
    }

    /**
     * @return string
     */
    public function getLabel(): string
    {
        return $this->label;
    }

    /**
     * @param string $label
     * @return Discount
     */
    public function setLabel(string $label): Discount
    {
        $this->label = $label;
        return $this;
    }

    /**
     * @param float $value
     * @return Discount
     */
    public function setValue(float $value): Discount
    {
        $this->value = $value;
        return $this;
    }

    /**
     * @param int $percents
     * @return Discount
     */
    public function setPercents(int $percents): Discount
    {
        $this->percents = $percents;
        return $this;
    }

    /**
     * @return int
     */
    public function getPercents(): int
    {
        return $this->percents;
    }
}