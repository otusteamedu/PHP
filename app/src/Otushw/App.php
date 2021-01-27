<?php


namespace Otushw;

use Otushw\Storage\DBConnection;
use Otushw\Storage\ContentMapper;
use PDO;

/**
 * Class App
 *
 * @package Otushw
 */
class App
{
    /**
     * @var PDO
     */
    private PDO $pdo;

    /**
     * App constructor.
     *
     * @throws Exception\AppException
     */
    public function __construct()
    {
        $this->pdo = DBConnection::getInstance();
    }

    /**
     * @throws Exception\MapperException
     */
    public function run(): void
    {
        $mapper = new ContentMapper($this->pdo);
        $mapper->demonstrate();
    }


}