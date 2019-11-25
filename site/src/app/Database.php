<?php
namespace App;

use MongoDB;
use MongoDB\Exception\Exception;

final class Database
{
  const dns='mongo';
  const port='27017';
  const protocol='mongodb';
  const username='admin';
  const pass='12345';



    public static function init()
    {


        try {
            $dbh = new MongoDB\Client(self::protocol."://".self::dns.":".self::port);
        } catch (Exception $e) {
            echo "Unable to connect: " . $e->getMessage() . "<p>";
        }
        return $dbh;
    }
}
