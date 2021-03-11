<?php
if (php_sapi_name() === 'cli') {
    require_once __DIR__ . '/app/app.php';
} else {
    require_once __DIR__ . '/app/start.php';
}
