<?php
declare(strict_types=1);
/**
 * @author Bazarov Aleksandr <bazarov@tutu.ru>
 *
 */

require_once __DIR__ . '/vendor/autoload.php';

use APP\EmailCheckHandler;

$handler = new EmailCheckHandler(new \APP\HTTP\Request());
$handler->run();