<?
require 'autoload.php';

use App\Entities\Hall;

try {
    $host = 'app.local';
    $port = 5432;
    $dbname = 'postgres';
    $dsn = "pgsql:host={$host};port={$port};dbname={$dbname}";
    $username = 'postgres';
    $passwd = 'postgres';
    $dbconn = new PDO($dsn, $username, $passwd);

    $hall = new Hall($dbconn);

    $res = $hall->getById($dbconn, 2);

    echo '<pre>';
    print_r($res);
    echo '</pre>';

    $result  =$res->delete();

    echo '<pre>';
    var_dump($result);
    echo '</pre>';

    die();
    $places = $res->getPlaces();

    $res->getPlaces();
    $res->getPlaces(true);

    foreach($places as $place){

        $place->setHallPlaceNum($place->getHallPlaceNum()+1)->update();

    }

    $res->setName('name for two')->update();


}catch (PDOException $e){
    print "Error!: " . $e->getMessage() . "<br />";
    die;
}
// using
