<?php


namespace Marchenko;

class Config
{
    protected $file;

    public function __construct(string $path)
    {
        $file = parse_ini_file($path, false, INI_SCANNER_TYPED);
        if (empty($file)) {
            return false;
        }
        $this->file = $file;
    }

    public function get(string $paramName)
    {
        // TODO add processing variable with value NULL
        if (!isset($this->file[$paramName])) {
            return false;
        }

        return $this->file[$paramName];
    }

}
