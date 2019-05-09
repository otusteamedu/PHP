<?php

namespace Otus;

use PDO;

/**
 * Class Inserter
 * @package Otus
 */
class Inserter
{
    /**
     * PDO object
     * @var PDO
     */
    private $pdo;

    /**
     * Rows count
     * @var int
     */
    private $rowsCount = 0;

    /**
     * Rows needed
     * @var int
     */
    private $rowsNeeded = 0;

    /**
     * Base tables
     * @var array
     */
    private $baseTables = ['genre', 'film', 'hall', 'seance', 'seat', 'ticket', 'attribute_name', 'attribute_type', 'attribute_value', 'film_attribute'];

    /**
     * init the object with a \PDO object
     * @param type $pdo
     */
    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * insert test data
     * @param string $rowsNeed
     */
    public function insertData(string $rowsNeed)
    {
        $this->setRowsNeeded($rowsNeed);
        $this->countTotalRows();
        if ($this->rowsCount > $this->rowsNeeded) {
            echo 'Total rows in db:' . $this->rowsCount . PHP_EOL;
            echo 'Nothing to do. Exit!' . PHP_EOL;
        }
        while ($this->rowsCount < $this->rowsNeeded) {
            $this->insertGenres();
            echo 'Generating films ' . PHP_EOL;
            $this->generateFilms();
            $this->insertHall();
            $this->insertSeats();
            echo 'Generating seances ' . PHP_EOL;
            $this->generateSeances();
            echo 'Generating tickets ' . PHP_EOL;
            $this->generateTickets();
            echo 'Generating attributes' . PHP_EOL;
            $this->generateAttributes();
            $this->countTotalRows();
            echo 'Total rows in db:' . $this->rowsCount . PHP_EOL;
        }
    }

    /**
     * Set rows needed
     * @param int $count
     */
    private function setRowsNeeded(int $count)
    {
        $this->rowsNeeded = $count;
    }

    /**
     *  Count total rows and set in rowsCount
     */
    private function countTotalRows()
    {
        foreach ($this->baseTables as $table) {
            $this->incrementRowsCount($this->countRows($table));
        }
    }

    /**
     * Increment rows count
     * @param int $count
     */
    private function incrementRowsCount(int $count)
    {
        $this->rowsCount += $count;
    }

    /**
     * Counting rows from chosen table
     * @param string $tableName
     * @return int
     */
    private function countRows(string $tableName): int
    {
        return (int)$this->pdo->query('SELECT * FROM ' . $tableName)->rowCount();
    }

    /**
     * Insert default genres if table 'genre' is empty
     */
    private function insertGenres()
    {
        if (!$this->countRows('genre')) {
            echo 'Inserting genres ' . PHP_EOL;
            $this->insertTransaction(
                'genre',
                ['title'],
                [['Боевик'], ['Вестерн'], ['Детектив'], ['Драма'],
                    ['Исторический'], ['Комедия'], ['Мелодрама'],
                    ['Приключения'], ['Триллер'], ['Ужасы'], ['Фантастика']]
            );
        }
    }

    /**
     * Make insert transaction
     * @param string $tableName
     * @param array $columns
     * @param array $values
     */
    private function insertTransaction(string $tableName, array $columns, array $values)
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

    /**
     * Make insert transaction for 2 tables with relation
     * @param string $parentTable
     * @param array $parentColumns
     * @param array $parentValues
     * @param string $childTable
     * @param array $childColumns
     * @param array $childValues
     * @param string $childFiled
     */
    private function multipleTableInsert(string $parentTable, array $parentColumns, array $parentValues, string $childTable, array $childColumns, array $childValues, string $childFiled)
    {
        $question_marks = array();
        $question_marks['parent'] = '(' . $this->getPlaceholders('?', sizeof($parentColumns)) . ')';
        $childWithTypes = array();
        $childColumnsNames = array();
        foreach ($childColumns as $column) {
            if (array_key_exists('type', $column)) {
                $childWithTypes[] = 'CAST (' . $column['name'] . ' as ' . $column['type'] . ')';
                $childColumnsNames[] = $column['name'];
            }
        }
        if (!$childColumnsNames) {
            $childColumnsNames = $childColumns;
        }
        $question_marks['child'] = '(' . $this->getPlaceholders('?', sizeof($childColumnsNames)) . ')';

        $sql = "WITH new_parent AS (
            INSERT INTO $parentTable (" . implode(",", $parentColumns) . ") VALUES " . $question_marks['parent'] . "
            RETURNING id
            ),
            v(" . implode(",", $childColumnsNames) . ") AS (values
              " . $question_marks['child'] . "
            )
            INSERT INTO $childTable (" . implode(",", array_merge([$childFiled], $childColumnsNames)) . ")
             SELECT new_parent.id, " . implode(",", $childWithTypes ? $childWithTypes : $childColumnsNames) . " FROM v, new_parent";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(array_merge($parentValues, $childValues));
    }

    /**
     * Generate placeholder
     * @param $text
     * @param int $count
     * @param string $separator
     * @return string
     */
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

    /**
     * Get array of existing ids from table
     * @param string $tableName
     * @param string|null $where
     * @return array
     */
    private function getIdsFromTable(string $tableName, string $where = null): array
    {
        return $this->pdo->query('SELECT id FROM ' . $tableName . ($where ? ' WHERE ' . $where : ''))->fetchAll(PDO::FETCH_COLUMN, 0);
    }

    /**
     * Gettin array of chosen columns from chosen table
     * @param string $tableName
     * @param array $columns
     * @param string|null $where
     * @return array
     */
    private function getDataFromTable(string $tableName, array $columns, string $where = null): array
    {
        return $this->pdo->query('SELECT ' . implode(', ', $columns) . ' FROM ' . $tableName . ($where ? ' WHERE ' . $where : ''))->fetchAll();
    }

    /**
     * Films generator
     */
    private function generateFilms()
    {
        $rowsMinimum = $this->rowsNeeded > 50000 ? 100 : 10;
        $values = array();
        $genreIds = $this->getIdsFromTable('genre');
        $genreIdsCount = count($genreIds);
        for ($i = 0; $i < $rowsMinimum; $i++) {
            $values[] = [$this->generateFilmName(), $genreIds[mt_rand(0, $genreIdsCount - 1)], mt_rand(3600, 8000), $this->generateFilmAnnotation()];
        }
        $this->insertTransaction('film', ['title', 'genre_id', 'duration', 'annotation'], $values);
    }

    /**
     * Generating random film name
     * @return string
     */
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
        $odd = mt_rand(1, 2) % 2;
        return $first[mt_rand(0, 29)] . ' ' . ($odd ? $second[mt_rand(0, 30)] . ' ' . $third[mt_rand(0, 36)] : $third[mt_rand(0, 36)] . ' ' . $second[mt_rand(0, 30)]);
    }

    /**
     * Film annotation generator
     * @return string
     */
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

        return sprintf($text, $third[mt_rand(0, 36)], $third[mt_rand(0, 36)], $first[mt_rand(0, 4)], $second[mt_rand(0, 4)], $third[mt_rand(0, 36)]);
    }

    /**
     * Generate 10 halls if table 'hall' is empty
     */
    private function insertHall()
    {
        if ($this->countRows('hall') < 10) {
            echo 'Inserting halls ' . PHP_EOL;
            $values = array();
            $names = ['Air Force Blue', 'Alice Blue', 'Alizarin Crimson', 'Almond', 'Amaranth',
                'Amber', 'American Rose', 'Amethyst', 'Anti-flash White', 'Antique White', 'Apple Green',
                'Asparagus', 'Aqua', 'Aquamarine', 'Army Green', 'Arsenic', 'Azure'];
            for ($i = 0; $i < 11; $i++) {
                $currentName = mt_rand(0, 16);
                $values[] = [mt_rand(120, 150), $names[$currentName]];
            }
            $this->insertTransaction('hall', ['seats', 'title'], $values);
        }
    }

    /**
     * Generating seats in hall if hall haven't it
     */
    private function insertSeats()
    {
        $data = $this->getDataFromTable('hall', ['id', 'seats'], '(select count(*) from seat where seat.hall_id = hall.id) = 0');
        if (count($data) > 0) {
            echo 'Inserting seats ' . PHP_EOL;
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

    /**
     * Generate seances for every film that haven't seances.
     * Maybe it need take last 20 films...
     */
    private function generateSeances()
    {
        $days = $this->rowsNeeded < 15000 ? 2 : 6;
        $films = $this->getDataFromTable('film', ['id', 'duration'], "(select count(*) from seance where seance.film_id=film.id and date(date_start) between date('" . date('Y-m-d') . "') and date('" . date('Y-m-d', strtotime("+$days day")) . "'))=0");
        $filmsCount = count($films);
        if (!$filmsCount) {
            $lastDateSeance = $this->getDataFromTable('seance', ['max(date_start)']);
            $dateStart = date('Y-m-d', $lastDateSeance[0]['max']);
            $films = $this->getDataFromTable('film', ['id', 'duration'], "(select count(*) from seance where seance.film_id=film.id and date(date_start) between date('" . $dateStart . "') and date('" . date('Y-m-d', strtotime($dateStart . " +$days day")) . "'))=0");
        } else {
            $dateStart = date('Y-m-d');
        }
        $halls = $this->getIdsFromTable('hall');
        $values = array();
        foreach ($halls as $hall) {
            for ($i = 0; $i < $days; $i++) {
                // 8 - count of max seances in 1 hall in 24 hours (3 hours for 1 seance)
                for ($j = 0; $j < 8; $j++) {
                    $film = $films[rand(0, $filmsCount - 1)];
                    $date = date('Y-m-d ' . $j * 3 . ':00:00', strtotime("$dateStart +$i day"));
                    $date_stop = date('Y-m-d H:i:s', strtotime($date) + $film['duration']);
                    $values[] = [$hall, $date, $date_stop, $film['id']];
                }
            }
        }
        $this->insertTransaction('seance', ['hall_id', 'date_start', 'date_end', 'film_id'], $values);
    }

    /**
     * Generate random tickets for seances without tickets
     */
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
            //too many tickets, let's insert it by parts
            $this->insertTransaction('ticket', ['seance_id', 'seat_id', 'price'], $values);
            $totalTickets += count($values);
            echo "\rGenerate " . $totalTickets . ' tickets ' . $seanceNum . '/' . $seanceCount;
            $values = array();
        }
        echo PHP_EOL;
    }

    /**
     * Generator for attributes
     */
    private function generateAttributes()
    {
        if (!$this->countRows('attribute_type')) {
            $this->insertTransaction(
                'attribute_type',
                ['title', 'code', 'type'],
                [['Рецензия', 'review', 'text'],
                    ['Приз', 'prize', 'boolean'],
                    ['Дата', 'date', 'timestamp'],
                    ['Работа', 'work', 'timestamp']]);
        }
        if (!$this->countRows('attribute_name')) {
            $this->insertTransaction(
                'attribute_name',
                ['title'],
                [['Бабе Вале понравилось'], ['Премия Оскар за роль 3го плана в массовке вдали'], ['Премия Тэфи'],
                    ['Мировая премьера'], ['Премьера РФ'],
                    ['Исправить опечатки в макете'], ['Печать макета рекламного постера'], ['Пнуть дизайнера по срокам'],
                    ['Рецензия Васи Пупкина'], ['Рецензия киноакадемии']]);
        }
        $films = $this->getDataFromTable('film', ['id'], '(select count(*) from film_attribute where film_attribute.film_id = film.id) = 0');
        if ($films) {
            $this->pdo->beginTransaction();
            foreach ($films as $film) {
                $attributes = $this->getRandomAttributes();
                foreach ($attributes as $attribute) {
                    $this->multipleTableInsert(
                        'attribute_value',
                        [$attribute['value']['column']], [$attribute['value']['value']],
                        'film_attribute',
                        [['name' => 'attribute_name_id', 'type' => 'integer'], ['name' => 'film_id', 'type' => 'integer'], ['name' => 'attribute_type_id', 'type' => 'integer']],
                        [$attribute['name'], $film['id'], $attribute['type']], 'attribute_value_id');
                }
            }
            $this->pdo->commit();
        }
    }

    /**
     * Randomize attribute
     * @return array
     */
    private function getRandomAttributes()
    {
        $types = $this->getDataFromTable('attribute_type', ['id', 'code', 'type']);
        $attributes = array();
        foreach ($types as $type) {
            $attributes[$type['code']]['type'] = $type['id'];
            $attributes[$type['code']]['varType'] = $type['type'];
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
            $attributes['review']['name'][] = $name['id'];
        }
        $response = array();
        $fieldsNames = ['text' => 'text_val', 'boolean' => 'bool_val', 'integer' => 'int_val', 'timestamp' => 'date_val'];
        foreach ($attributes as $type => $attribute) {
            if (mt_rand(1, 10) % 2 == 1) {
                $value = $this->getRandomValueByType($attribute['varType']);
                if ($value) {
                    $response[] = ['value' => ['column' => $fieldsNames[$attribute['varType']], 'value' => $value], 'type' => $attribute['type'], 'name' => $attribute['name'][mt_rand(0, (count($attribute['name']) - 1))]];
                }
            }
        }
        return $response;
    }

    /**
     * Random value generator for chosen types
     * @param $type
     * @return bool|false|string
     */
    private function getRandomValueByType($type)
    {
        switch ($type) {
            case 'boolean':
                return (mt_rand(1, 10) % 2 == 1 ? true : false);
                break;
            case 'timestamp':
                $dateStart = strtotime("now");
                $dateEnd = strtotime('+1 month');
                return date('Y-m-d H:i:s', mt_rand($dateStart, $dateEnd));
                break;
            case 'text':
                return $this->generateFilmAnnotation();
                break;
        }
    }
}