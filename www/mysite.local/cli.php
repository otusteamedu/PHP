<?php

if(PHP_SAPI == "cli") {
    echo "Welcome to the custom command line!\nEnter 'exit' or 'Ctrl+C' for leave command line.\n";
    myCommander();
}

function myCommander($ucmd = false) {
    if(!$ucmd) {
        $ucmd = myReadline("Enter command: ");
    }
    if($ucmd == 'exit') {
        exit();
    }
    $status = exec($ucmd);
    if($status == 127 || $status == 1) {
        if($fcmd = findCommand($ucmd)) {
            $ucmd = myReadline("Did you mean? (y)\n {$fcmd}\nEnter command: ");
            if($ucmd == 'y')
            {
                myCommander($fcmd);
            }
            else
            {
                myCommander($ucmd);
            }
        }
    }
    return myCommander();
}

function myReadline( $prompt = '' )
{
    echo $prompt;
    return rtrim( fgets( STDIN ), "\n" );
}

function mySystem($cmd) {
    $pp = proc_open($cmd, array(STDIN,STDOUT,STDERR), $pipes);
    if(!$pp) return 127;
        return proc_close($pp);
}

function findCommand($ucmds, $fcmd = array()) {
    
    if(!is_array($ucmds) && $ucmds) {
        $ucmds = explode(' ', $ucmds);
        return findCommand($ucmds);
    }
    
    $commands = [
        'pwd' => [],
        'clear' => [],
        'whoami' => [],
        'git' => [
            'pull' => [],
            'push' => [],
            'status' => [],
            'commit' => []
        ]
    ];
    
    if($fcmd)
    {
        $commands = getCommands($commands, $fcmd);
    }
    
    $ucmd = array_shift($ucmds);
    $shortest = -1;
    $find = false;
    
    foreach ($commands as $cmd => $array) {
        $lev = levenshtein($ucmd, $cmd);
        if(($lev <= $shortest || $shortest < 0) && $lev <= 2) {
            $find = true;
            $fcmd[] = $cmd;
            $shortest = $lev;
        }
    }
    
    if($commands && !$find) {
        unset($fcmd);
    }
    
    if($find && $ucmds) {
        return findCommand($ucmds, $fcmd);
    } elseif($fcmd) {
        if(!$find)
        {
            $fcmd[] = $ucmd;
        }
        if($ucmds) {
            $fcmd = array_merge($fcmd, $ucmds);
        }
    }
    
    return $fcmd ? implode(' ', $fcmd) : false;
    
}

function getCommands($commands, $fcmds) {
    
    if($fcmds) {
        $fcmd = array_shift($fcmds);
        if(is_array($commands[$fcmd])) {
            return getCommands($commands[$fcmd], $fcmds);
        }
    }
    
    return $commands;
}