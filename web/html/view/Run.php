<!DOCTYPE html>
<html>
	<head>
		<title>Управление событиями</title>
	</head>
	<body>
		<form method = "POST">
			param1: <input type = "text"  name = "param1" value =  "1"> <br> <br>
			param2: <input type = "text"  name = "param2" value =  "1"> <br> <br>
			<input type = "submit" name = "action" value = "add">
            <input type = "submit" name = "action" value = "dell_all">
		</form>
        <table border="1">
            <caption>Таблица событий</caption>
            <tr>
                <th>События из базы</th>                
            </tr>
            <?
                foreach ( \model\RedisDB::getAllEvents() as $event ) {
                    echo '<tr><td>' . $event . '</td></tr>';               
                }                
            ?>
        </table>
	</body>
</html>