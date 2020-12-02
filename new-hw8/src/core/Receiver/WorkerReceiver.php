<?php


namespace AYakovlev\core\Receiver;


use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class WorkerReceiver
{
    /**
     * @var Logger
     */
    private Logger $log;

    public function __construct()
    {
        $this->log = new Logger('workerReceive');
        $this->log->pushHandler(new StreamHandler(__DIR__ . '/../../../logs/workerReceive.log', Logger::INFO));
    }

    /**
     * @return WorkerReceiver
     */
    public function generatePdf(): WorkerReceiver
    {
        $this->log->info('Generating PDF...');
        sleep(mt_rand(2, 5));
        $this->log->info('...PDF generated');
        return $this;
    }

    public function sendEmail(): void
    {
        $this->log->info('Sending email...');
        sleep(mt_rand(1,3));
        $this->log->info('Email sent');
    }

    /**
     * @return Logger
     */
    public function getLog(): Logger
    {
        return $this->log;
    }
}