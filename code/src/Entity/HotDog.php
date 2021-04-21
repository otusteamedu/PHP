<?php


namespace App\Entity;


class HotDog extends AbstractProduct
{
    const TYPE = 'Хот дог';
    const DEFAULT_INGREDIENTS = [
        'сосиска баварская' => false,
        'лук фри' => false,
        'салат "Коул слоу"' => false,
    ];
    const BASE = 'булочка бриош для хот-дога';
    const AVAILABLE_INGREDIENTS = [
        'сосиска куриная', 'сосиска вегетарианская',
        'сыр', 'лук красный', 'майонез', 'горчица',
    ];

    public function __construct()
    {
        $this->type = self::TYPE;
    }

    public function getDefaultOptions(): array
    {
        return self::DEFAULT_INGREDIENTS;
    }
}
