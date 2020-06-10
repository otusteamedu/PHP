<?php

/** @noinspection PhpIllegalPsrClassPathInspection PhpUnhandledExceptionInspection */

use App\Domain\Task;
use Codeception\Test\Unit;
use Codeception\Util\HttpCode;

class ApiTest extends Unit
{
    protected BaseTester $tester;
    protected static array $data = [];

    public function testSet(): void
    {
        $this->tester->sendPOST('/task/set', ['data' => 'test']);
        $this->tester->seeResponseCodeIs(HttpCode::OK);
        $this->tester->seeResponseIsJson();
        $this->tester->seeResponseContains('"id":');
        self::$data['id'] =  $this->tester->grabDataFromResponseByJsonPath('$.id')[0];
    }

    public function testGet(): void
    {
        usleep(100);
        $this->tester->sendPOST('/task/get', ['id' => self::$data['id']]);
        $this->tester->seeResponseCodeIs(HttpCode::OK);
        $this->tester->seeResponseIsJson();
        $this->tester->seeResponseContainsJson(['status' => Task::STATUS_DONE]);
    }
}
