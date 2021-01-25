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
        $content = [];
        for ($i = 0; $i < 5; $i++) {
            $content[] = $mapper->insert(new ContentDTO('php' . random_int(0, 1000), 1, random_int(0, 1000), random_int(60, 120)));
        }
        $this->isSameObjects($content[0], $mapper);

        $content[1]->setName('php00000000');
        $mapper->update($content[1]);
        $this->isSameObjects($content[1], $mapper);

        $collection = $mapper->getBatch();
        foreach ($collection as $key => $item) {
            $this->isSameObjects($item, $mapper);
        }

    }

    /**
     * @param Content $content
     * @param MapperInterface $mapper
     */
    private function isSameObjects(Content $content, ContentMapper $mapper): void
    {
        $checkedContent = $mapper->findById($content->getId());
        $result = $content === $checkedContent;
        View::showChecking($result);
    }

}