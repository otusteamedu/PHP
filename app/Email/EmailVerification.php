<?php
namespace Email;

class EmailVerification
{ 
    public static function checkEmail($email = '') : bool
    {
	$regExp = '/^[0-9a-z-\.]+\@[0-9a-z-]{2,}\.[a-z]{2,}$/i';
        if (preg_match($regExp, $email))
    	    return true;

	return false;
    
    }

    public static function checkMX($email = '') : bool
    {
	if (function_exists('getmxrr')) { // if this function present
	    $splitEmail = explode ('@', $email);
	    
	    if (isset($splitEmail[1])) {
		$mxres = getmxrr ( $splitEmail[1], $mxhosts );
		
		if ($mxres && count($mxhosts) > 0) 
		    return true;
		    
	    }
	} 
	 
	return false;

    }

}