<?php
/**
* Class helps to colorize text for console output
*
* @author Evgeny Prokhorov <contact@jekys.ru>
* @package php-fuck
*/
namespace Jekys;

class Text
{
    /**
    * Returns colorzied text for console
    *
    * @param string $text - text for output
    * @param string $color - text color
    *
    * @return string
    */
    public static function colorize(String $text, String $color = '')
    {
        $output = $text;

        switch ($color) {
            case 'green':
                    $output = "\033[0;32m".$text."\033[0m";

                    break;
            case 'red':
                    $output = "\033[0;31m".$text."\033[0m";

                    break;
            case 'yellow':
                    $output = "\033[1;33m".$text."\033[0m";

                    break;
        }

        return $output;
    }

    /**
    * Returns yellow text for the CLI
    *
    * @param string $text - text for output
    *
    * @return string
    */
    public static function yellow(String $text)
    {
        return self::colorize($text, 'yellow');
    }

    /**
    * Prints red text for the CLI
    *
    * @param string $text - text for output
    *
    * @return string
    */
    public static function red($text)
    {
        return self::colorize($text, 'red');
    }
    /**
    * Returns green text for the CLI
    *
    * @param string $text - text for output
    *
    * @return string
    */
    public static function green($text)
    {
        return self::colorize($text, 'green');
    }
}
