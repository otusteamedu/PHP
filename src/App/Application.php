<?php
namespace App;

use Socket\UnixSocket;
use Exception;

class Application
{
    /** @var UnixSocket */
    protected $socket;

    /** @var string */
    protected $recipient;

    /** @var string */
    protected $exitCommand;

    /** @var string  */
    protected $message = '';

    /** @var string  */
    protected $response = '';

    /**
     * Application constructor.
     * @param string $filePath
     * @param string $recipient
     * @param string $exitCommand
     * @throws Exception
     */
    public function __construct(string $filePath, string $recipient, string $exitCommand)
    {
        $this->socket = new UnixSocket($filePath);
        $this->recipient = $recipient;
        $this->exitCommand = $exitCommand;
    }

    public function run()
    {
        while (!$this->isNeedExit()) {
            /** @todo Что-то попахивает говнокодом, но ничего лучше не придумал(( */
            if (file_exists($this->recipient)) {
                echo "waiting message... \n";
                $this->response = $this->socket->read();
                echo 'Received message: ' . $this->response . "\n";
            } else {
                echo "Attention! Another application probably not running. \n";
            }

            if ($this->isNeedExit()) {
                echo 'Good bye!';
                break;
            }

            $this->message = readline("Please, enter the message. $this->exitCommand for exit: ");
            if ($this->message !== '') {
                $this->socket->sendTo($this->message, $this->recipient);
            }

        }

        $this->socket->close();
    }

    protected function isNeedExit()
    {
        if ($this->message !== $this->exitCommand && $this->response !== $this->exitCommand) {
            return false;
        }
        return true;
    }

}