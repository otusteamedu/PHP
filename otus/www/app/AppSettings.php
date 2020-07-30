<?php


namespace App;


interface AppSettings
{
    public const CONFIG_PATH = '/config/database.php';
    public const CONFIG_QUEUE_PATH = '/var/www/html/config/broker.php';
    public const DOCUMENT_ROOT = '/var/www/html/';
}
