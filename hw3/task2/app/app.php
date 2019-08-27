<?php
/**
* Main script for php-fuck
* Defines how to deal with sended key
*
* @author Evgeny Prokhorov <contact@jekys.ru>
* @package php-fuck
*/

require_once 'vendor/autoload.php';

use Jekys\Fixer;
use Jekys\Text as Txt;

$keys = [
    'install',
    'fix:',
    'help'
];

$params = getopt('', $keys);
$mode = null;
$modeValue = null;

foreach ($keys as $key) {
    $modeName = str_replace(':', '', $key);

    if (array_key_exists($modeName, $params)) {
        $mode = $modeName;
        $modeValue = $params[$modeName];
    }
}

switch ($mode) {
    case 'install':
        Fixer::addAlias();
        print Txt::green('Installed, run "source ~/.bashrc" to apply changes'.PHP_EOL);

        break;

    case 'fix':
        $fuck = new Fixer(trim($modeValue));
        $fuck->run();

        break;

    case 'help':
        print file_get_contents('help.txt').PHP_EOL;

        break;

    default:
        print Txt::red('Unknown mode, run "php-fuck --help" to see more information'.PHP_EOL);

        break;
}
