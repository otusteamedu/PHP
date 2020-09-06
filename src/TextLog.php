<?php


namespace App;


class TextLog extends AbstractLog
{

    private $log;
    private $who;

    public function __construct($logFileName, $who)
    {
        $this->log = fopen($logFileName, 'a');
        $this->who = $who;
    }

    public function INFO($msg)
    {
        $this->writeLog('INFO: ', $msg);
    }

    public function WARNING($msg)
    {
        echo 'WARNING: ' . $msg . PHP_EOL;
        $this->writeLog('WARNING: ', $msg);
    }

    public function ERROR($msg)
    {
        echo 'ERROR: ' . $msg . PHP_EOL;
        $this->writeLog('ERROR: ', $msg);
    }

    private function writeLog($type, $msg)
    {
        $msgLog = date('D, d-M-Y H:i:s') . ' ' . $this->who . ': => ' . $type . $msg . PHP_EOL;
        fwrite($this->log, $msgLog);
    }

    public function closeLog()
    {
        fclose($this->log);
    }
}