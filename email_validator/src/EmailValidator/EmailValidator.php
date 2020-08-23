<?php

namespace Penguin\EmailValidator;

class EmailValidator
{
    protected array $rules;
    protected array $validateErrors;
    protected string $defaultRule = '#^([A-zА-яёЁ0-9_-]+\.)*[A-zА-яёЁ0-9_-]+' . '@' .
        '[a-zа-яё0-9_-]+(\.[a-zа-яё0-9_-]+)*\.[a-zа-я]{2,6}$#';

    public function __construct(array $rules = [])
    {
        if ($rules) {
            $this->addRules($rules);
        } else {
            $this->rules[] = $this->defaultRule;
        }
    }

    public function addRules(array $rules): void
    {
        $this->rules = array_merge($this->rules, $rules);
    }

    public function setRules(array $rules): void
    {
        $this->rules = $rules;
    }

    public function validate(array $emails)
    {
        $bad = [];
        $good = [];

        foreach ($emails as $email) {
            if (!$this->verifyByRules($email)) {
                $bad[] = $email;
                $this->addValidateError($email, 'rules error');
                continue;
            }

            $host = explode('@', $email)[1];
            if (!$this->verifyMX($host)) {
                $bad[] = $email;
                $this->addValidateError($email, 'mx error');
                continue;
            }

            $good[] = $email;
        }

        return [
            'bad' => $bad,
            'good' => $good
        ];
    }

    public function getValidateErrors(string $email = '')
    {
        if (array_key_exists($email, $this->validateErrors)) {
            return $this->validateErrors[$email];
        }

        return $this->validateErrors;
    }

    protected function verifyByRules(string $email): bool
    {
        foreach ($this->rules as $rule) {
            if (!preg_match($rule, $email)) {
                return false;
            }
        }

        return true;
    }

    protected function verifyMX(string $host): bool
    {
        if (getmxrr($host, $out)) {
            return true;
        }

        return false;
    }

    private function addValidateError(string $email, string $error) : void
    {
        $this->validateErrors[$email] = $error;
    }
}