<?php

include_once __DIR__ . '/../vendor/autoload.php';

use App\Db\Connect;
use App\Db\ActiveRecord\ActiveRecord;
use App\Db\DataMapper\FilmMapper;
use App\Db\DataMapper\SeanceMapper;
use App\Db\RowGateway\SeanceFinder;
use App\Db\RowGateway\Seance;
use App\Db\TableGateway\TableGateway;

$connect = new Connect('pgsql', 'otus-postgres', 'cinema', 'cinema', '1231');

/// TableGateway //////////////////////////////////

$tableGateway = new TableGateway($connect);
echo 'TableGateway' . PHP_EOL . '============' . PHP_EOL;
$id = $tableGateway->insert(1, 1, new DateTime('2019-01-01 15:30:00'), 300);
echo "Insert new record (1, 1, 2019-01-01 15:30:00, 300) with id #{$id}" . PHP_EOL;
echo "Find by #{$id}, result: ";
echo implode(', ', $tableGateway->getById($id)) . PHP_EOL;
if ($tableGateway->update($id, 1, 1, new DateTime('2019-01-01 15:30:00'), 400)) {
    echo "Update by #{$id}, result: " . implode(', ', $tableGateway->getById($id)) . PHP_EOL;
}
$tableGateway->delete($id);
echo "Delete by #{$id}, result: ";
try {
    echo implode(', ', $tableGateway->getById($id)) . PHP_EOL;
} catch (\Throwable $exception) {
    echo "no record" . PHP_EOL;
}
echo PHP_EOL;

/// RowGateway ////////////////////////////////////

$seance = new Seance($connect);
$seanceFinder = new SeanceFinder($connect);
echo 'RowGateway' . PHP_EOL . '============' . PHP_EOL;
$seance->setFilmId(3);
$seance->setHallId(3);
$seance->setSeanceTime(new DateTime('2019-01-01 17:30:00'));
$seance->setPrice(500);
$id = $seance->insert();
echo "Insert new record (3, 3, 2019-01-01 17:30:00, 500) with id #{$id}" . PHP_EOL;
echo "Find by #{$id}, result: ";
$seance = $seanceFinder->findById($id);
echo $seance . PHP_EOL;
$seance->setPrice(600);
if ($seance->update()) {
    echo "Update by #{$id}, result: " . $seance . PHP_EOL;
}
$seance->delete();
echo "Delete by #{$id}, result: ";
try {
    $seance = $seanceFinder->findById($id);
    echo $seance . PHP_EOL;
} catch (\Throwable $exception) {
    echo "no record" . PHP_EOL;
}
echo PHP_EOL;

/// ActiveRecord //////////////////////////////////

$activeRecord = new ActiveRecord($connect);
echo 'ActiveRecord' . PHP_EOL . '============' . PHP_EOL;
$activeRecord->setFilmId(4);
$activeRecord->setHallId(4);
$activeRecord->setSeanceTime(new DateTime('2019-01-01 18:30:00'));
$activeRecord->setPrice(700);
$activeRecord->insert();
echo "Insert new record (4, 4, 2019-01-01 18:30:00, 700) with id #{$activeRecord->getId()}" . PHP_EOL;
echo "Find by #{$activeRecord->getId()}, result: ";
$activeRecord = $activeRecord->findById($activeRecord->getId());
echo $activeRecord . PHP_EOL;
$activeRecord->setPrice(800);
if ($activeRecord->update()) {
    echo "Update by #{$activeRecord->getId()}, result: " . $activeRecord . PHP_EOL;
}
$id = $activeRecord->getId();
$activeRecord->delete();
echo "Delete by #{$id}, result: ";
try {
    $activeRecord = $activeRecord->findById($id);
    echo $activeRecord . PHP_EOL;
} catch (\Throwable $exception) {
    echo "no record" . PHP_EOL;
}
echo PHP_EOL;

/// DataMapper ////////////////////////////////////

$seance = new Seance($connect);
$seanceMapper = new SeanceMapper($connect);
echo 'DataMapper' . PHP_EOL . '============' . PHP_EOL;
$seance = $seanceMapper->insert([
    'film_id' => 5,
    'hall_id' => 5,
    'seance_time' => '2019-01-01 17:30:00',
    'price' => 900
]);
echo "Insert new record (5, 5, 2019-01-01 18:30:00, 900) with id #{$seance->getId()}" . PHP_EOL;
echo "Find by #{$seance->getId()}, result: ";
$seance = $seanceMapper->findById($seance->getId());
echo $seance . PHP_EOL;
$seance->setPrice(1000);
if ($seanceMapper->update($seance)) {
    echo "Update by #{$seance->getId()}, result: " . $seance . PHP_EOL;
}
$seanceMapper->delete($seance);
echo "Delete by #{$seance->getId()}, result: ";
try {
    $seance = $seanceMapper->findById($seance->getId());
    echo $seance . PHP_EOL;
} catch (\Throwable $exception) {
    echo "no record" . PHP_EOL;
}
echo PHP_EOL;

$halls = $seanceMapper->findBy(['hall_id' => 1]);
echo "Сеансов в 1 зале: " . count($halls) . PHP_EOL;

$filmMapper = new FilmMapper($connect);
$film = $filmMapper->findById(2);
/*$film->setName('Фильм');
$filmMapper->update($film);
$film = $filmMapper->findById(2);*/
var_dump($filmMapper->delete($film));
/*try {
    $film = $filmMapper->findById(2);
    echo $film . PHP_EOL;
} catch (\Throwable $exception) {
    echo "no record" . PHP_EOL;
}*/

/*$seance = $seanceMapper->findByIdLazy(1);
$seance->getHall();
echo "1 санс в зале " . $seance->getId() . PHP_EOL;

$seance = $seanceMapper->findByIdNotLazy(1);
$seance->getHall();
echo "1 санс в зале " . $seance->getId() . PHP_EOL;*/

