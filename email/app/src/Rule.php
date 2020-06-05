<?php

namespace Marchenko;

abstract class Rule
{
    abstract public function execute(RuleContext $context);
}