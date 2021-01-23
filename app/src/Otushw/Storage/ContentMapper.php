<?php


namespace Otushw\Storage;

use PDO;
use PDOException;
use PDOStatement;
use Otushw\Content;
use Otushw\ContentDTO;
use Otushw\Exception\MapperException;
use Otushw\Storage\StorageInterface;

/**
 * Class ContentMapper
 *
 * @package Otushw
 */
class ContentMapper implements StorageInterface
{

    private PDO $pdo;
    private PDOStatement $selectStmt;
    private PDOStatement $insertStmt;
    private PDOStatement $updateStmt;
    private PDOStatement $deleteStmt;

    /**
     * ContentMapper constructor.
     */
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;

        $this->selectStmt = $pdo->prepare(
            "select name, id_genre, age_limit, movie_length from content where id = ?"
        );
        $this->insertStmt = $pdo->prepare(
            "insert into content (name, id_genre, age_limit, movie_length) values (?, ?, ?, ?)"
        );
        $this->updateStmt = $pdo->prepare(
            "update content set name = ?, id_genre = ?, age_limit = ?, movie_length = ? where id = ?"
        );
        $this->deleteStmt = $pdo->prepare("delete from content where id = ?");
    }

    /**
     * @param int $id
     *
     * @return Content
     * @throws MapperException
     */
    public function findById(int $id): ?Content
    {
        try {
            $this->selectStmt->setFetchMode(PDO::FETCH_ASSOC);
            $this->selectStmt->execute([$id]);
            $result = $this->selectStmt->fetch();
        } catch (PDOException $e) {
            throw new MapperException($e->getMessage(), $e->getCode());
        }

        if (empty($result)) {
            return null;
        }

        return new Content(
            $id,
            $result['name'],
            $result['id_genre'],
            $result['age_limit'],
            $result['movie_length'],
        );
    }

    /**
     * @param ContentDTO $content
     *
     * @return Content
     * @throws MapperException
     */
    public function insert(ContentDTO $content): Content
    {
        try {
            $result = $this->insertStmt->execute([
                $content->name,
                $content->id_genre,
                $content->age_limit,
                $content->move_lenght
            ]);
        } catch (PDOException $e) {
            throw new MapperException($e->getMessage(), $e->getCode());
        }

        if (empty($result)) {
            throw new MapperException(
                'it is not possible to add a record to the table "content"'
            );
        }
        $id = (int) $this->pdo->lastInsertId('content_id_seq');
        return new Content(
            (int) $id,
            $content->name,
            $content->id_genre,
            $content->age_limit,
            $content->move_lenght
        );
    }

    /**
     * @param Content $content
     *
     * @return bool
     */
    public function update(Content $content): bool
    {
        $id = $content->getId();
        try {
            $result = $this->updateStmt->execute([
                $content->getName(),
                $content->getIdGenre(),
                $content->getAgeLimit(),
                $content->getMoveLenght(),
                $id
            ]);
        } catch (PDOException $e) {
            throw new MapperException($e->getMessage(), $e->getCode());
        }

        return $result;
    }

    /**
     * @param Content $content
     *
     * @return bool
     */
    public function delete(Content $content): bool
    {
        try {
            $result = $this->deleteStmt->execute([$content->getId()]);
        } catch (PDOException $e) {
            throw new MapperException($e->getMessage(), $e->getCode());
        }

        return $result;
    }
}