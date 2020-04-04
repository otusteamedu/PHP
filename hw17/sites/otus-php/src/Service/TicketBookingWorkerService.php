<?php

declare(strict_types=1);

namespace App\Service;

use App\Exceptions\KernelException;
use App\Kernel\Application;
use App\Queue\QueueClientInterface;
use App\Repository\TicketRepository;
use PhpAmqpLib\Message\AMQPMessage;

class TicketBookingWorkerService
{
    /**
     * @var QueueClientInterface
     */
    private $queueClient;

    /**
     * @var TicketRepository
     */
    private $ticketRepository;

    /**
     * @param TicketRepository $ticketRepository
     * @throws KernelException
     */
    public function __construct(TicketRepository $ticketRepository)
    {
        $this->queueClient = Application::getInstance('queueClient');
        $this->ticketRepository = $ticketRepository;

        $this->setQueueClientParams();
    }

    public function setQueueClientParams()
    {
        $this->queueClient->exchangeDeclare(TicketBookingService::EXCHANGE_NAME);
        $this->queueClient->queueDeclare(TicketBookingService::QUEUE_NAME);
        $this->queueClient->queueBind(TicketBookingService::QUEUE_NAME, TicketBookingService::EXCHANGE_NAME, TicketBookingService::ROUTING_KEY);

        $this->queueClient->setConsumeHandler(function (AMQPMessage $message) {
            try {
                /**
                 * @var AMQPMessage $message
                 */
                echo ' Получено сообщение ', $message->body, "\n";

                $bookingData = json_decode($message->body, true);
                $this->bookTickets($bookingData, $message->get('message_id'));
                $this->queueClient->ackMessage($message);
            } catch (\Throwable $exception) {
                $this->queueClient->nackMessage($message);
            }
        });
    }

    /**
     * @param $bookingData
     * @param $messageId
     */
    public function bookTickets($bookingData, $messageId): void
    {
        $result = $this->ticketRepository->insertTickets($bookingData);

        $bookingResult = [
            'client_id' => $bookingData['client_id'],
            'message_id' => $messageId,
            'queue_name' => TicketBookingService::QUEUE_NAME,
            'success' => $result ? 'true' : 'false'
        ];

        $this->ticketRepository->insertResult($bookingResult);
    }

    /**
     * @throws \Exception
     */
    public function run()
    {
        echo "\n Воркер ждет сообщений, для прекращения работы нажмите CTRL+C\n";

        $this->queueClient->consume(TicketBookingService::QUEUE_NAME);

        while ($this->queueClient->isChannelConsuming()) {
            $this->queueClient->channelWaits();
        }

        $this->queueClient->close();
    }
}
