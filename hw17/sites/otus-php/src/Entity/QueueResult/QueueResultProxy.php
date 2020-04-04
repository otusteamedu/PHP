<?php

declare(strict_types=1);

namespace App\Entity\QueueResult;

use App\Entity\BaseProxy;

class QueueResultProxy extends BaseProxy
{
    protected $clientId;

    protected $messageId;

    protected $queueName;

    protected $success;
}
