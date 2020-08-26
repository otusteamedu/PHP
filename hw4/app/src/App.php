<?php


namespace App;


use Exception;

class App
{
    const TYPE_SERVER = "server";
    const TYPE_CLIENT = "client";

    private $shortOpts = "t:m:";
    private $longOpts = ["type:", "message:"];
    private $options;
    private $type;
    private $message;

    public function __construct()
    {
        $this->options = getopt($this->shortOpts, $this->longOpts);

        $this->type = $this->options['t'] ?? $this->options['type'];
        $this->message = $this->options['m'] ?? $this->options['message'];

        try{
            $this->validateOptions();
        } catch (Exception $exception) {
            echo $exception->getMessage();
            exit();
        }
    }
    private function validateOptions()
    {
        if (empty($this->type)) {
            throw new Exception(
                'You must specify the type via the t parameter or the type. Valid values are client or server'.PHP_EOL
            );
        }

        if ($this->type !== self::TYPE_SERVER && $this->type !== self::TYPE_CLIENT) {
            throw new Exception('Valid values for client or server type'.PHP_EOL);
        }

        if ($this->type === self::TYPE_CLIENT && empty($this->message)) {
            throw new Exception('You forgot to enter a message to the server'.PHP_EOL);
        }
    }

    public function startSession($iniPath)
    {
        $class = "App\\" . ucfirst($this->type);
        (new $class($iniPath))->start($this->type !== 'client' ?: $this->message);
    }
}