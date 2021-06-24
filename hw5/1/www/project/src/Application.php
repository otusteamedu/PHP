<?php

namespace App;

class Application {

    public function start()
    {
        if(!$_SERVER["CONTENT_LENGTH"] ||
            !$_POST ||
            !$_POST['string'] ||
            !is_string($_POST['string'])) {
            return Message::sendError();
        }

        $string = preg_replace("/[^()]+/", "", $_POST['string']);

        if(!$this->checkBracket($string)) {
            return Message::sendError();
        }
        return Message::sendOk();
    }

    private function checkBracket($string)
    {
        $countLeftBracket = 0;
        $countRightBracket = 0;
        $arraySymbols = str_split($string);
        foreach($arraySymbols as $symbol) {
            if($countLeftBracket < $countRightBracket) return false;
            if($symbol == '(') $countLeftBracket++;
            if($symbol == ')') $countRightBracket++;
        }
        if($countLeftBracket != $countRightBracket) return false;
        return true;
    }
}
