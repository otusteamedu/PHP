<?php


namespace App\Services\Socket\Entity;


class ResultFromSocket
{
    private $message = null;
    private $from = null;

    /**
     * ResultFromSocket constructor.
     * @param null $message
     * @param null $from
     */
    public function __construct(string $message, string $from)
    {
        $this->message = $message;
        $this->from = $from;
    }

    /**
     * @return string|null
     */
    public function getMessage(): ?string
    {
        return $this->message;
    }

    /**
     * @return string|null
     */
    public function getFrom(): ?string
    {
        return $this->from;
    }



}