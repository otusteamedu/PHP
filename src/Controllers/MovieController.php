<?php


namespace src\Controllers;


use Services\Dao\DataMapper\Movie\Movie;

class MovieController extends BaseController
{
    public function run()
    {
        echo "<pre>";
        $id = $_GET['id'];
        $this->showMovies([$this->model->getById($id)->asArray()]);
    }

    public function insert()
    {
        echo "<pre>";
        $data = unserialize(
            file_get_contents('/var/www/html/otus.loc/redis/data.txt')
        );
        $this->showMovies([$this->model->insert($data)->asArray()]);
    }

    public function update()
    {
        echo "<pre>";
        $id = $_GET['id'];
        $movie = $this->model->getById($id);
        $movie->setName($movie->getName() . "-Updated");
        $movie->setMovieGenreId($movie->getMovieGenreId() + 1);
        var_dump($this->model->update($movie));
        $this->showMovies([$this->model->getById($id)->asArray()]);
    }

    public function delete()
    {
        echo "<pre>";
        $id = $_GET['id'];
        var_dump($this->model->delete($id));
    }

    private function showMovies(array $movies): void
    {
        echo "<Table border='1px'>";
        echo "<caption>Таблица фильмов</caption>";
        echo "<tr>";
        foreach (Movie::attributeLabels() as $label) {
            echo "<th>";
            echo $label;
            echo "</th>";
        }
        echo "</tr>";
        foreach ($movies as $movie) {
            echo "<tr>";
            foreach (Movie::attributeLabels() as $key => $label) {
                echo "<td>";
                echo $movie[$key];
                echo "</td>";
            }
            echo "</tr>";
        }
        echo "</Table>";
    }

}
