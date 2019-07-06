<?php
$handle = fopen('php://stdin', 'r');

$commands = array('git commit', 'ps aux', 'nano');

while (true) {
    $buffer = fgets($handle);
    $sim = similar_text('git commit', $buffer, $perc);

    foreach ($commands as $value) {
        $originalWords = substr_count($value, ' ');
        $commandParts = explode(' ', $buffer);
        $output = array_slice($commandParts, 0, $originalWords + 1);
        $sim = similar_text($value, implode(" ", $output), $perc);

        if ($perc >= 70) {
            echo "F#cking mismatch. You mean : " . $value . " " . implode(" ", array_slice($commandParts, $originalWords + 1)) . PHP_EOL;
            exit;
        }
    }
}

fclose($handle);
