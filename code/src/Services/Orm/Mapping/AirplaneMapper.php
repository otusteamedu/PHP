<?php


namespace App\Services\Orm\Mapping;


use App\Model\Airplane;
use App\Model\Builders\AirplaneBuilder;
use App\Services\Orm\Interfaces\OrmModelInterface;
use App\Services\Orm\Exceptions\OrmMappingInsertException;
use PDO;


class AirplaneMapper extends AbstractMapper
{
    const TABLE_NAME = 'airplanes';

    /**
     * AirplaneMapper constructor.
     * @param PDO $pdo
     */
    public function __construct(PDO $pdo)
    {
        parent::__construct($pdo);
        $this->builder = new AirplaneBuilder();
    }


    /**
     * @param array $raw
     * @return Airplane
     * @throws OrmMappingInsertException
     */
    public function insert(array $raw): Airplane
    {
        $airlineId = $raw['airline_id'] ?? null;
        $this->insertStmt->execute([
            $raw['name'],
            $raw['number'],
            $raw['seats_count'],
            $raw['build_date'],
            $airlineId,
        ]);

        if (!$result = $this->insertStmt->fetch()) {
            throw new OrmMappingInsertException('Airplane mapper');
        }

        return $this->builder->build(array_merge(['id' => $result['id']], $raw));
    }

    public function update(OrmModelInterface $model): bool
    {
        return $this->updateStmt->execute([
            $model->getName(),
            $model->getNumber(),
            $model->getSeatsCount(),
            $model->getBuildDate()->format('Y-m-d'),
            $model->getAirlineId(),
            $model->getId(),
        ]);
    }

    public function delete(OrmModelInterface $model): bool
    {
        $id = $model->getId();
        return (bool)$this->deleteStmt->execute([$id]);
    }

    public function findById(int $id): ?Airplane
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
            ' (name, number, seats_count, build_date, airline_id) VALUES (?, ?, ?, ?, ?) returning id';
    }

    protected function getUpdateQuery(): string
    {
        return 'UPDATE ' . self::TABLE_NAME .
            ' SET name = ?, number = ?, seats_count = ?, build_date = ?, airline_id = ? WHERE id = ?';
    }

    protected function getDeleteQuery(): string
    {
        return 'DELETE FROM ' . self::TABLE_NAME . ' WHERE id = ? returning id';
    }
}
