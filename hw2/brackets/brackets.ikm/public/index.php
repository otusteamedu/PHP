<?php
require_once('../vendor/autoload.php');

use ValidBrackets\ValidBrackets;

?>
<h3>Введите строку</h3>
<form action="/" method="post">
    <input name="brackets" type="text" value="<?=$_POST['brackets']?>" placeholder="Введите строку () для валидации">
    <input type="submit" value="Проверить">
</form>
<?php
$brackets = strip_tags($_POST['brackets']);
try {
    $app = new ValidBrackets();
    echo $app->isValid($brackets);
} catch (Exception $e) {
    echo $e->getMessage() . "\n";
}
?>
