<?php

namespace Utils;

use Core\AppConfig;

class ValidatorRules
{
    public $bracketsOpen = "";
    public $bracketsClose = "";
    public $nonEmptyStr = false;
    public $emailPattern = false;
    public $emailMxCheck = false;

    /**
     * ValidatorRules constructor.
     * @param array $rules
     */
    public function __construct(array $rules)
    {
        $this->bracketsOpen = $rules["bracketsOpen"];
        $this->bracketsClose = $rules["bracketsClose"];
        $this->nonEmptyStr = boolval($rules["nonEmpty"]);
        $this->emailPattern = $rules["emailPattern"];
        $this->emailMxCheck = boolval($rules["emailMxCheck"]);
    }
}