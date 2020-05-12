<?php

namespace Classes\Predicates;

class PredicateServiceImpl implements PredicateService
{
    public function getPredicatesCollection(): array
    {
        $collection = [];
        foreach (Predicates::PREDICATES as $class) {
            $collection[] = new $class;
        }

        return $collection;
    }
}
