<?php

require_once __DIR__.'/../vendor/autoload.php';

use WebRush\Status;

echo Status::getStatusCode().': '.Status::getStatus();