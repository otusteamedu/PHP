<?php

namespace HW15;

use Predis\Client;
use stdClass;

include __DIR__ . '/vendor/autoload.php';

$eventObject = new stdClass();
$eventObject->title = 'Title';

$ep = new EventProvider(new Client(['host' => 'redis']));

$eventsCount = 100;
echo "\nFill REDIS with {$eventsCount} events ...";
for ($i = 0; $i < $eventsCount; $i++) {
    $event = new Event();
    $eventObject->title = 'I\'m the event #' . $i;
    $event->event = $eventObject;
    $conditions = ['param1' => $i % 3];
    if ($i % 2 === 0) {
        $conditions['param2'] = ($i * random_int(13, 17)) % 3;
    }
    $event->conditions = $conditions;
    $event->priority = 1000 * random_int(0, 10);
    $ep->push($event);
}

echo "\nAsk REDIS for events 9 times...";

echo "\n" . $ep->pop(['param1' => 1]);
echo "\n" . $ep->pop(['param1' => 2, 'param2' => 1]);
echo "\n" . $ep->pop(['param1' => 0]);

echo "\n" . $ep->pop(['param1' => 0]);
echo "\n" . $ep->pop(['param1' => 1]);
echo "\n" . $ep->pop(['param1' => 2, 'param2' => 1]);

echo "\n" . $ep->pop(['param1' => 2, 'param2' => 1]);
echo "\n" . $ep->pop(['param1' => 1]);
echo "\n" . $ep->pop(['param1' => 0]);

echo "\n" . $ep->pop(['param1' => 1]);
echo "\n" . $ep->pop(['param1' => 2, 'param2' => 1]);
echo "\n" . $ep->pop(['param1' => 0]);

echo "\n" . $ep->pop(['param1' => 1]);
echo "\n" . $ep->pop(['param1' => 0]);
echo "\n" . $ep->pop(['param1' => 2, 'param2' => 1]);
echo "\n" . ($ep->pop(['param666' => 666, 'param999' => 999]) ?? 'I\'M NOT EVENT - BUT NULL');

echo "\nCleanup...";
$ep->clear();
echo "\nDone.\n";
