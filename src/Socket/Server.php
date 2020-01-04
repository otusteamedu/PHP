<?php

namespace Tirei01\Hw4\Socket;

class Server extends Socket
{
    protected function sendConferm()
    {
        $this->send("message [\"" . $this->buf . "\"] got", $this->from);
    }

    public function loop()
    {
        $this->bind();
        while (true) {
            $this->block();
            $this->get();
            yield $this->getMessage();
            $this->nonBlock();
            $this->sendConferm();
        }
        $this->close();
    }
}