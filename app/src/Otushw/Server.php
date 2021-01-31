<?php

namespace Otushw;

/**
 * Class Server
 *
 * @package Otushw
 */
class Server extends Base
{

    /**
     * Server constructor.
     */
    public function __construct()
    {
        $this->ipc = new IPC();
        $this->init();
    }

    public function __destruct()
    {
        $this->ipc->disconnect();
    }

    protected function init(): void
    {
        $this->ipc->initReceiver();
    }

    public function execute(): void
    {
        while (true) {
            $raw = $this->ipc->readMessage();
            Message::showMessage('Received: ' . $raw);
            if ($raw === $_ENV['stop_server']) {
                break;
            }

        }
    }
}
