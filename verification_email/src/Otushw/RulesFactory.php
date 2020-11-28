<?php


namespace Otushw;

use Exception;

class RulesFactory
{
    private $files;
    private $pathDirRules;
    private $rules;

    const DIR_NAME_RULES = 'Rules';
    const ABSCTRACT_CLASS = 'Rule.php';

    public function __construct()
    {
         $this->initRules();
    }

    public function getRules()
    {
        return $this->rules;
    }

    private function initRules()
    {
        $this->getRulesFiles();

        foreach ($this->files as $file) {
            $class = __NAMESPACE__ . '\\' . self::DIR_NAME_RULES . '\\' . pathinfo($file)['filename'];
            if (!class_exists($class)) {
                throw new Exception("Class: '$class' does not exist");
            }
            $this->rules[] = new $class();
        }
    }

    private function getRulesFiles()
    {
        $this->pathDirRules = __DIR__ . DIRECTORY_SEPARATOR . self::DIR_NAME_RULES;
        $files = scandir($this->pathDirRules);
        $excludeDir = ['.', '..', self::ABSCTRACT_CLASS];
        foreach ($files as $file) {
            if (in_array($file, $excludeDir)) {
                continue;
            }
            $file = $this->pathDirRules . DIRECTORY_SEPARATOR . pathinfo($file)['basename'];
            if (!file_exists($file)) {
                throw new Exception('File: ' . $file . ' does not exist');
            }
            require_once($file);
            $this->files[] = $file;
        }
    }
}