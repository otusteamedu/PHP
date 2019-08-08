<?php

declare(strict_types=1);

namespace Otus\hw22\Helper;

class CamelCase
{
    /**
     * @var string
     */
    private $input;

    public function __construct(string $input)
    {
        $this->input = $input;
    }

    public function process(): string
    {
        $input = preg_replace('/[-_\s]+/', ' ', trim(strtolower($this->input)));
        $upperCaseFirst = ucwords($input);
        return lcfirst(str_replace(' ', '', $upperCaseFirst));
    }

    public function __invoke(): string
    {
        return $this->process();
    }
}