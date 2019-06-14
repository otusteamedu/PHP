<?php
namespace Jekys;

/**
* @author E.Prokhrorv <contact@jekys.ru>
* @version 1.0.0
*
* Class for colorized CLI output
*/
class Console
{
    /**
    * Prints colorzied text to console
    *
    * @param string $text - text for output
    * @param string $color - text color
    * @param string $eol - end of line symbols
    *
    * @return void
    */
    public static function print($text, $color = '', $eol = PHP_EOL)
    {
        switch ($color) {
            case 'green':
                    fwrite(STDOUT, "\033[0;32m".$text."\033[0m".$eol);

                    break;
            case 'red':
                    fwrite(STDOUT, "\033[0;31m".$text."\033[0m".$eol);

                    break;
            case 'yellow':
                    fwrite(STDOUT, "\033[1;33m".$text."\033[0m".$eol);

                    break;
            default:
                    fwrite(STDOUT, $text.$eol);

                    break;
        }
    }

    /**
    * Prints simple white (or any other default color) text to the CLI
    *
    * @param string $text - text for output
    *
    * @return void
    */
    public static function text($text)
    {
        self::print($text);
    }

    /**
    * Prints yellow text to the CLI
    *
    * @param string $text - text for output
    *
    * @return void
    */
    public static function notify($text)
    {
        self::print($text, 'yellow');
    }

    /**
    * Prints red text to the CLI
    *
    * @param string $text - text for output
    *
    * @return void
    */
    public static function error($text)
    {
        self::print($text, 'red');
    }
    /**
    * Prints green text to the CLI
    *
    * @param string $text - text for output
    *
    * @return void
    */
    public static function success($text)
    {
        self::print($text, 'green');
    }
}
