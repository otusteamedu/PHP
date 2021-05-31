<?php

namespace App\Console;

class Parser
{
    private string $command = '';
    private array $arguments = [];

    private const PREFIX = __NAMESPACE__ . '\\Commands\\';
    private const SUFFIX = 'Command';

    public function __construct()
    {
        $this->parse();
    }

    private function parse()
    {
        if (is_array($GLOBALS['argv'])) {
            $this->command = (string)$GLOBALS['argv'][1];
            $this->arguments = array_slice($GLOBALS['argv'], 2);
        }
    }

    /**
     * @return mixed
     */
    public function getArguments()
    {
        return $this->arguments;
    }

    /**
     * @return mixed
     */
    public function getCommand()
    {
        return $this->command;
    }

    public function getCommandClassName(): string
    {
        return self::PREFIX . ucfirst($this->getCommand()) . self::SUFFIX;
    }
}