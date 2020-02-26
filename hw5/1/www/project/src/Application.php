<?php

namespace App;

class Application {

    public function start()
    {
        if(!$_SERVER["CONTENT_LENGTH"] || !$_POST || !$_POST['string']) {
            $this->sendMessage(400, 'Bad request');
        }

        if(!$this->checkBracket($_POST['string'])) {
            $this->sendMessage(400, 'Bad request');
        }

        $this->sendMessage(200, 'OK');
    }

    /**
     * @param $status
     * @param $message
     * @throws \Exception
     */
    private function sendMessage($status, $message)
    {
        http_response_code($status);
        $error = [];
        $error['status'] = $status;
        $error['message'] = $message;
        header('Content-type: application/json');
        echo json_encode($error);
        die();
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
