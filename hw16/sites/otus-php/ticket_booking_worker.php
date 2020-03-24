<?php

declare(strict_types=1);

use App\Kernel\QueueWorkerApp;
use App\Service\TicketBookingWorkerService;

require 'vendor/autoload.php';

QueueWorkerApp::run(TicketBookingWorkerService::class);
