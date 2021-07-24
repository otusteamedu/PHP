<?php


namespace src\Models;


use Services\Dao\DataMapper\Movie\Movie;
use Services\Dao\DataMapper\Movie\MovieMapper;
use Services\Dto\MovieDto;

class MovieModel extends BaseModel
{
    /**
     * @param $id
     * @return Movie
     */
    public function getById($id):Movie
    {
        return $this->dataAccess->getMovie($id);
    }

    /**
     * @param MovieDto $data
     * @return Movie
     */
    public function insert(MovieDto $data): Movie
    {
        return $this->dataAccess->insertMovie($data);
    }

    /**
     * @param $movie
     * @return bool
     */
    public function update($movie): bool
    {
        return $this->dataAccess->updateMovie($movie);
    }

    /**
     * @param $id
     * @return bool
     */
    public function delete($id): bool
    {
        return $this->dataAccess->deleteMovie($id);
    }

}
