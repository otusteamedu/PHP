<?php


namespace App;
use App\Type;
use App\FactoryMethodInterface;

/**
 * Class TypeMapper
 * @package App
 */
class TypeMapper implements FactoryMethodInterface
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
     * TypeMapper constructor.
     * @param \PDO $pdo
     */
    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;


        $this->selectStmt = $pdo->prepare(
            "select id, name_type from public.type where id = ?"
        );

    }

    /**
     * @param int $id
     *
     * @return Type
     */
    public function findById(int $id): Type
    {
        $this->selectStmt->setFetchMode(\PDO::FETCH_ASSOC);
        $this->selectStmt->execute([$id]);
        $result = $this->selectStmt->fetch();

        return new Type(
            $id,
            $result['name_type']
        );
    }

}