<?php
namespace hw6;

use ReflectionClass;

class VerifyEmail
{
    private $rules = [];

    public function __construct()
    {
        foreach (glob(__DIR__ . '/Rule/*.php') as $rule) {
            $this->rules[] = 'hw6\\Rule\\' . substr(basename($rule), 0, -4);
        }
    }

    public function check(string $email)
    {
        $output = [];

        foreach ($this->rules as $rule) {
            $rc = new ReflectionClass($rule);
            $rm = $rc->getMethod('check');
            $result = $rm->invoke(null, $email);

            $output[] = $rule . ': ' . var_export($result, true);
        }

        return $output;
    }
}