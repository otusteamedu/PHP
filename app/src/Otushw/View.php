<?php


namespace Otushw;

class View
{
    public static function showStats($likeCoint, $disLikeCount, $method)
    {
        echo 'Number of Like: ' . $likeCoint . PHP_EOL;
        echo 'Number of DisLike: ' . $disLikeCount . PHP_EOL;
        echo 'Method used:' . $method . PHP_EOL;
    }

    public static function showGrabber($num)
    {
        echo 'Was added: ' . $num . PHP_EOL;
    }
}
