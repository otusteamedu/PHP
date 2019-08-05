<?php

require_once __DIR__ . '/../../autoload.php';

use App\Models\DBRedis;


$data = DBRedis::getAll();
/*usort($data, function ($a, $b) {
    return $a->getPriority() > $b->getPriority();
});
*/
include __DIR__ . '/show_all.php';