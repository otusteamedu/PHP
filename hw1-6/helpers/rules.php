<?php

use App\Exceptions\NoValidatingRulesForThisRoute;

/**
 * This helper function returns validation request rules defined in config/rules.php
 *
 * @param string $route
 *
 * @return mixed
 *
 * @throws NoValidatingRulesForThisRoute
 */
function rules(string $route)
{
    $rules = require_once './config/rules.php';

    if (isset($rules[$route])) {
        return $rules[$route];
    }

    throw new NoValidatingRulesForThisRoute();
}
