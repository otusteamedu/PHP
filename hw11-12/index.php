<?php

require_once('./config/bootstrap.php');

try {
    runApplication();
} catch (\Exception $e) {
    echo ('Exception caught at index.php:' . $e->getMessage() . PHP_EOL);
}
