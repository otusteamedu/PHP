<?php

namespace App;

use App\Contracts\Input;
use App\Contracts\Output;
use App\Contracts\Transport;

abstract class AbstractChat
{
    protected $input;
    protected $output;
    protected $transport;
    protected $name;

    public function __construct(Input $input, Output $output, Transport $transport, string $name)
    {
        $this->input = $input;
        $this->output = $output;
        $this->transport = $transport;
        $this->name = $name;
    }

    public function chat()
    {
        while (true) {
            $message = $this->transport->read();
            if ($message != '') {
                $this->output->write($message);
            }

            $message = $this->input->read();
            if ($message != '') {
                $this->transport->write($this->formatMessage($message));
            }

            sleep(1);
        }
    }

    private function formatMessage($message)
    {
        return sprintf('[%s] %s', $this->name, $message);
    }
}
