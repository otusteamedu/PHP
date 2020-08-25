# PHP

К уроку 4

1. Используя Docker, вы описали сборку двух контейнеров – один с nginx, второй – с php-fpm и вашим кодом.
Используя docker-compose вы запускаете оба контейнера.
Контейнер с nginx пробрасывает 80 порт на вашу хостовую машину и ожидает соединений.
Клиент соединяется, и шлёт следующий HTTP-запрос:

POST / HTTP/1.1
Content-Type: application/x-www-form-urlencoded
Content-Length: 48

string=(()()()()))((((()()()))(()()()(((()))))))

String - это POST-параметр, который можно проверять:
1.1. [ обязательно ] На длину и непустоту
1.2. [ по желанию ] На корректность кол-ва открытых и закрытых скобок

Все запросы с динамическим содержимым (*.php) nginx, используя директиву fastcgi_pass, проксирует в контейнер с php-fpm и вашим кодом.
Nginx должен обрабатывать запросы не обращая внимания на директиву Host. После обработки,
• если строка корректна, то пользователю возвращается ответ 200 OK, с информационным текстом, что всё хорошо;
• если строка некорректна, то пользователю возвращается ответ 400 Bad Request, с информационным текстом, что всё плохо.

2. Создать логику, размещаемую в двух контейнерах (server и client), объединённых общим volume. Скрипты запускаются в режиме прослушивания STDIN и обмениваются друг с другом вводимыми сообщениями через unix-сокеты.

```
1. задание лежит в папке nginx-php
2. задание лежит в папке unix_socket_php

```

----

К уроку 5

1. Приложение верификации email

1.1. Реализовать приложение (сервис/функцию) для верификации email.
1.2. Реализация будет в будущем встроена в более крупное решение.
1.3. Минимальный функционал - список строк, которые необходимо проверить на наличие валидных email.
1.4. Валидация по регулярным выражения и проверке DNS mx записи, без полноценной отправки письма-подтверждения.

2. Создать как минимум три машины/контейнера
2.1. Балансировщик nginx-upstream
2.2. Балансируемые бэкенды на nginx+php-fpm
Критерии оценки: К уроку 4 - 6 баллов
К уроку 5 - 4 балла

1. Строка в примере - только пример. На тестах она должна быть любой
2. Соответствие скобок должно быть и с точки зрения скобок. Тест ")(" не должен проходить
3. Конструкции @ и die неприемлемы. Вместо них используйте исключения
4. С точки зрения логики веб-сервиса ответ 400 - это валидное завершение работы скрипта
5. В рамках одной машины (без сетевого соединения) сборка LNMP гораздо быстрее работает при соединении FPM и Nginx через socket. Плюс за использование именно такой настройки.
6. Принимается только Unix-сокет
7. Код здесь и далее мы пишем с применением ООП
8. Код здесь и далее должен быть конфигурируем через файлы настроек типа config.ini
9. Желательно иметь возможность лёгкого расширения правил верификации дополнительными средствами.
10. Проверка MX-записи должна производиться встроенными средствами PHP
11. Каждая балансируемая нода должна выводить свой IP, чтобы клиент видел, на какую ноду он пришёл.
12. Обратите внимание на паттерн FrontController (он же - единая точка доступа). Все приложения, которые Вы создаёте здесь и далее должны вызываться через один файл index.php, в котором есть ТОЛЬКО

1. Точка входа - app.php
2. Сервер и клиент запускаются командами

php app.php server
php app.php client

3. В app.php только строки

require_once('/path/to/composer/autoload.php');

try {
$app = new App();
$app->run();
}
catch(Exception $e){

}

4. Логика чтения конфигураций и работы с сокетами - только в классах.