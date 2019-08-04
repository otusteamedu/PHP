<?php

namespace Test;

use App\Config;
use App\Db\Connect;
use App\Db\Repository;
use App\Service\ApiService;
use PHPUnit\Framework\TestCase;

/**
 * Class ApiServiceTest
 */
class ApiServiceTest extends TestCase
{
    /**
     * @test
     */
    public function getResponse()
    {
        $config = new Config();
        $connect = new Connect($config);
        $repository = new Repository($connect);
        $apiService = new ApiService($repository);

        $this->assertEquals(
            '{"code":200,"status":"ok","message":"ok"}',
            $apiService->getResponse(200, 'ok')
        );
    }
}
