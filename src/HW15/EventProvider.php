<?php
declare(strict_types=1);

namespace HW15;

use ArrayObject;
use Predis\Client;
use Predis\Transaction\MultiExec;
use stdClass;

const EVENT_LAST_ID = 'event:lastId';
const EVENT = 'event:';

class EventProvider
{
    /**
     * @var Client
     */
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function store(Event $event): void
    {
        $that = $this;
        /** @var  $responses */
        $this->client->transaction(static function ($tx) use ($that, $event) {
            /** @var MultiExec $tx */
            $id = $that->client->incr(EVENT_LAST_ID);
            $key = $that->buildKeyByConditions($event->conditions);
            $tx->zadd($key, [$id => $event->priority]);
            $tx->set(EVENT . $id, serialize($event));
        });
    }

    /**
     * @param array $conditions
     * @return string
     */
    public static function buildKeyByConditions(array $conditions): string
    {
        $arrayCopy = (new ArrayObject($conditions))->getArrayCopy();
        asort($arrayCopy);
        return http_build_query($conditions);
    }

    public function match(array $conditions): ?Event
    {
        $event = null;
        $matchedId = null;
        $matchedKey = null;
        $maxPriority = PHP_INT_MIN;
        foreach ($this->subs($conditions) as $conditionsVariant) {
            $key = self::buildKeyByConditions($conditionsVariant);
            if ($this->client->exists($key)) {
                $id = current($this->client->zrevrange($key, 0, 1, []));
                $e = $this->getEvent($id);
                if ($e->priority > $maxPriority) {
                    $matchedKey = $key;
                    $matchedId = $id;
                }
            }
        }
        if ($matchedKey && $matchedId) {
            $this->client->zrem($matchedKey, $matchedId);
            $event = $this->getEvent($matchedId);
            $this->client->del([EVENT . $matchedId]);
        }
        return $event;
    }

    public function clean(): void
    {
        $cursor = 0;
        do {
            [$cursor, $keys] = $this->client->scan($cursor);
            if (!empty($keys)) {
                $this->client->del($keys);
            }
        } while ($cursor > 0);
    }
    /**
     * Thanks to https://github.com/mjacobsz/php_array_subarrays/blob/master/main.php
     * @param $a
     * @return array
     */
    private function subs($a): array
    {
        $ak = array_keys($a);
        // Create an container array to store all subsets
        $subarrays = array();

        // Get all subsets in this loop
        $number_of_subsets = 2 ** count($a);
        for ($i = 0; $i < $number_of_subsets; $i++) {
            // New subarray
            $subarray = array();
            // Create the bitmap
            $n = strrev(decbin($i)); // Reverse the bitstring, so it matches array ordering
            $binary_map_of_elements_to_include = str_split($n);

            $length_of_binary_map = count($binary_map_of_elements_to_include);
            for ($j = 0; $j < $length_of_binary_map; $j++) {

                // Insert the element when we encounter a '1'
                if ($binary_map_of_elements_to_include[$j] === '1') {

                    if (is_string($ak[$j])) {            // When the key is a string, we want to copy this key to the subarray
                        $subarray[$ak[$j]] = $a[$ak[$j]];
                    } else {
                        $subarray[] = $a[$ak[$j]];         // When the key is a integer, just do the regular index numbering
                    }

                }
            }

            // Add subarray to the list of results
            $subarrays[] = $subarray;
        }
        return $subarrays;
    }

    /**
     * @param $id
     * @return Event
     */
    private function getEvent($id): Event
    {
        $ev = $this->client->get(EVENT . $id);
        /** @var Event $e */
        $e = unserialize($ev, ['allowed_classes' => [Event::class, stdClass::class]]);
        return $e;
    }


}