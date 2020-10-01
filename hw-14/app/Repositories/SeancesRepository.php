<?php


namespace App\Repositories;


use App\Entities\Film;
use App\Entities\Seance;
use Carbon\Carbon;
use Otus\DBConnection;

class SeancesRepository extends BaseRepository
{

    const SEQ_NAME = 'seances_id_seq';

    public function __construct(DBConnection $db)
    {
        $this->selectStmt = $db->prepare(
            "select id, film_id, price, start_at from seances where id = ?"
        );
        $this->insertStmt = $db->prepare(
            "insert into seances (film_id, price, start_at) values (?,?,?)"
        );
        $this->updateStmt = $db->prepare(
            "update seances set film_id = ?, price = ?, start_at = ? where id = ?"
        );
        $this->deleteStmt = $db->prepare("delete from seances where id = ?");

        $this->lastInsertIdStmt = $db->prepare("SELECT last_value FROM " . self::SEQ_NAME);
    }

    /**
     * @param int $id
     * @return Seance|false
     */
    public function findById(int $id)
    {
        $this->selectStmt->setFetchMode(\PDO::FETCH_ASSOC);
        $this->selectStmt->execute([$id]);
        $result = $this->selectStmt->fetch();

        return $result === false ?
            false :
            new Seance(
                $id,
                (int)$result['film_id'],
                (float)$result['price'],
                new Carbon($result['start_at']),
            );
    }

    /**
     * @param array $raw
     * @return Seance|false
     * @throws \Exception
     */
    public function insert(array $raw)
    {
        $result = $this->insertStmt->execute([
            $raw['film_id'],
            $raw['price'],
            $raw['start_at'],
        ]);

        return $result ?
            new Seance(
                $this->getLasInsertedId(),
                $raw['film_id'],
                $raw['price'],
                new Carbon($raw['start_at'])) :
            false;
    }

    /**
     * @param Seance $film
     * @return bool
     */
    public function update(Seance $film): bool
    {
        return $this->updateStmt->execute([
            $film->getFilmId(),
            $film->getPrice(),
            $film->getStartAt(),
            $film->getId(),
        ]);
    }

    /**
     * @param int $id
     * @return bool
     */
    public function delete(int $id)
    {
        return $this->deleteStmt->execute([$id]);
    }
}
