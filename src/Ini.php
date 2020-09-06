<?php


namespace App;


class Ini
{
    /**
     * @var array|false
     */
    private $ini;
    private $iniFile;

    public function __construct($iniFile)
    {
        $this->iniFile = $iniFile;
        if (file_exists($this->iniFile))
            $this->ini = parse_ini_file($this->iniFile, false);
    }

    public function getParam($param)
    {
        return $this->ini[$param];
    }

    public function setParam($param, $value)
    {
        $this->ini[$param] = $value;

        $fd = fopen($this->iniFile, 'w+');
        foreach ($this->ini as $key => $value) {
            fwrite($fd,$key . '=' . $value . PHP_EOL);
        }

        fclose($fd);
    }

}