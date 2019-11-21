<?php

namespace Utils;

use Core\AppConfig;

class ValidatorRules
{
    public $bracketsOpen = "";
    public $bracketsClose = "";
    public $nonEmpty = 1;

    /**
     * ValidatorRules constructor.
     * @param array $textRules
     */
    public function __construct(array $textRules)
    {
        $this->bracketsOpen = $textRules["bracketsOpen"];
        $this->bracketsClose = $textRules["bracketsClose"];
        $this->nonEmpty = $textRules["nonEmpty"];
    }
}