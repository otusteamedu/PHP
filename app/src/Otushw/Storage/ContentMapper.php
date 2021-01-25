<?php


namespace Otushw\Storage;

use Otushw\ContentWatcher;
use PDO;
use PDOException;
use PDOStatement;
use Otushw\Content;
use Otushw\ContentDTO;
use Otushw\ContentCollection;
use Otushw\Exception\MapperException;
use Otushw\Storage\MapperInterface;

/**
 * Class ContentMapper
 *
 * @package Otushw
 */
class ContentMapper implements MapperInterface
{

    /**
     * @var PDO
     */
    private PDO $pdo;

    /**
     * @var PDOStatement
     */
    private PDOStatement $selectStmt;

    /**
     * @var PDOStatement
     */
    private PDOStatement $insertStmt;

    /**
     * @var PDOStatement
     */
    private PDOStatement $updateStmt;

    /**
     * @var PDOStatement
     */
    private PDOStatement $deleteStmt;

    /**
     * @var PDOStatement
     */
    private PDOStatement $batchStmt;

    /**
     * ContentMapper constructor.
     *
     * @param PDO $pdo
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

        $this->batchStmt = $pdo->prepare(
            'select id, name, id_genre, age_limit, movie_length from content order by id DESC limit ?  offset ?'
        );
    }

    /**
     * @param int $id
     *
     * @return null|Content
     * @throws MapperException
     */
    public function findById(int $id): ?Content
    {
        $current = $this->getFromMap($id);
        if (!is_null($current)) {
            return $current;
        }

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

        $content = new Content(
            $id,
            $result['name'],
            $result['id_genre'],
            $result['age_limit'],
            $result['movie_length'],
        );
        $this->addToMap($content);

        return $content;
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
        $content = new Content(
            (int) $id,
            $content->name,
            $content->id_genre,
            $content->age_limit,
            $content->move_lenght
        );
        $this->addToMap($content);
        return $content;
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

        if ($result) {
            $this->addToMap($content);
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

        if ($result) {
            $this->deleteFromMap($id);
        }

        return $result;
    }

    /**
     * @param int $number
     * @param int $offset
     *
     * @return null|ContentCollection
     * @throws MapperException
     */
    public function getBatch(int $limit = 5, int $offset = 0): ?ContentCollection
    {
        try{
            $this->batchStmt->setFetchMode(PDO::FETCH_ASSOC);
            $this->batchStmt->execute([$limit, $offset]);
            $result = $this->batchStmt->fetchAll();
        } catch (PDOException $e) {
            throw new MapperException($e->getMessage(), $e->getCode());
        }

        if (empty($result)) {
            return null;
        }
        return new ContentCollection($result);
    }

    /**
     * @param int $id
     *
     * @return Content|null
     */
    private function getFromMap(int $id): ?Content
    {
        return ContentWatcher::getItem($id);
    }

    /**
     * @param Content $content
     */
    private function addToMap(Content $content)
    {
        return ContentWatcher::store($content);
    }

    /**
     * @param Content $content
     */
    private function deleteFromMap(int $id): bool
    {
        return ContentWatcher::remove($id);
    }


}