<?php
require_once __DIR__ . '/../vendor/autoload.php';
use App\Brackets;

if(isset($_POST['string'])) {
    $str  = $_POST['string'];
    $bracket = new Brackets();
    $response = '';
    if($bracket->matchBrackets($str) === true){
        $response = 'Correct pair';
    } else {
        $response = 'Not correct';
    }
}
echo $response;

?>

<a href="/">Вернуться</a>

