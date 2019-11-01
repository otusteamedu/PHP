<?php
namespace AI\backend_php_hw4\UnixSockets\Settings;

class Settings
{
    private $params;

    public function __construct($settingsFilename)
    {
        $ini = new iniFilesHandler($settingsFilename);
        $this->params = $ini->getSettings();
    }


    public function getParam($param)
    {
        if (isset($this->params[$param])) {
            return $this->params[$param];
        }
        else {
            throw new \Exception("Несуществующий параметр: $param");
        }
    }
}
