<?php

namespace Otus;

use PDO;

class Inserter
{
    /**
     * PDO object
     * @var PDO
     */
    private $pdo;

    private $rowsCount = 0;
    private $rowsNeeded = 0;
    private $baseTables = ['genre', 'film', 'hall', 'seance', 'seat', 'ticket', 'attribute_name', 'attribute_type', 'attribute_value', 'film_attribute'];

    /**
     * init the object with a \PDO object
     * @param type $pdo
     */
    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    private function incrementRowsCount(int $count)
    {
        $this->rowsCount += $count;
    }

    private function setRowsNeeded(int $count)
    {
        $this->rowsNeeded = $count;
    }

    private function countTotalRows()
    {
        foreach ($this->baseTables as $table) {
            $this->incrementRowsCount($this->countRows($table));
        }
    }

    private function countRows(string $tableName): int
    {
        return (int)$this->pdo->query('SELECT * FROM ' . $tableName)->rowCount();
    }

    private function getIdsFromTable(string $tableName, string $where = null): array
    {
        return $this->pdo->query('SELECT id FROM ' . $tableName . ($where ? ' WHERE ' . $where : ''))->fetchAll(PDO::FETCH_COLUMN, 0);
    }

    private function getDataFromTable(string $tableName, array $columns, string $where = null): array
    {
        return $this->pdo->query('SELECT ' . implode(', ', $columns) . ' FROM ' . $tableName . ($where ? ' WHERE ' . $where : ''))->fetchAll();
    }

    private function insertTransaction(string $tableName, array $columns, array $values, bool $withoutTransaction = false)
    {
        $this->pdo->beginTransaction();
        $insert_values = array();
        $question_marks = array();
        foreach ($values as $row) {
            $question_marks[] = '(' . $this->getPlaceholders('?', sizeof($columns)) . ')';
            $insert_values = array_merge($insert_values, array_values($row));
        }
        $sql = "INSERT INTO $tableName (" . implode(",", $columns) . ") VALUES " . implode(',', $question_marks);
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($insert_values);
        $this->pdo->commit();
    }

    private function getPlaceholders($text, $count = 0, $separator = ",")
    {
        $result = array();
        if ($count > 0) {
            for ($x = 0; $x < $count; $x++) {
                $result[] = $text;
            }
        }
        return implode($separator, $result);
    }

    public function insertData(string $type)
    {
        $this->generateAttributes();
        switch ($type) {
            case 's':
                echo 'Inserting small dataset (~10000 rows)' . PHP_EOL;
                $this->setRowsNeeded(10000);
                break;
            case 'b':
                echo 'Inserting big dataset (~10000000 rows)' . PHP_EOL;
                $this->setRowsNeeded(10000000);
                break;
        }
        $this->countTotalRows();
        echo $this->rowsCount . PHP_EOL;
        if ($this->rowsCount < $this->rowsNeeded) {
            $this->insertGenres();
            $this->insertFilms();
            $this->insertHall();
            $this->insertSeats();
            $this->generateSeances();
            $this->generateTickets();
        }
    }

    private function insertGenres()
    {
        if (!$this->countRows('genre')) {
            $this->insertTransaction(
                'genre',
                ['title'],
                [['Боевик'], ['Вестерн'], ['Детектив'], ['Драма'],
                    ['Исторический'], ['Комедия'], ['Мелодрама'],
                    ['Приключения'], ['Триллер'], ['Ужасы'], ['Фантастика']]
            );
        }
    }

    private function insertFilms()
    {
        $rowsMinimum = $this->rowsNeeded / 1000;
        if ($this->countRows('film') < $rowsMinimum) {
            $values = array();
            $genreIds = $this->getIdsFromTable('genre');
            $genreIdsCount = count($genreIds);
            for ($i = 0; $i < $rowsMinimum; $i++) {
                $values[] = [$this->generateFilmName(), $genreIds[rand(0, $genreIdsCount - 1)], rand(3600, 8000), $this->generateFilmAnnotation()];
            }
            $this->insertTransaction('film', ['title', 'genre_id', 'duration', 'annotation'], $values);
        }
    }

    private function generateFilmName()
    {
        $first = ['Момент', 'Небо', 'Океан', 'Страницы', 'Море', 'Боль', 'Обрывки',
            'Раны', 'Мир', 'Слёзы', 'Розы', 'Вены', 'Картины', 'Дождь', 'Километры',
            'Осень', 'Вены', 'Ложь', 'Отражение', 'Рассвет', 'Ладони', 'Солнце', 'Пепел',
            'Ангел', 'Тайна', 'Завет', 'Закат', 'Финал', 'Агония', 'Победа'];//30
        $second = ['твоей', 'вашей', 'вскрытой', 'истлевшей', 'внутри', 'после', 'нашей',
            'потерянной', 'среди', 'в глубине', 'моей', 'догоревшей', 'покинутой',
            'растерзанной', 'убитой', 'зарытой', 'забытой', 'умирающей', 'изнутри',
            'утраченной', 'каждой', 'разбитой', 'догоревшей', 'сгоревшей', 'грязной',
            'печальной', 'раскрытой', 'бесконечной', 'первой', 'последней', 'вчерашней'];//31
        $third = ['вечности', 'жизни', 'смерти', 'любви', 'гордости', 'нежности', 'боли', 'смерти',
            'печали', 'ненависти', 'привязонности', 'надежды', 'зависти', 'скорби', 'эйфории',
            'ярости', 'безмятежности', 'веры', 'мечты', 'тревоги', 'крови', 'могилы', 'игры', 'пустоты',
            'бесконечности', 'легкости', 'бездейственности', 'творчества', 'апатии', 'глупости',
            'жизни', 'реальности', 'страсти', 'фантазии', 'гневности', 'преданности', 'бессмыслицы'];//37
        $odd = rand(1, 2) % 2;
        return $first[rand(0, 29)] . ' ' . ($odd ? $second[rand(0, 30)] . ' ' . $third[rand(0, 36)] : $third[rand(0, 36)] . ' ' . $second[rand(0, 30)]);
    }

    private function generateFilmAnnotation()
    {
        $first = ['обречён', 'ожидает', 'возможно получит', 'вполне способен', 'явно не хочет'];//5
        $second = ['успех', 'провал', 'забвение', 'нейстральную оценку', 'войти в топ 100'];//5
        $third = ['вечности', 'жизни', 'смерти', 'любви', 'гордости', 'нежности', 'боли', 'смерти',
            'печали', 'ненависти', 'привязонности', 'надежды', 'зависти', 'скорби', 'эйфории',
            'ярости', 'безмятежности', 'веры', 'мечты', 'тревоги', 'крови', 'могилы', 'игры', 'пустоты',
            'бесконечности', 'легкости', 'бездейственности', 'творчества', 'апатии', 'глупости',
            'жизни', 'реальности', 'страсти', 'фантазии', 'гневности', 'преданности', 'бессмыслицы'];//37
        $text = 'Данный фильм рассказывает о %s и %s, смысловая подача такая, что фильм %s на %s. В общем %s не избежать.';

        return sprintf($text, $third[rand(0, 36)], $third[rand(0, 36)], $first[rand(0, 4)], $second[rand(0, 4)], $third[rand(0, 36)]);
    }

    private function insertHall()
    {
        if ($this->countRows('hall') < 10) {
            $values = array();
            $names = ['Air Force Blue', 'Alice Blue', 'Alizarin Crimson', 'Almond', 'Amaranth',
                'Amber', 'American Rose', 'Amethyst', 'Anti-flash White', 'Antique White', 'Apple Green',
                'Asparagus', 'Aqua', 'Aquamarine', 'Army Green', 'Arsenic', 'Azure'];
            for ($i = 0; $i < 11; $i++) {
                $currentName = rand(0, 16);
                $values[] = [rand(120, 150), $names[$currentName]];
            }
            $this->insertTransaction('hall', ['seats', 'title'], $values);
        }
    }

    private function insertSeats()
    {
        $data = $this->getDataFromTable('hall', ['id', 'seats'], '(select count(*) from seat where seat.hall_id = hall.id) = 0');
        if (count($data) > 0) {
            $values = array();
            foreach ($data as $hall) {
                $seats = $hall['seats'];
                $rows = ($seats / 10) + 1;
                $id = $hall['id'];
                $number = 1;
                for ($i = 0; $i < $rows; $i++) {
                    for ($j = 0; $j < 10; $j++) {
                        $values[] = [$id, $i + 1, $number];
                        $number++;
                    }
                    if ($number == $seats) {
                        continue;
                    }
                }
            }
            $this->insertTransaction('seat', ['hall_id', 'line', 'number'], $values);
        }

    }

    private function generateSeances()
    {
        $films = $this->getDataFromTable('film', ['id', 'duration'], "(select count(*) from seance where seance.film_id=film.id and date(date_start) between date('" . date('Y-m-1') . "') and date('" . date('Y-m-28') . "'))=0");
        $filmsCount = count($films);
        if ($filmsCount) {
            $halls = $this->getIdsFromTable('hall');
            $values = array();
            foreach ($halls as $hall) {
                for ($i = 1; $i < 3; $i++) {
                    for ($j = 0; $j < 8; $j++) {
                        $film = $films[rand(0, $filmsCount - 1)];
                        $date = date('Y') . '-' . date('m') . '-' . (iconv_strlen($i) == 2 ? $i : '0' . $i) . ' ' . $j * 3 . ':00:00';
                        $date_stop = date('Y-m-d H:i:s', strtotime($date) + $film['duration']);
                        $values[] = [$hall, $date, $date_stop, $film['id']];
                    }
                }
            }
            $this->insertTransaction('seance', ['hall_id', 'date_start', 'date_end', 'film_id'], $values);
        }
    }

    private function generateTickets()
    {
        $seances = $this->getDataFromTable('seance', ['id', 'hall_id'], '(select count(*) from ticket where ticket.seance_id = seance.id) = 0');
        $values = array();
        $seanceCount = count($seances);
        $seanceNum = 0;
        $totalTickets = 0;
        foreach ($seances as $seance) {
            $seanceNum++;
            $seatIds = $this->getIdsFromTable('seat', 'hall_id = ' . $seance['hall_id']);
            $seatsCount = count($seatIds);
            $seatsForTickets = array();
            for ($i = 0; $i < $seatsCount; $i++) {
                if (rand(1, 10) % 2) {
                    $seatsForTickets[] = $seatIds[rand(0, $seatsCount - 1)];
                }
            }
            $seatsForTickets = array_values(array_unique($seatsForTickets));
            foreach ($seatsForTickets as $seat) {
                $values[] = [$seance['id'], $seat, rand(20000, 100000)];
            }
            //too many tickets6 let's insert it by parts
            $this->insertTransaction('ticket', ['seance_id', 'seat_id', 'price'], $values);
            $totalTickets += count($values);
            echo "\rGenerate " . $totalTickets . ' tickets ' . $seanceNum . '/' . $seanceCount;
            $values = array();
        }
        echo PHP_EOL;
    }

    private function generateAttributes()
    {
        if (!$this->countRows('attribute_name') && !$this->countRows('attribute_type')) {
            $this->insertTransaction(
                'attribute_type',
                ['title', 'code', 'type'],
                [['Рецензия', 'review', 'text'],
                    ['Приз', 'prize', 'boolean'],
                    ['Дата', 'date', 'timestamp'],
                    ['Работа', 'work', 'timestamp']]);
            $this->insertTransaction(
                'attribute_name',
                ['title'],
                [['Бабе Вале понравилось'], ['Премия Оскар за роль 3го плана в массовке вдали'], ['Премия Тэфи'],
                    ['Мировая премьера'], ['Премьера РФ'],
                    ['Исправить опечатки в макете'], ['Печать макета рекламного постера'], ['Пнуть дизайнера по срокам'],
                    ['Рецензия Васи Пупкина'], ['Рецензия киноакадемии']]);
        }
        $types = $this->getDataFromTable('attribute_type', ['id', 'code']);
        $attributes = array();
        foreach ($types as $type) {
            $attributes[$type['code']]['type'] = $type['id'];
        }
        $data = $this->getDataFromTable('attribute_name', ['id'], "title in ('Бабе Вале понравилось', 'Премия Оскар за роль 3го плана в массовке вдали', 'Премия Тэфи')");
        foreach ($data as $name) {
            $attributes['prize']['name'][] = $name['id'];
        }
        $data = $this->getDataFromTable('attribute_name', ['id'], "title in ('Мировая премьера', 'Премьера РФ')");
        foreach ($data as $name) {
            $attributes['date']['name'][] = $name['id'];
        }
        $data = $this->getDataFromTable('attribute_name', ['id'], "title in ('Исправить опечатки в макете', 'Печать макета рекламного постера', 'Пнуть дизайнера по срокам')");
        foreach ($data as $name) {
            $attributes['work']['name'][] = $name['id'];
        }
        $data = $this->getDataFromTable('attribute_name', ['id'], "title in ('Рецензия Васи Пупкина', 'Рецензия киноакадемии')");
        foreach ($data as $name) {
            $attributes['work']['name'][] = $name['id'];
        }
        die(var_dump($attributes));
    }
}