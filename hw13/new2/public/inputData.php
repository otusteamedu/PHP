<?php

return [
    'events' => [
        1 => [
            'name' => 'event1',
            'priority' => 1000,
            'conditions' => ['param1' => 1,],
        ],
        2 => [
            'name' => 'event2',
            'priority' => 2000,
            'conditions' => ['param1' => 2, 'param2' => 2,],
        ],
        3 => [
            'name' => 'event3',
            'priority' => 3000,
            'conditions' => ['param1' => 1, 'param2' => 1,],
        ],
    ],
];
