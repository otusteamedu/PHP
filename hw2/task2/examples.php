<?php
require_once 'vendor/autoload.php';

use Jekys\Console;

Console::text('This is a simple text');
Console::notify('This is a notify text');
Console::error('This is an error text');
Console::success('This is a success text');
