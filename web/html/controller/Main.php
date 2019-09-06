<?php

namespace controller;

class MainController {
    public static function runApp() {
        $param1 = $_POST['param1'];
        $param2 = $_POST['param2'];
        $action = $_POST['action'];

        if ($action  == "dell_all") {
            \model\RedisDB::dellAllEvents();
        }

        if ($action  == "add") {
            if (isset($param1)) {
                $get['param1'] = $param1;
            }
            if (isset($param2)) {
                $get['param2'] = $param2;
            }
            $event = \model\CalculateData::getAction($get);
            \model\RedisDB::setEvent($event);
        }        
        require __DIR__ . '/../view/Run.php';
    }
}
?>