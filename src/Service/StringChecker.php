<?php

declare(strict_types=1);

namespace Service;

use Bracketed\Resolver;
use InvalidArgumentException;
use Service\Exception\EmptyStringException;
use Service\Exception\IncorrectStringException;

class StringChecker
{
    private Resolver $resolver;

    public function __construct(Resolver $resolver)
    {
        $this->resolver = $resolver;
    }

    /**
     * @param string $bracketedString
     * @throws EmptyStringException
     * @throws IncorrectStringException
     */
    public function checkBracketedString(string $bracketedString): void
    {
        if (strlen($bracketedString) === 0) {
            throw new EmptyStringException('Строка пуста', 400);
        }

        try {
            if (!$this->resolver->isCorrect($bracketedString)) {
                throw new IncorrectStringException('Скобки в строке расставлены неправильно', 400);
            }
        } catch (InvalidArgumentException $exception) {
            throw new IncorrectStringException('В строке обнаружены неправильные символы', 400, $exception);
        }

        return;
    }
}
