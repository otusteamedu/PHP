<?php

declare(strict_types=1);

namespace App\Services\Redis;

use App\Validators\EventValidator;
use Predis\Collection\Iterator;

class EventHandler
{
    /**
     * @var object
     */
    private $db;
    /**
     * @var EventValidator
     */
    private $validator;

    public function __construct(object $db)
    {
        $this->db = $db;
        $this->validator = new EventValidator();
    }

    /**
     * @throws \Exception
     */
    public function add(string $newEvent)
    {
            $validEvent = $this->validator->validateEvent($newEvent);

            $key = bin2hex(random_bytes(5));
            $key = "events:{$key}";
            $dbResponse = $this->db->executeRaw(['JSON.SET', $key, '.', $validEvent]);

            if (!$dbResponse == 'OK') {
                throw new \Exception("Событие не было добавлено. Ошибка: {$dbResponse}");
            }

            return $key;
    }

    /**
     * @throws \Exception
     */
    public function query($query): string
    {
        $validQuery = $this->validator->validateQuery($query);
        $events = $this->getEvents();
        $fitEvent = $this->chooseEvent($validQuery, $events);
        $result = $this->sendEventToService($fitEvent);

        if (!$result) {
            throw new \Exception("При отравке события {$fitEvent} на сервис возникла ошибка");
        }

        return $fitEvent;
    }

    /**
     * @throws \Exception
     */
    public function getEvents()
    {
        $availableEvents = $this->getEventsKeys();

        $getParams[] = 'JSON.MGET';
        foreach ($availableEvents as $key) {
            $getParams[] = $key;
            $getParams[] = '.';
        }

        $dbResponse = $this->db->executeRaw($getParams);

        if (!is_array($dbResponse)) {
            throw new \Exception($dbResponse);
        }
        if (empty($dbResponse) || empty($dbResponse[0])) {
            throw new \Exception('Ошибка при получении доступных событий');
        }

        $dbResponse = array_filter($dbResponse);
        foreach ($dbResponse as $key => $item) {
            $dbResponse[$key] = json_decode($item, true);
        }

        return $dbResponse;
    }

    /**
     * @throws \Exception
     */
    public function chooseEvent(array $query, array $events): string
    {
        $fitEvents = [];
        foreach ($events as $event) {
            if (!empty(array_diff_assoc($query, $event['conditions']))) {
                continue;
            }
            $fitEvents[$event['priority']] = $event['event']['name'];
        }

        if (empty($fitEvents)) {
            throw new \Exception('Нет подходящих событий');
        }

        arsort($fitEvents);
        $result = reset($fitEvents);

        return utf8_decode($result);
    }

    public function sendEventToService(string $event): bool
    {
        // TODO добавить отправку в сервис
        $result = true;

        return $result;
    }

    /**
     * @throws \Exception
     */
    public function dropEvents()
    {
        $availableEvents = $this->getEventsKeys();

        foreach ($availableEvents as $key) {
            $dbResponse = $this->db->executeRaw(['JSON.DEL', $key, '.']);
            if (!is_integer($dbResponse)) {
                throw new \Exception($dbResponse);
            }
        }
    }

    /**
     * @throws \Exception
     */
    public function getEventsKeys(): Iterator\Keyspace
    {
        $availableEvents = new Iterator\Keyspace($this->db, 'events:*');

        $count = 0;
        foreach ($availableEvents as $item) {
            ++$count;
        }

        if ($count == 0) {
            throw new \Exception('Нет доступных событий');
        }

        return $availableEvents;
    }
}