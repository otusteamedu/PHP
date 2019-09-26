Задача:
реализовать один из паттернов: Table Data Gateway, Row Data Gateway, Active Record, DataMapper для произвольной таблицы

Таблица для примера:<br>
&nbsp;&nbsp;&nbsp;&nbsp;CREATE TABLE <br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;`users`<br> 
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(<br>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;`user_id` int(11) NOT NULL AUTO_INCREMENT,<br>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;`firstname` varchar(32) NOT NULL,<br>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;`lastname` varchar(32) NOT NULL,<br>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;`phone` varchar(10) NOT NULL,<br>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;`company` varchar(32) NOT NULL,<br>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;PRIMARY KEY (`user_id`)<br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)<br>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ENGINE=InnoDB DEFAULT CHARSET=utf8;<br>
 
 В index.php в переменных $dbuser, $dbpass, $dbname указать верные данные для подключения к базе.