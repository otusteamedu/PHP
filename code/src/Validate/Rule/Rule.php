<?php

namespace Validate\Rule;

abstract class Rule {

    abstract function check(string $string);

}