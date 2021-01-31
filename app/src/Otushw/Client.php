<?php

namespace Otushw;

/**
 * Class Client
 *
 * @package Otushw
 */
class Client extends Base
{

    /**
     * Client constructor.
     */
    public function __construct()
    {
        $this->ipc = new IPC();
        $this->init();
    }

    protected function init(): void
    {
        $this->ipc->initTransmitter();
    }

    public function execute(): void
    {
        Message::showMessage('Enter Message:');
        $msg = $this->userInput();
        $this->ipc->sendMessage($msg);
    }
}
