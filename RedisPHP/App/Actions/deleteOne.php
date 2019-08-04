<?php

require_once __DIR__ . '/../../autoload.php';

use App\Models\DBRedis;

if (isset($_POST['number'])) {
    DBRedis::deleteOne($_POST['number']);
}

header('Location: /index.php');
