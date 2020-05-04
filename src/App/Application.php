<?php
namespace App;

use Socket\UnixSocket;
use Exception;
use Symfony\Component\Yaml\Yaml;

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

    /** @var Output */
    protected $output;

    /**
     * Application constructor.
     * @throws Exception
     */
    public function __construct()
    {
        $config = Yaml::parseFile('config/config.yml');;

        $this->socket = new UnixSocket($config['main_socket_file']);
        $this->recipient = $config['recipient_socket_file'];
        $this->exitCommand = $config['exit_command'];
        $this->output = new Output();
    }

    public function run()
    {
        while (!$this->isNeedExit()) {
            /** @todo Что-то попахивает говнокодом, но ничего лучше не придумал(( */
            if (file_exists($this->recipient)) {
                $this->output->writeLn("waiting message...");
                $this->response = $this->socket->read();
                $this->output->writeLn( 'Received message: ' . $this->response);
            } else {
                $this->output->writeLn("Attention! Another application probably not running.");
            }

            $this->message = readline("Please, enter the message. $this->exitCommand for exit: ");
            if ($this->message !== '') {
                try {
                    $this->socket->sendTo($this->message, $this->recipient);
                } catch (Exception $e) {
                    $this->output->writeLn($e->getMessage());
                    $this->output->writeLn('Good bye!');
                }
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