<?php
require_once __DIR__ . '/../../autoload.php';

use App\Models\DBRedis;


DBRedis::deleteAll();


header('Location: /App/Admin/analitic.php');