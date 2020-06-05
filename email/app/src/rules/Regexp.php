<?php


namespace Marchenko\rules;

use Marchenko\Rule;
use Marchenko\RuleContext;

class Regexp extends Rule
{
    const PATTERN = "/^(?:[A-Za-z0-9]+(?:[-_.+]?[A-Za-z0-9-_.+#$%^&*]+)?" .
    "@[A-Za-z0-9]+(?:\.?[A-Za-z0-9-.]+)?\.[A-Za-z]{2,5})$/i";

    public function execute(RuleContext $context)
    {
        foreach ($context->getList() as $email) {
            $result = false;
            if (preg_match(self::PATTERN, $email)) {
                $result = true;
            }
            $context->setResult($email, $result);
        }
    }
}
