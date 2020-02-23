<?
require '../vendor/autoload.php';

use App\Entities\Hall;
use App\Config;

try {

    $config = new Config();

    $host = $config->db_host_name;
    $port = $config->db_port;
    $dbname = $config->db_name;
    $dsn = "pgsql:host={$host};port={$port};dbname={$dbname}";
    $username = $config->db_username;
    $passwd = $config->db_password;
    $dbconn = new PDO($dsn, $username, $passwd);

    $hall = new Hall($dbconn);

    $res = $hall->getById($dbconn, 3);

    var_dump($res);

    // lazyload
    $places = $res->getPlaces();
    var_dump($places);




}catch (PDOException $e){
    print "Error!: " . $e->getMessage() . "<br />";
    die;
}
// using
