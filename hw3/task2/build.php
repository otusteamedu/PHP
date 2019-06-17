<?php
/**
* Script packs the app to the PHAR archive
*
* @author Evgeny Prokhorov <contact@jekys.ru>
* @package php-fuck
*/

$file = 'php-fuck.phar';

if (file_exists($file)) {
    unlink($file);
}

$phar = new Phar($file);

$phar->startBuffering();

$phar->buildFromDirectory('app/');

$defaultStub = $phar->createDefaultStub('app.php');

$stub = "#!/usr/bin/env php \n".$defaultStub;

$phar->setStub($stub);

$phar->stopBuffering();

echo 'php-fuck.phar has been created'.PHP_EOL;
