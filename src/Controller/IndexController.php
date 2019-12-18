<?php

declare(strict_types=1);

namespace Controller;

use Service\Exception\EmptyStringException;
use Service\Exception\IncorrectStringException;
use Service\StringChecker;

class IndexController
{
    /**
     * @param StringChecker $stringChecker
     * @param array $request
     * @return string
     * @throws EmptyStringException
     * @throws IncorrectStringException
     */
    public function processRequest(StringChecker $stringChecker, array $request): string
    {
        if (!isset($request['string'])) {
            throw new EmptyStringException('Строка не передана', 400);
        }
        $stringChecker->checkBracketedString($request['string']);

        return 'Строка корректна';
    }
}
