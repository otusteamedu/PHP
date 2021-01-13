<?php

namespace App;

use App\Enum\NodeEnum;
use Exception;

/**
 * Class App
 * @package App
 */
class App
{
    /**
     * @throws Exception
     */
    public function run()
    {
        $arg = $_SERVER['argv'][1];

        if (!in_array($arg, [NodeEnum::CLIENT, NodeEnum::SERVER, ])) {
            throw new Exception('Invalid argument');
        }

        $node = new SocketNode();
        if ($arg == 'server') {
            $node->listeningSocket();
        } else {
            $node->useSocket();
            $node->sentData();
        }
    }
}