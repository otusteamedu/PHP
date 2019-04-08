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
	$splitEmail = explode ('@', $email);

	if (isset($splitEmail[1])) {

	    $dns_rec = dns_get_record ($splitEmail[1]);

	    foreach ($dns_rec as $val) {

		if (in_array('MX', $val)) return true;
		
	    }
	}
	    
	return false;

    }

}