<?php


namespace App\Message;


use App\MessageHandler\BankOperationMessageHandler;
use DateTime;


class BankOperationMessage  implements MessageInterface
{
    private string $email;
    private DateTime $dateStart;
    private DateTime $dateEnd;
    private string $messageHandler;

    /**
     * BankOperationMessage constructor.
     * @param string $email
     * @param DateTime $dateStart
     * @param DateTime $dateEnd
     */
    public function __construct(string $email, DateTime $dateStart, DateTime $dateEnd)
    {
        $this->email = $email;
        $this->dateStart = $dateStart;
        $this->dateEnd = $dateEnd;
        $this->messageHandler = BankOperationMessageHandler::class;
    }

    public function getHandler(): string
    {
        return $this->messageHandler;
    }


    public function __serialize(): array
    {
        return [
            'handler' => $this->getHandler(),
            'email' => $this->email,
            'date_start' => $this->dateStart->format('Y-m-d H:i:s'),
            'date_end' => $this->dateEnd->format('Y-m-d H:i:s')
        ];
    }

    public function __unserialize(array $data): void
    {
        $this->messageHandler = $data['handler'];
        $this->email = $data['email'];
        $this->dateStart = new DateTime($data['date_start']);
        $this->dateEnd = new DateTime($data['date_end']);
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return \DateTime
     */
    public function getDateStart(): DateTime
    {
        return $this->dateStart;
    }

    /**
     * @return \DateTime
     */
    public function getDateEnd(): DateTime
    {
        return $this->dateEnd;
    }


}
