<?php

namespace AI\backend_php_hw6_1;


use AI\backend_php_hw6_1\Exceptions\FileException;
use AI\backend_php_hw6_1\Settings\IniFileHandler;
use AI\EmailValidator\EmailValidator;

class App
{
    private EmailValidator $validator;
    private string $viewsDir;

    public function __construct(string $configFile)
    {
        $iniFile = new IniFileHandler($configFile);

        $rules = $iniFile->getSettings()['rules'] ?? [];
        $this->validator = new EmailValidator($rules);

        $this->viewsDir = $iniFile->getSettings()['views_dir'] ?? '';
    }

    public function run(): void
    {
        foreach ($this->getEmails() as $email) {
            $this->showResult($email, $this->isCorrectEmail($email));
        }

        $this->showForm();
    }

    /**
     * @return array
     *
     * @throws FileException
     */
    private function getEmails(): array
    {
        $emails = [];

        if (isset($_POST['emails'])) {
            $data = explode("\n", $_POST['emails']);
        }
        elseif (isset($_SERVER['argv']) && $_SERVER['argc'] > 1) {
            $data = $this->getInputFromFile($_SERVER['argv'][1]);
        }

        if (isset($data)) {
            $emails = $this->clearInput($data);
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

    /**
     * @param string $email
     * @param bool $result
     */
    private function showResult(string $email, bool $result): void
    {
        $out = $email . ($result ? ' OK' : ' FAIL') . PHP_EOL;
        $out .= implode(PHP_EOL, $this->validator->getResultInfo()) . PHP_EOL . PHP_EOL;

        if (PHP_SAPI != 'cli') {
            $out = "<pre>$out</pre>";
        }

        echo $out;
    }

    /**
     * @param string $filename
     * @return array
     * @throws FileException
     */
    private function getInputFromFile(string $filename): array
    {
        if (!file_exists($filename)) {
            throw new FileException("Файл '$filename' не найден.");
        }

        $data = file($filename);
        if ($data === false) {
            throw new FileException("Ошибка чтения файла '$filename': " .
                error_get_last()['message']);
        }

        return $data;
    }

    /**
     * @param array $data
     * @return array
     */
    private function clearInput(array $data): array
    {
        $result = [];

        foreach ($data as $str) {
            $str = trim($str);
            if ($str) {
                $result[] = $str;
            }
        }

        return $result;
    }

    private function showForm()
    {
        if (PHP_SAPI != 'cli') {
            include $this->viewsDir . '/form.php';
        }
    }
}
