<?php


namespace App\Services\Orm\Mapping;


use App\Model\Airline;
use App\Model\Builders\AirlineBuilder;
use App\Services\Orm\Interfaces\OrmModelInterface;
use App\Services\Orm\Exceptions\OrmMappingInsertException;
use App\Services\Orm\ModelManager;
use PDO;


class AirlineMapper extends AbstractMapper
{
    const TABLE_NAME = 'airlines';

    /**
     * AirlineMapper constructor.
     * @param PDO $pdo
     * @param ModelManager $mm
     */
    public function __construct(PDO $pdo, ModelManager $mm)
    {
        parent::__construct($pdo);
        $this->builder = new AirlineBuilder($mm);
    }


    /**
     * @param array $raw
     * @return Airline
     * @throws OrmMappingInsertException
     */
    public function insert(array $raw): Airline
    {
        $this->insertStmt->execute([
            $raw['name'],
            $raw['abbreviation'],
            $raw['description']
        ]);
        if (!$result = $this->insertStmt->fetch()) {
            throw new OrmMappingInsertException('Airline mapper');
        }

        return $this->builder->build(array_merge($raw, $result));
    }

    public function update(OrmModelInterface $model): bool
    {
        return $this->updateStmt->execute([
            $model->getName(),
            $model->getAbbreviation(),
            $model->getDescription(),
            $model->getId()
        ]);
    }

    public function delete(OrmModelInterface $model): bool
    {
        $id = $model->getId();
        return (bool)$this->deleteStmt->execute([$id]);
    }

    public function findById(int $id): ?Airline
    {
        $this->selectStmt->execute([$id]);
        $raw = $this->selectStmt->fetch();
        if (!$raw) {
            return null;
        }
        return $this->builder->build($raw);
    }

    protected function getSelectQuery(): string
    {
        return 'SELECT * FROM ' . self::TABLE_NAME . ' WHERE id = ?';
    }

    protected function getInsertQuery(): string
    {
        return 'INSERT into ' . self::TABLE_NAME .
            ' (name, abbreviation, description) VALUES (?, ?, ?) returning id';
    }

    protected function getUpdateQuery(): string
    {
        return 'UPDATE ' . self::TABLE_NAME .
            ' SET name = ?, abbreviation = ?, description = ? WHERE id = ?';
    }

    protected function getDeleteQuery(): string
    {
        return 'DELETE FROM ' . self::TABLE_NAME . ' WHERE id = ? returning id';
    }
}
