<?php

$string = $_POST['string'];
try {
    if (empty($string)) {
        throw new \Exception('Param is blank');
    }
    $open = 0;
    $closed = 0;
    for ($i = 0; $i < strlen($string); $i++) {
        $c = $string[$i];
        if (!in_array($c, ['(', ')'])) {
            throw new \Exception('Wrong symbol in param');
        }
        if ($c == '(') {
            $open++;
        } else {
            $closed++;
        }
        if ($closed > $open) {
            throw new \Exception('Wrong param string');
        }
    }
    if ($closed !== $open) {
        throw new \Exception('Not enough parentheses');
    }
} catch (\Exception $exception) {
    http_response_code(400);
    echo $exception->getMessage() . PHP_EOL;
    exit(0);
}

echo 'Param is ok' . PHP_EOL;
