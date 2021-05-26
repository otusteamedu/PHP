<?php
declare(strict_types=1);

namespace DesignPatterns\Observers;

use DesignPatterns\Exceptions\BadMealException;

class QualityAssuranceObserver implements Observer
{
    /**
     * @param string $eventName
     *
     * @throws BadMealException
     */
    public function update(string $eventName): void
    {
        /*meal does not meat requirement lets utilize it*/
    //    if (/* condition */) {
            throw new BadMealException();
    //    }
    }
}
