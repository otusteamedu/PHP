<?php

namespace APankov;
/**
 * Class Fuck
 * @package APankov
 */
class Fuck
{
    /**
     * @var
     */
    private $command;

    /**
     * Fuck constructor.
     * @param $command
     */
    public function __construct($command)
    {
        $this->command = $command;
    }

    /**
     * @return string
     */
    public function execute()
    {
        if (preg_match('/g.{1}t c.{3,5}t/', $this->command)) {
            fputs(STDERR, "Исправить на: \"git commit\"? (y/n)" . PHP_EOL);
            fscanf(STDIN, '%s', $answer);
            if (strtolower($answer) === 'y') {
                return 'git commit';
            }
        }
        return '';
    }
}