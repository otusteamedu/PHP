<?php
namespace AI\backend_php_hw4\UnixSockets\Settings;

class iniFilesHandler
{
    private $filename;
    private $settings;

    public function __construct($iniFileName)
    {
        $this->filename = __DIR__.'/'.$iniFileName;
        $this->readIniFile();
    }

    public function getSettings()
    {
        return $this->settings;
    }

    private function readIniFile()
    {
        if (file_exists($this->filename)) {
            if (($ini = parse_ini_file($this->filename, false)) !== false) {
                $this->settings = $ini;
            }
            else {
                $err = print_r(error_get_last(), true);
                throw new \Exception("Не удалось распознать конфигурационный файл {$this->filename}:"
                    .PHP_EOL.$err);
            }
        }
        else {
            throw new \Exception("Конфигурационный файл не найден.");
        }
    }
}