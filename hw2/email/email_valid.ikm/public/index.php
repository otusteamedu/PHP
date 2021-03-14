<?php
/**
 * Created by PhpStorm.
 * User: rainbow
 * Date: 04.01.21
 * Time: 20:52
 */

require_once('../vendor/autoload.php');

use EmailValid\EmailValid;

?>
<form action='/'>
    <textarea name='arr_email' placeholder='Введите email через ; :'></textarea>
    <br/>
    <input type='submit' value='Проверить'>
</form>
<?php
if (!empty($_GET['arr_email'])) {
    try {
        $valid = new EmailValid();
        $valid->review($_GET['arr_email']);
    }
    catch(Exception $e){
        echo $e->getMessage() . PHP_EOL . "\n";
    }
}
?>