<?php


namespace Otushw;

use Exception;

class App
{
    private $db;
    private $typeApp;

    const GRABBER = 'grabber';
    const STATS = 'stats';
    const ALLOWED_TYPE = [self::GRABBER, self::STATS];
    const AGGR = 'aggregation';
    const COLLECTION = 'collection';
    const SUM = [self::AGGR, self::COLLECTION];

    public function __construct()
    {
        // DB initialization
        $dbSystem = $_ENV['DB_SYSTEM'];
        $prefix = __NAMESPACE__ . '\\DBSystem\\' . $dbSystem . '\\';
        $classDAO = $prefix . $dbSystem . 'DAO';
        $classDTO = $prefix . 'VideoDocumentDTO';
        foreach ([$classDAO, $classDTO] as $class) {
            if (!class_exists($class)) {
                throw new Exception("Class: '$class' does not exist");
            }
        }
        $db = new $classDAO(new $classDTO());
        if (!$db->existDocStruct()) {
            $db->createDocStruct();
        }
        $this->db = $db;

        // Argument initialization
        $this->validateParam();
        $this->typeApp = $_SERVER['argv'][1];
    }

    public function run()
    {
        $this->create();
    }

    private function create()
    {
        switch ($this->typeApp) {
            case self::GRABBER:
                return new Grabber($this->db);
            case self::STATS:
                return new Stats($this->db);
        }
    }

    private function validateParam()
    {
        if (!isset($_SERVER['argv'][1])) {
            throw new Exception('To run the script, need the parameter.');
        }
        if (empty($_SERVER['argv'][1])) {
            throw new Exception('Parameter is empty.');
        }
        if (!in_array($_SERVER['argv'][1], self::ALLOWED_TYPE)) {
            throw new Exception('Invalid parameter value. Allowed "'
                . self::GRABBER . '" or "' . self::STATS . '"');
        }
    }


}