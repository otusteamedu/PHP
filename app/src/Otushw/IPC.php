<?php


namespace Otushw;


/**
 * Class IPC
 *
 * @package Otushw
 */
class IPC
{

    /**
     * @var CommunicationInterface
     */
    private CommunicationInterface $communication;

    /**
     * IPC constructor.
     */
    public function __construct()
    {
        $this->communication = $this->getCommunication();
    }

    /**
     * @return CommunicationInterface
     */
    public function getCommunication(): CommunicationInterface
    {
        switch ($_ENV['method']) {
            case 'socket':
                return new Socket();
        }
    }

    /**
     * @return string
     */
    public function readMessage(): string
    {
        return $this->communication->recieve();
    }

    /**
     * @param string $msg
     */
    public function sendMessage(string $msg): void
    {
        $this->communication->send($msg);
    }

    public function initReceiver(): void
    {
        $this->communication->prepareConnection();
    }

    public function initTransmitter(): void
    {
        $this->communication->connectToReadyConnection();
    }

    public function disconnect(): void
    {
        $this->communication->disconnectConnection();
    }

}