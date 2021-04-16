<?php

namespace App\Validators;


class EmailValidator implements Validator
{

    private $domains = [
        'root' => [
            'allowed' => [],
            'denied'  => []
        ],
        'high' => [
            'allowed' => [],
            'denied'  => []
        ],
    ];

    private $value = null;
    private $isValid = false;
    private $validMX = true;


    public function isValid(): bool
    {
        return $this->isValid;
    }

    public function validate(): EmailValidator
    {
        $regex = '^\w+';
        foreach ($this->domains as $level => $domain) {
            $regex .= $level === 'root' ? '@' : '\.';
            if (empty($domain['allowed'])) {
                $regex .= '\w+';
            }
            foreach ($domain as $type => $list) {
                foreach ($list as $item) {
                    $regex .= $type === 'denied' ? '(?<!' : '(';
                    $regex .= "$item)";
                }
            }
        }
        $regex .= '$';
        $this->isValid = preg_match("/$regex/", $this->value) === 1;
        if ($this->isValid && $this->validMX) {
            $this->isValid = checkdnsrr(preg_replace('/^.*?@/', '', $this->value), 'MX');
        }
        return $this;
    }

    public function setValue($value): EmailValidator
    {
        $this->value = $value;
        return $this;
    }

    public function enableMXRecordValidation()
    {
        $this->validMX = true;
        return $this;
    }

    public function disableMXRecordValidation()
    {
        $this->validMX = false;
        return $this;
    }

    public function setAllowedHighDomains(array $domains)
    {
        $this->domains['high']['allowed'] = $domains;
        return $this;
    }

    public function setDeniedHighDomains(array $domains)
    {
        $this->domains['high']['denied'] = $domains;
        return $this;
    }

    public function setAllowedRootDomains(array $domains)
    {
        $this->domains['root']['allowed'] = $domains;
        return $this;
    }

    public function setDeniedRootDomains(array $domains)
    {
        $this->domains['root']['denied'] = $domains;
        return $this;
    }
}