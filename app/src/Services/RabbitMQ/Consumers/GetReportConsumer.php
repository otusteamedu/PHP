<?php


namespace App\Services\RabbitMQ\Consumers;

use App\Repositories\Film\FilmRepository;
use App\Services\Mail\Mail;
use App\Services\RabbitMQ\Queues\Queue;
use App\Services\ServiceContainer\AppServiceContainer;
use JsonException;
use PhpAmqpLib\Message\AMQPMessage;
use PHPMailer\PHPMailer\Exception;

class GetReportConsumer extends BaseConsumer
{
    protected string $name = 'get_report';

    private FilmRepository $filmRepository;

    public function __construct(Queue $queue)
    {
        $this->filmRepository = AppServiceContainer::getInstance()->resolve(FilmRepository::class);

        parent::__construct($queue);
    }

    /**
     * @throws Exception|JsonException
     */
    public function handle(AMQPMessage $message): void
    {
        $body = json_decode($message->getBody(), true, 512, JSON_THROW_ON_ERROR);
        $films = $this->filmRepository->getAll();

        $report = '';
        foreach ($films as $film){
            $report .= 'Name: ' . $film->getName() . ', duration: ' . $film->getDuration() . PHP_EOL;
        }

        $mail = new Mail();
        $mail->setFrom(env('MAIL_FROM_ADDRESS'));
        $mail->addAddress($body['email']);
        $mail->setSubject('Films Report');
        $mail->setBody($report);
        $mail->send();

        parent::handle($message);
    }
}