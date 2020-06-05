<?php


namespace Marchenko\rules;

use Marchenko\Rule;
use Marchenko\RuleContext;

class Checkmx extends Rule
{
    const NEEDLE = '@';

    public function execute(RuleContext $context)
    {
        foreach ($context->getList() as $email) {
            $result = false;
            $hostname = substr($email, strpos($email, self::NEEDLE) + 1);
            $mxhosts = [];
            $value = getmxrr($hostname, $mxhosts);
            if ($value && !empty($mxhosts)) {
                $result = true;
            }
            $context->setResult($email, $result);
        }
    }
}
