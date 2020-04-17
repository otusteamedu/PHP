<?php

/** @noinspection PhpIllegalPsrClassPathInspection */

use App\App;
use App\Domain\EventMapper;
use App\Domain\Event;
use Codeception\Test\Unit;

class EventTest extends Unit
{
    protected UnitTester $tester;

    protected $redis;

    protected function setUp(): void {
        new App();
        $this->redis = App::getRedis();
        $this->redis->select(7);
        $this->redis->flushDB();
    }

    protected function tearDown(): void {
        $this->redis->flushDB();
    }

    public function testCRUD(): void
    {
        $mapper = new EventMapper($this->redis);
        $event = new Event(500, ['param2' => 2], ['::event::' => '0']);
        $mapper->save($event);
        $this->assertEquals($event, $mapper->load($event->id));

        $event->priority = 100;
        $event->conditions = ['param1' => 1];
        $event->event = ['::event::' => 'vvwbvw'];
        $mapper->save($event);
        $this->assertEquals($event, $mapper->load($event->id));

        $mapper->delete($event->id);
        $this->assertEquals(null, $mapper->load($event->id));

        $mapper->delete('abrakadabra');
        $this->assertEquals(null, $mapper->load('abrakadabra'));
    }

    public function testFind(): void
    {
        $mapper = new EventMapper($this->redis);
        $events = [
            new Event(500, ['param2' => 2], ['::event::' => '0']),
            new Event(1000, ['param1' => 1], ['::event::' => '1']),
            new Event(2000, ['param1' => 2, 'param2' => 2], ['::event::' => '2']),
            new Event(3000, ['param1' => 1, 'param2' => 2], ['::event::' => '3']),
            new Event(10000, ['param1' => 10, 'param2' => 10], ['::event::' => '4']),
        ];
        foreach ($events as $event) {
            $mapper->save($event);
        }

        $result = $mapper->find(['param1' => 1, 'param2' => 2]);
        $this->assertEquals('3', $result->event['::event::']);

        $events[1]->priority = 5000;
        $mapper->save($events[1]);

        $result = $mapper->find(['param1' => 1, 'param2' => 2]);
        $this->assertEquals('1', $result->event['::event::']);

        $result = $mapper->find([]);
        $this->assertEquals(null, $result);

        $result = $mapper->find(['param1' => 99]);
        $this->assertEquals(null, $result);
    }
}
