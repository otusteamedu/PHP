<?php

namespace App;

use Exception;
use Readers\RowsReader;

/**
 * Class App
 *
 * @package App
 */
class App
{
    /**
     * run the app
     * @throws Exception
     */
    public function run (): void
    {
        $filePath = '../files/emails.txt';
        $rows     = (new RowsReader($filePath))->read();
        var_dump($rows);
    }
}