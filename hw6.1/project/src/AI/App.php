<?php

namespace AI\backend_php_hw6_1;


use AI\backend_php_hw6_1\Settings\IniFileHandler;
use AI\EmailValidator\EmailValidator;

class App
{
    private EmailValidator $validator;

    public function __construct(string $configFile)
    {
        $iniFile = new IniFileHandler($configFile);
        $rules = $iniFile->getSettings()['rules'] ?? [];
        $this->validator = new EmailValidator($rules);
    }

    public function run(): void
    {
        foreach ($this->getEmails() as $email) {
            $this->out($email, $this->isCorrectEmail($email));
        }
    }

    /**
     * @return array
     */
    private function getEmails(): array
    {
        $filename = $_SERVER['DOCUMENT_ROOT'] . '/../data/emails.txt';
        $data = file($filename);
        $emails = [];

        foreach ($data as $str) {
            $str = trim($str);
            if ($str) {
                $emails[] = $str;
            }
        }

        return $emails;
    }

    /**
     * @param string $email
     *
     * @return bool
     */
    private function isCorrectEmail(string $email): bool
    {
        return $this->validator->check($email);
    }

    private function out(string $email, bool $result): void
    {
        $out = $email . ($result ? ' OK' : ' FAIL') . PHP_EOL;
        $out .= implode(PHP_EOL, $this->validator->getResultInfo()) . PHP_EOL . PHP_EOL;

        if (PHP_SAPI != 'cli') {
            $out = "<pre>$out</pre>";
        }

        echo $out;
    }
}
