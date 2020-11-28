<?php

namespace Otushw\Rules;

use Otushw\ListEmails;

abstract class Rule
{
    abstract public function execute(ListEmails $listEmails);
}