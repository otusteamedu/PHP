<?php

declare(strict_types=1);

namespace App\Service;

use App\Exceptions\TicketBookingServiceException;
use App\Queue\QueueClientInterface;
use App\Validators\TicketBookingValidator;
use PhpAmqpLib\Message\AMQPMessage;

class TicketBookingService
{
    const QUEUE_NAME = 'queue.ticket.booking';
    const EXCHANGE_NAME = 'ticket';
    const ROUTING_KEY = 'ticket.booking';

    const CONTENT_TYPE = 'application/json';

    /**
     * @var QueueClientInterface
     */
    private $queueClient;

    /**
     * @var TicketBookingValidator
     */
    private $validator;

    /**
     * TicketBookingService constructor.
     * @param QueueClientInterface $queueClient
     */
    public function __construct(QueueClientInterface $queueClient)
    {
        $this->queueClient = $queueClient;

        $this->setQueueClientParams();

        $this->validator = new TicketBookingValidator();
    }

    public function setQueueClientParams()
    {
        $this->queueClient->exchangeDeclare(self::EXCHANGE_NAME);
        $this->queueClient->queueDeclare(self::QUEUE_NAME);
        $this->queueClient->queueBind(self::QUEUE_NAME, self::EXCHANGE_NAME, self::ROUTING_KEY);
        $this->queueClient->channelConfirmSelect();

        $this->queueClient->setAckHandler(
            function (AMQPMessage $message) {
                return true;
            }
        );

        $this->queueClient->setNAckHandler(
            function (AMQPMessage $message) {
                throw new TicketBookingServiceException('Во время отправки заказа возникла ошибка');
            }
        );
    }

    /**
     * @return mixed
     * @throws TicketBookingServiceException
     * @var TicketBookingValidator
     */
    public function sendTicketsForBooking($bookingData)
    {
        $this->validator->validate($bookingData);

        $messageParams = $this->getMessageParams();

        if (!$messageParams['message_id']) {
            throw new TicketBookingServiceException('Идентификатор сообщения не получен');
        }

        $this->queueClient->publish(
            $this->prepareMessageToPublish($bookingData),
            self::EXCHANGE_NAME,
            self::ROUTING_KEY,
            true,
            $messageParams
        );

        $this->queueClient->waitForPendingReturns();

        return $messageParams['message_id'];
    }

    public function getMessageParams()
    {
        return [
            'delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT,
            'content_type' => self::CONTENT_TYPE,
            'message_id' => uniqid('', true),
        ];
    }

    public function prepareMessageToPublish($bookingData): string
    {
        return json_encode($bookingData);
    }
}
