<?php


namespace Otushw;


/**
 * Class Base
 *
 * @package Otushw
 */
abstract class Base
{
    /**
     * @var IPC
     */
    protected IPC $ipc;

    /**
     * @return string
     */
    public function userInput(): string
    {
        return trim(fgets(STDIN));
    }

    abstract public function execute(): void;

    abstract protected function init(): void;
}
