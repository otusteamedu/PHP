<h3>Введите строку</h3>
<form action="/" method="post">
    <input name="brackets" type="text" value="<?=$_POST['brackets']?>" placeholder="Введите строку () для валидации">
    <input type="submit" value="Проверить">
</form>
<p>Принятое значение: <?=$data["str"]?></p>
<p><?=$data["mess"]?></p>