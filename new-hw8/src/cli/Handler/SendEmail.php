<?php


namespace AYakovlev\cli\Handler;


use AYakovlev\cli\Log;


class SendEmail
{
    public static function sendEmail()
    {
        Log::getLog()->info('Sending email...');
        sleep(mt_rand(1, 2));
        Log::getLog()->info('Email sent');
    }
}