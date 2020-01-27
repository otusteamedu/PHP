<?php
declare(strict_types=1);

require_once 'vendor/autoload.php';
error_reporting(E_ALL);
set_time_limit(0);
ob_implicit_flush();
declare(ticks = 1);

define('__ROOT_DIR__', __DIR__);
define('__CONFIG_DIR__', __ROOT_DIR__. '/config');

function dump($data)
{
    if (is_array($data)) { //If the given variable is an array, print using the print_r function.
        print "<pre>-----------------------\n";
        print_r($data);
        print "-----------------------</pre>";
    } elseif (is_object($data)) {
        print "<pre>==========================\n";
        var_dump($data);
        print "===========================</pre>";
    } else {
        print "=========&gt; ";
        var_dump($data);
        print " &lt;=========";
    }
}
