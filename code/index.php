<?php 
class Checker
{
    static public $check_string = '(()()()())((((()()()(()()())))))';

    static function stringChecker(){
		self::postChecker();
		if (self::bracketChecker()) {
			if (isset($_POST['string']) && $_POST['string'] == self::$check_string) {
				self::respondSender("HTTP/1.1 200 OK","OK");			
			} else {
				self::respondSender("HTTP/1.1 400 Bad Request","Bad request");				
			}	
			exit();		
		} else {
			self::respondSender("HTTP/1.1 500 Internal Server Error","Bad bracket structure");			
			exit();
		}
    }

    private static function bracketChecker(){
        $flag = 0;
		foreach (str_split($_POST['string']) as $letter) {
			if ( $letter == "(" ) {
				$flag++;
			}
			if ( $letter == ")" ) {
				$flag--;
			}					
		}
		if ($flag != 0 ) {
			return false;
		}		
		return true;
    }

    private static function postChecker(){
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {	
			self::respondSender("HTTP/1.1 500 Internal Server Error","The POST required");			
			exit();
		}		
		if ( strlen($_POST['string']) < 1 ) {
			self::respondSender("HTTP/1.1 500 Internal Server Error","The POST is empty");			
			exit();
		}
		return true;
    }

	private static function respondSender($code, $text){
		header($code);
		echo $text;
	}
}

Checker::stringChecker();





// if ($_SERVER['REQUEST_METHOD'] != 'POST') {	
// 	header('HTTP/1.1 500 Internal Server Error');
// 	echo "The POST required";
// 	exit();
// }

// if ( strlen($_POST['string']) < 1 ) {
// 	header('HTTP/1.1 500 Internal Server Error');
// 	echo "The POST is empty";
// 	exit();
// }

// $flag = 0;
// foreach (str_split($_POST['string']) as $letter) {
// 	if ( $letter == "(" ) {
// 		$flag++;
// 	}
// 	if ( $letter == ")" ) {
// 		$flag--;
// 	}
// 	if ( $flag < 0 ) {
// 		break;
// 	}
// }

// if ($flag != 0 ) {
// 	header('HTTP/1.1 500 Internal Server Error');
// 	echo "Bad bracket structure";
// 	exit();
// } else {
// 	if (isset($_POST['string']) && $_POST['string'] == $check_string) {
// 		header('HTTP/1.1 200 OK');
// 		echo "OK";
// 	} else {
// 		header('HTTP/1.1 400 Bad Request');
// 		echo "Bad request";
// 	}	
// }
