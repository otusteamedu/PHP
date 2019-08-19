<?php
class Checker
{
    static public $settings = "setting.json";

    static function execute()
    {
        $handle = fopen('php://stdin', 'r');
        while (true) {
            $buffer = fgets($handle);
            foreach (self::getCommands() as $value) {
                $originalWords = substr_count($value, ' ');
                $commandParts = explode(' ', $buffer);
                $output = array_slice($commandParts, 0, $originalWords + 1);
                $sim = similar_text($value, implode(" ", $output), $perc);

                if ($perc >= self::getPercent() and $perc < 95) {
                    echo "F#cking mismatch. You mean : " . $value . " " . implode(" ", array_slice($commandParts, $originalWords + 1)) . PHP_EOL;
                    exit;
                }

                if ($value == trim(implode(" ", $output))) {
                    echo "All good: " . $value . " " . implode(" ", array_slice($commandParts, $originalWords + 1)) . PHP_EOL;
                    exit;
                }
            }
        }
        fclose($handle);
    }

    private static function getPercent(){
        $settings = json_decode(file_get_contents(self::$settings), true);
        return $settings["perc"];
    }

    private static function getCommands(){
        $settings = json_decode(file_get_contents(self::$settings), true);
        return $settings["commands"];
    }
}

Checker::execute();
