<?php


namespace Otushw;

class Message
{

    /**
     * @param string $message
     */
    public static function showMessage(string $message): void
    {
        echo $message . self::getEOL();
    }

    /**
     * @return string
     */
    private function getEOL(): string
    {
        if (constant($_ENV['EOL']) == PHP_EOL) {
            return PHP_EOL;
        }
        return $_ENV['EOL'];

    }
}