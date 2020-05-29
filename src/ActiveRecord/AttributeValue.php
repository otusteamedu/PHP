<?php
namespace Otus\ActiveRecord;

class AttributeValue {
    /**
     * @var \PDO
     */
    private $pdo;

    private const TABLE_NAME = 'attribute_value';

    /**
     * @var int
     */
    private $id;

    /**
     * @var int
     */
    private $attributeId;

    /**
     * @var int
     */
    private $filmId;

    /**
     * @var string
     */
    private $valText;

    /**
     * @var float
     */
    private $valNumeric;

    /**
     * @var bool
     */
    private $valBool;

    /**
     * @var string
     */
    private $valDate;

    /**
     * @var \PDOStatement
     */
    private static $selectQuery = "select attribute_id, film_id, val_text, val_numeric, val_bool, val_date from " . self::TABLE_NAME . " where id = ? limit 10";

    /**
     * @var \PDOStatement
     */
    private static $selectListQuery = "select * from " . self::TABLE_NAME . " limit 10";

    /**
     * @var \PDOStatement
     */
    private static $insertRandomQuery = "INSERT INTO " . self::TABLE_NAME . " (attribute_id, film_id, val_text) SELECT (1 + 9*random())::int, (1 + 19*random())::int, random_string( (7 + 30*random())::int ) FROM generate_series(1, ?)";

    /**
     * @var \PDOStatement
     */
    private $updateStmt;

    /**
     * @var \PDOStatement
     */
    private $insertStmt;

    /**
     * @var \PDOStatement
     */
    private $deleteStmt;

    /**
     * @param \PDO $pdo
     */
    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;

        $this->insertStmt = $pdo->prepare(
            "insert into " . self::TABLE_NAME . " (attribute_id, film_id, val_text, val_numeric, val_date, val_bool) values (?, ?, ?, ?, ?, ?)"
        );
        $this->updateStmt = $pdo->prepare(
            "update " . self::TABLE_NAME . " set attribute_id = ?, film_id = ?, val_text = ?, val_numeric = ?, val_date = ?, val_bool = ? where id = ?"
        );
        $this->deleteStmt = $pdo->prepare("delete from " . self::TABLE_NAME . " where id = ?");
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return $this
     */
    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return int
     */
    public function getAttributeId(): int
    {
        return $this->attributeId;
    }

    /**
     * @param int $id
     * @return $this
     */
    public function setAttributeId(int $id): self
    {
        $this->attributeId = $id;
        return $this;
    }

    /**
     * @return int
     */
    public function getFilmId(): int
    {
        return $this->filmId;
    }

    /**
     * @param int $id
     * @return $this
     */
    public function setFilmId(int $id): self
    {
        $this->filmId = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getValText(): string
    {
        return $this->valText;
    }

    /**
     * @param string $val
     * @return $this
     */
    public function setValText(string $val): self
    {
        $this->valText = $val;
        return $this;
    }

    /**
     * @return float
     */
    public function getValNumeric(): float
    {
        return $this->valNumeric;
    }

    /**
     * @param float $val
     * @return $this
     */
    public function setValNumeric(float $val): self
    {
        $this->valNumeric = $val;
        return $this;
    }

    /**
     * @return bool
     */
    public function getValBool(): bool
    {
        return $this->valBool;
    }

    /**
     * @param bool $val
     * @return $this
     */
    public function setValBool(bool $val): self
    {
        $this->valBool = $val;
        return $this;
    }

    /**
     * @return string
     */
    public function getValDate(): string
    {
        return $this->valDate;
    }

    /**
     * @param string $val
     * @return $this
     */
    public function setValDate(string $val): self
    {
        $this->valDate = $val;
        return $this;
    }

    /**
     * @param \PDO $pdo
     * @param int $id
     * @return static
     */
    public static function getById(\PDO $pdo, int $id): self
    {
        $selectStmt = $pdo->prepare(self::$selectQuery);
        $selectStmt->setFetchMode(\PDO::FETCH_ASSOC);
        $selectStmt->execute([$id]);
        $result = $selectStmt->fetch();

        $row = new self($pdo);
        $row
            ->setId($id)
            ->setAttributeId($result['attribute_id'])
            ->setFilmId($result['film_id']);


        if ($result['val_text']) {
            $row->setValText($result['val_text']);
        } elseif ($result['val_numeric']) {
            $row->setValNumeric($result['val_numeric']);
        } elseif ($result['val_bool']) {
            $row->setValBool($result['val_bool']);
        } elseif ($result['val_date']) {
            $row->setValDate($result['val_date']);
        }

        return $row;
    }

    /**
     * @param \PDO $pdo
     * @return \DS\Vector
     */
    public static function getList(\PDO $pdo): \DS\Vector
    {
        $selectStmt = $pdo->prepare(self::$selectListQuery);
        $selectStmt->setFetchMode(\PDO::FETCH_OBJ);
        $selectStmt->execute();

        $result = new \DS\Vector();

        while ($record = $selectStmt->fetch()) {
            $collectionItem = new self($pdo);

            $collectionItem
                ->setId($record->id)
                ->setAttributeId($record->attribute_id)
                ->setFilmId($record->film_id);

            if ($record->val_text) {
                $collectionItem->setValText($record->val_text);
            } elseif ($record->val_numeric) {
                $collectionItem->setValNumeric($record->val_numeric);
            } elseif ($record->val_bool) {
                $collectionItem->setValBool($record->val_bool);
            } elseif ($record->val_date) {
                $collectionItem->setValDate($record->val_date);
            }

            $result->push($collectionItem);
        }

        return $result;
    }

    /**
     * @return bool
     */
    public function insert(): bool
    {
        $result = $this->insertStmt->execute([
            $this->attributeId,
            $this->filmId,
            $this->valText,
            $this->valNumeric,
            $this->valDate,
            $this->valBool
        ]);

        $this->id = $this->pdo->lastInsertId();

        return $result;
    }

    /**
     * @return bool
     */
    public function update(): bool
    {
        return $this->updateStmt->execute([
            $this->attributeId,
            $this->filmId,
            $this->valText,
            $this->valNumeric,
            $this->valDate,
            $this->valBool,
            $this->id
        ]);
    }

    /**
     * @return bool
     */
    public function delete(): bool
    {
        $id = $this->id;
        $this->id = null;

        return $this->deleteStmt->execute([
            $id
        ]);
    }

    /**
     * @param \PDO $pdo
     * @param int $count
     * @return bool
     */
    public static function addRandomRows(\PDO $pdo, int $count): bool
    {
        $insertStmt = $pdo->prepare(self::$insertRandomQuery);
        $insertStmt->setFetchMode(\PDO::FETCH_OBJ);

        return $insertStmt->execute([
            $count
        ]);
    }
}
