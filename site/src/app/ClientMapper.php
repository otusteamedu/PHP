<?php


namespace App;
use App\Client;
use App\FactoryMethodInterface;

/**
 * Class ClientMapper
 * @package App
 */
class ClientMapper implements FactoryMethodInterface
{
    /**
     * @var \PDO
     */
    private $pdo;

    /**
     * @var bool|\PDOStatement
     */
    private $selectStmt;

    /**
     * ClientMapper constructor.
     * @param \PDO $pdo
     */
    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;


        $this->selectStmt = $pdo->prepare(
            "select id, name_client from client where id = ?"
        );

    }

    /**
     * @param int $id
     *
     * @return Client
     */
    public function findById(int $id): Client
    {
        $this->selectStmt->setFetchMode(\PDO::FETCH_ASSOC);
        $this->selectStmt->execute([$id]);
        $result = $this->selectStmt->fetch();

        return new Client(
            $id,
            $result['name_client']
        );
    }

}