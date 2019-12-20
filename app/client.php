<?php
while (true) {
    $line = fgets(STDIN);
    if ( strpos($line, 'stop') !== false ) {
        break;
    }
    echo 'responce: ' . $line;
}
