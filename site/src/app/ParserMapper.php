<?php


namespace App;
use App\Parser;
use App\FactoryMethodInterface;

/**
 * Class ParserMapper
 * @package App
 */
class ParserMapper  implements  FactoryMethodInterface
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
     * @var bool|\PDOStatement
     */
    private $insertStmt;

    /**
     * ParserMapper constructor.
     * @param \PDO $pdo
     */
    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
        $this->insertStmt = $pdo->prepare(
            "insert into parser  ( parser_name, product_id) values (?, ?)"
        );

        $this->selectStmt = $pdo->prepare(
            "select id, parser_name, product_id from parser where id = ?"
        );

    }

    /**
     * @param int $id
     *
     * @return Parser
     */
    public function findById(int $id): Parser
    {
        $this->selectStmt->setFetchMode(\PDO::FETCH_ASSOC);
        $this->selectStmt->execute([$id]);
        $result = $this->selectStmt->fetch();

        return new Parser(
            $id,
            $result['parser_name'],
            $result['product_id']
        );
    }

    /**
     * @param $raw
     * @return  Parser
     */
    public function insert($raw)
    {
        $this->insertStmt->execute([
            $raw['parser_name'],
            $raw['product_id']
        ]);

        return new Parser(
            (int) $this->pdo->lastInsertId(),
            $raw['parser_name'],
            $raw['product_id']
        ) ;
    }
}