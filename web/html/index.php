<?php
require_once "./vendor/autoload.php";

class CalculateData {
    private static $params = 'params.json';

    public static function getParam() {
        return json_decode(file_get_contents(self::$params), true);
    }

    public static function getAction($actions) {
        $event = "";
        $priority = 0;
        foreach (self::getParam() as $select) {            
            $flag = 0;
            foreach ($select['conditions'][0] as $c_key => $c_value) {                
                foreach ($actions as $a_key => $a_value) {
                    if ($a_key == $c_key and $a_value == $c_value) {
                        $flag++;
                    }
                }
            }
            if (count($select['conditions'][0]) <=  $flag++) {
                if ($select['priority'] > $priority) {
                    $priority = $select['priority'];
                    $event = $select['event'];
                }
            }
        }
        if ($priority > 0) {
            return $event; 
        }
        return false;
    }
}

class RedisDB {
    private static $single_server  = array(
        'host'     => 'redis',
        'port'     => 6379,
        'database' => 15
    );

    public static function setEvent($data) {
        $redis = new Predis\Client(self::$single_server);   
        $key = 'event_' . microtime();
        $redis->set($key, $data);        
    }

    public static function getAllEvents() {
        $events =array();
        $redis = new Predis\Client(self::$single_server);   
        foreach ($redis->keys("event_*") as $key ) {
            $events[] = $redis->get($key);
        }
        return $events;
    }

    public static function dellAllEvents() {
        $redis = new Predis\Client(self::$single_server);   
        foreach ($redis->keys("event_*") as $key ) {            
            $redis->del($key);            
        }        
    }
}

$param1 = $_POST['param1'];
$param2 = $_POST['param2'];
$action = $_POST['action'];

if ($action  == "dell_all") {
    RedisDB::dellAllEvents();
}

if ($action  == "add") {
    if (isset($param1)) {
        $get['param1'] = $param1;
    }
    if (isset($param2)) {
        $get['param2'] = $param2;
    }
    $event = CalculateData::getAction($get);
    RedisDB::setEvent($event);
}

?>

<!DOCTYPE html>
<html>
	<head>
		<title>Управление событиями</title>
	</head>
	<body>
		<form method = "POST">
			param1: <input type = "text"  name = "param1" value =  "1"> <br> <br>
			param2: <input type = "text"  name = "param2" value =  "1"> <br> <br>
			<input type = "submit" name = "action" value = "add">
            <input type = "submit" name = "action" value = "dell_all">
		</form>
        <table border="1">
            <caption>Таблица событий</caption>
            <tr>
                <th>События из базы</th>                
            </tr>
            <?
                foreach (RedisDB::getAllEvents() as $event ) {
                    echo '<tr><td>' . $event . '</td></tr>';               
                }                
            ?>
        </table>
	</body>
</html>