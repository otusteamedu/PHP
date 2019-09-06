<?php

namespace model;

class CalculateData {    
    private static $params = __DIR__ . '/../params.json';

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