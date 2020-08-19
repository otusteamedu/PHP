<?php


namespace Email;


class EmailList extends EmailCorrect
{
    private array $emailArray;
    private string $filename = __DIR__ . "/email.list";

    public function __construct()
    {
        parent::__construct($this->email);
        $this->emailArray = file($this->filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        if ($this->emailArray === false) {
            throw new \Exception("Не могу прочитать файл - " . $this->filename);
        }
    }

    public function validateListEmail(): void
    {
        $newValidateFile = '';

        foreach ($this->emailArray as $lines) {
            $email = new EmailCorrect($lines);
            if ($email->validateEmail()) {
                $newValidateLines = $lines . " - email корректен.\n" ;
            } else {
                $newValidateLines = $lines . " - ВНИМАНИЕ! email не корректен.\n";
            }
            $newValidateFile = $newValidateFile . $newValidateLines;
        }

        if (file_put_contents($this->filename . "Valid", $newValidateFile) === false) {
            throw new \Exception("Не могу записать файл - " . $this->filename);
        }
    }
}
