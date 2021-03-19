<?php


namespace Services\Email;


class allowedEmails
{
    /**
     * Возвращает список email-ов
     * @return string[]
     */
    public static function getList():array
    {
        return$lines = file(__DIR__.'/emailsList.txt', FILE_IGNORE_NEW_LINES);
    }

}