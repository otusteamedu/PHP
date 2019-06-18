<?php
function terminal($command)
{
    $return_var = '';
	//system
	if(function_exists('system'))
	{
		ob_start();
		system($command , $return_var);
		$output = ob_get_contents();
		ob_end_clean();
	}
	//passthru
	else if(function_exists('passthru'))
	{
		ob_start();
		passthru($command , $return_var);
		$output = ob_get_contents();
		ob_end_clean();
	}
	
	//exec
	else if(function_exists('exec'))
	{
		exec($command , $output , $return_var);
		$output = implode("n", $output);
	}
	
	//shell_exec
	else if(function_exists('shell_exec'))
	{
		$output = shell_exec($command) ;
	}
	
	else
	{
		$output = 'Command execution not possible on this system';
		$return_var = 1;
	}
	
	return array('output' => $output , 'status' => $return_var);
}

while ($line = trim(fgets(STDIN))) {
    $o = terminal($line . ' 2>&1');

    if($o['status'] == 0)
    {
        echo 'Your command was executed successful. Result: ' . PHP_EOL . $o['output'] . PHP_EOL;
    }
    else
    {
        //some problem
        $output = '';
        $out = $o['output'];
        if (strpos($out, 'is not a git command') !== false) {
            $arr_str = explode("\n", $out);
            $found = false;
            foreach ($arr_str as $str) {
                if (!$found && stripos($str, 'The most similar command') !== false) {
                    $found = true;
                    $output = 'You input incorrect command, please try:' . PHP_EOL;
                    continue;
                }
                if ($found && !empty($str)) {
                    $output .= 'git ' . trim($str) . PHP_EOL;
                }
            }
            if (!empty($output)) {
                fwrite(STDOUT, $output);
            }
        } else {
            echo 'I don\'t know fix for this :)) ' . PHP_EOL;
        }
    }
}

