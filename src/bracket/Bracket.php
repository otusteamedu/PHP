<?php

namespace Ozycast\Bracket;

class Bracket {
    public function run()
    {
        if (!isset($_POST["string"]) || !strlen(trim($_POST["string"]))) {
            header("HTTP/1.0 400 'string' empty");
            return;
        }

        $bracket = str_split($_POST["string"], 1);
        $bracket_diff = 0;

        foreach($bracket as $bkt) {
            if ($bkt == "(")
                $bracket_diff++;
            if ($bkt == ")")
                $bracket_diff--;

            if ($bracket_diff < 0) {
                header("HTTP/1.0 400 'string' is bad");
                return;
            }
        }

        if ($bracket_diff)
            header("HTTP/1.0 400 'string' is bad");
        else
            header("HTTP/1.0 200 'string' is good");

        return;
    }
}
