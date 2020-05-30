<?php

namespace UxSockets\Ini;

use Exception;

class Ini
{
    private string $inifile;
    private array $settings;

    public function __construct(string $iniFileName)
    {
        $this->inifile = __DIR__ . '/' . $iniFileName;
        try {
            $this->readIniFile();
        } catch (Exception $e) {
            echo "Exception: {$e->getMessage()}" . PHP_EOL;
        }
    }

    public function getSettings(): array
    {
        return $this->settings;
    }

    private function readIniFile(): void
    {
        if (file_exists($this->inifile)) {
            if (($ini = parse_ini_file($this->inifile, false)) !== false) {
                $this->settings = $ini;
            } else {
                $err = print_r(error_get_last(), true);
                throw new Exception("Couldn't recognize config file {$this->inifile}:" . PHP_EOL . $err);
            }
        } else {
            throw new Exception("Config file not found.");
        }
    }
}