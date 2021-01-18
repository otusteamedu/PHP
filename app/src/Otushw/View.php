<?php


namespace Otushw;


class View
{
    public static function showSearchResult(EventDTO $event)
    {
        echo "Event containts:" . PHP_EOL;
        foreach ((array) $event as $key => $item) {
            if (is_array($item)) {
                $item = implode($item);
            }
            echo $key . ': ' . $item . PHP_EOL;
        }
    }

    public static function showAdd(bool $result)
    {
        $msg = 'Event ';
        $sufix = 'was';
        if (!$result) {
            $sufix = 'was not';
        }
        echo $msg . $sufix . ' added';
    }

    public static function ShowStatusDelete(bool $result)
    {
        $msg = 'Deleted!';
        if (!$result) {
            $msg = 'Not deleted!';
        }
        echo $msg;
    }

    public static function showClient()
    {
        echo 'Something goes wrong and we are already working on this. Please try again later.'. PHP_EOL;
    }

    public static function showMessage(string $msg)
    {
        echo $msg . PHP_EOL;
    }
}