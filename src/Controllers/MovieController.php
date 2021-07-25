<?php


namespace src\Controllers;


use Services\Dao\DataMapper\Movie\Movie;

class MovieController extends BaseController
{
    public function run()
    {
        echo "<pre>";
        $id = $_GET['id'];
        $this->showMovies([$this->model->getById($id)]);
    }

    public function all()
    {
        echo "<pre>";
        $this->showMovies($this->model->get());

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
        // $movie = $this->model->getById($id);
        $movie1 = $this->model->getById($id);
        $movie2 = $this->model->getById($id);
        $movie3 = $this->model->getById($id);

        $movie1->setName($movie1->getName() . "-Updated");
        $movie2->setMovieGenreId($movie2->getMovieGenreId() + 1);
        $movie3->setAgeLimit($movie2->getAgeLimit() + 1);
        var_dump($this->model->update($movie1));
        $this->showMovies([$this->model->getById($id)]);
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
                echo $movie->{'get'.$key}();
                echo "</td>";
            }
            echo "</tr>";
        }
        echo "</Table>";
    }

}
