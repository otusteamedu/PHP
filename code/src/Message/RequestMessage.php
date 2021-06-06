<?php


namespace App\Message;


use App\MessageHandler\RequestMessageHandler;

class RequestMessage implements MessageInterface
{
    private int $requestNumber;
    private string $messageHandler;

    /**
     * RequestMessage constructor.
     * @param int $requestNumber
     */
    public function __construct(int $requestNumber)
    {
        $this->requestNumber = $requestNumber;
        $this->messageHandler = RequestMessageHandler::class;
    }

    public function getRequestNumber(): int
    {
        return $this->requestNumber;
    }


    public function getHandler(): string
    {
        return $this->messageHandler;
    }

    public function __serialize(): array
    {
        return [
            'handler' => $this->getHandler(),
            'request_number' => $this->getRequestNumber(),
        ];
    }

    public function __unserialize(array $data): void
    {
        $this->messageHandler = $data['handler'];
        $this->requestNumber = $data['request_number'];
    }
}
