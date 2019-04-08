#!/usr/bin/env php
<?php

if ($argc>1) {
    //getting command
    $commandLine = trim($argv[1]);
    //is it git command
    if (strpos($commandLine, 'git ')!== false) {
        //try exec command and watch what we have
        $command = exec($commandLine . ' 2>&1', $output, $code);

        //Wow! it works! ok lets print output and exit
        if ($code == 0) {
            foreach ($output as $line) {
                echo $line . PHP_EOL;
            }
            exit();
        }

        //lets get wrong part of command from output
        $regexp = '/\'(.*)\'\\s/';
        $matches = null;
        preg_match($regexp, array_shift($output), $matches);
        //and magic mix it with right command from output
        $commandLine = str_replace($matches[1], trim(array_pop($output)), $commandLine);
        //and execute it
        echo shell_exec($commandLine);
    } else {
        echo 'No git command.' . PHP_EOL;
    }
} else {
    echo 'No commands in input.Try ./app.php "git commit"' . PHP_EOL;
}
