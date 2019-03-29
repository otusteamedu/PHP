<?php

namespace App;

/**
 * Class Fixer
 * @package App
 */
class Fixer
{
    /**
     * @param string $string
     * @return string|null
     */
    public static function fix(string $string): ?string
    {
        if (preg_match('/git c[^t]+t/', $string)) {
            echo 'Maybe you meant: "git commit"? (y/n)';
            fscanf(STDIN, "%s\n", $answer);

            if ($answer == 'y') {
                return 'git commit';
            } else {
                return $string;
            }
        }

        return null;
    }
}