<?php

declare(strict_types=1);

namespace Socket\Ruvik\Controller;

use Socket\Ruvik\DTO\InputArgs;
use Socket\Ruvik\DTO\SocketConfig;
use Socket\Ruvik\Factory\SocketFactory;
use Socket\Ruvik\Service\IniManager;

class ServerController implements ControllerInterface
{
    /** @var SocketFactory */
    private SocketFactory $socketFactory;
    /** @var IniManager */
    private IniManager $iniManager;
    /** @var SocketConfig */
    private $socketConfig;

    public function __construct(SocketFactory $socketFactory, SocketConfig $socketConfig)
    {
        $this->socketFactory = $socketFactory;
        $this->socketConfig = $socketConfig;
    }

    public function run(InputArgs $inputArgs): void
    {
        $socket = $this->socketFactory->createUnixSocket();
        $socket->bind($this->socketConfig->getServerAddress());

        $socket->listen();
        $response = $inputArgs->getMessage() ?? 'Response';

        while(true) {
            if (!socket_set_block($socket)) {
                die('Unable to set blocking mode for socket');
            }
            $buf = '';
            $from = '';

            echo "Ready to receive...\n";

            $client = $socket->accept();

            $input = $client->read(2024);

            if ('exit' === $input)
            {
                $close = socket_close($socket);
                $con = 0;
            }

            if(1 === $con)
            {
                echo $input;
            }

//            echo $input;

//            echo "Received \"$buf\" from $from ($bytesReceived bytes)\n";
//
//            $buf .= ' -> ' . $response;
//            $len = strlen($buf);
//            $bytesSent = $socket->send($buf, $len, $from);
//            echo "Sent \"$buf\" to $from ($bytesSent bytes)\n";

/**/            echo "Request processed\n";
        }
//        $socket->bind()
    }
}
