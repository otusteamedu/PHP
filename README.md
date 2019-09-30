# Тестирование работы сокетов

Cервер www/hello.test/server.php отправляет сообщение, а клиент www/hello.test/client.php получает его.

Как запустить тест:
1. В одной вкладке терминала запускаем сервер `php hello.test/server.php &`
2. В другой вкладке запускаем клиент, в командной строке передаем сообщение. Например: 
`php hello.test/client.php hello`

3. Клиент через сокет передает сообщение на сервер. При удаче выводит "Отправлено".
4. Сервер выводит сообщение на экран.
5. Выключаться самостоятельно сервер не умеет, ему надо делать kill.

