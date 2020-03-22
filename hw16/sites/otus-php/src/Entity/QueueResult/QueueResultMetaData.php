<?php

declare(strict_types=1);

namespace App\Entity\QueueResult;

use App\Entity\BaseMetaData;

class QueueResultMetaData extends BaseMetaData
{
    protected $table = 'queue_results';
    protected $repository = 'App\Repository\QueueResultRepository';
    protected $entity = 'App\Entity\QueueResult\QueueResult';

    private $clientId = [
        'db_nullable' => false,
        'table_col' => 'client_id',
    ];

    private $messageId = [
        'db_nullable' => false,
        'table_col' => 'message_id',
    ];

    private $queueName = [
        'db_nullable' => false,
        'table_col' => 'queue_name',
    ];

    private $success = [
        'db_nullable' => false,
    ];
}