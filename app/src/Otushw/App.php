<?php


namespace Otushw;

use Otushw\Storage\DBConnection;
use Otushw\Storage\ContentMapper;
use PDO;

class App
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = DBConnection::getInstance();
    }

    public function run(): void
    {
        $storage = new ContentMapper($this->pdo);
//        $storage->findById(1);
//        $r = $storage->insert(new ContentDTO('php999', 1, 18, 180));
//        $r = $storage->update(new Content(1, 'movie1_new', 1, 1, 1));
//        $r = $storage->delete(new Content(100001, 'movie1_new', 1, 1, 1));
//        $storage->getBatch();
    }

}