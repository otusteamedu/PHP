<?php

return [
    '/pushMessage' => [
        'method' => ['POST'],
        'action' => 'PublisherController@registerQueueMessage',
    ],
    '/queue/status/{id}' => [
        'method' => ['GET'],
        'action' => 'PublisherController@getJobStatus',
    ],
    '/pull' => [
        'method' => ['POST'],
        'action' => 'ConsumerController@handle',
    ],
];
