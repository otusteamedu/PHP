<?php

require_once('./config/bootstrap.php');

try {
    runApplication();
} catch (\Exception $e) {
    var_dump('Exception caught at index.php:' . $e->getMessage());
}
