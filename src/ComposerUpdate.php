<?php

namespace crazydope\command\fix;

class ComposerUpdate
{
    public function __invoke( string $input ): ?string
    {
        if ( $input === 'composer update' ) {
            return null;
        }

        if ( !preg_match('/c\w+r u\w+e/i', $input) ) {
            return null;
        }

        echo 'Maybe you meant: "composer update"? (y/n)' . PHP_EOL;
        $stdin = trim(fgets(STDIN));

        if ( $stdin !== 'y' ) {
            return $input;
        }

        return 'composer update';
    }
}