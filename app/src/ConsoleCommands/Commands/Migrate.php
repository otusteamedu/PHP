<?php


namespace App\ConsoleCommands\Commands;


use App\Services\Database\DB;
use App\Services\ServiceContainer\AppServiceContainer;

class Migrate implements Command
{
    private DB $db;

    public function __construct()
    {
        $this->db = AppServiceContainer::getInstance()->resolve(DB::class);
    }

    public function run(array $argv): string
    {
        $sqlsDirectory = __DIR__ .'/../../Database/sqls';
        $result = '';
        foreach(scandir( $sqlsDirectory ) as $path){
            if(!is_dir($path)){
                $content = file_get_contents($sqlsDirectory . DIRECTORY_SEPARATOR . $path);
                $this->db->getPdo()->exec($content);
                $result .= 'Migrate ' . $path . ' success' . PHP_EOL;
            }
        }

        return $result;
    }
}