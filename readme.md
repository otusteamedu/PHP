#hw

##hw-1

Домашнее задание
Готовим окружение
Цель: Познакомиться с различными типами организации окружения.
Осознать их применимость и необходимость.
Научиться настраивать рабочее окружение для своих проектов с использованием автоматизации.

Это домашнее задание посвящено 1 части 1 модуля (занятия 1-3). Делайте его постепенно, от занятия к занятию. Сдавать 
можно как постепенно, так и "всё сразу".

###hw-1-1-docker-vagrant-clouds
К уроку 1.

####task1&2
1. Docker
1.1. Установить Docker себе на машину
1.2. С помощью Dockerfile настроить статический сайт (можно использовать nginx образ)

2. Виртуальные машины. Развернуть Homestead VM при помощи Vagrant и VirtualBox

####task3
3. Выберите в качестве примера свою текущую компанию (или компанию, в которой хотите работать), коротко опишите ее 
   (количество сотрудников, сфера, приоритеты)
Сравните целесообразность разворачивания своей инфраструктуры или аренды публичного облака (можно выбрать любого 
   провайдера)

----

###hw-1-2-console
К уроку 2

####task1
1. Написать консольное приложение (bash-скрипт), который принимает два числа и выводит их сумму в стандартный вывод.
Если предоставлены неверные аргументы (для проверки на число можно использовать регулярное выражение) вывести ошибку 
   в консоль.

- числа для суммирования могут быть отрицательными и вещественными
- если Вы запускаете скрипты на базе Docker под Windows 10, то поведение функции sort по умолчанию отличается от 
  стандартного в linux (числа сортируются как числа, а не как строки)

####task2
2. Имеется таблица следующего вида:

id user city phone
1 test Moscow 1234123
2 test2 Saint-P 1232121
3 test3 Tver 4352124
4 test4 Milan 7990923
5 test5 Moscow 908213

Таблица хранится в текстовом файле.

Вывести на экран 3 наиболее популярных города среди пользователей системы, используя утилиты Линукса.

Подсказка: рекомендуется использовать утилиты uniq, awk, sort, head.

----

###hw-1-3-php-utilities
К уроку 3

####task1
1. Необходимо установить любое расширение через pecl и через make (xdebug, redis)
- прислать скриншот команды pecl list, где должно значиться расширение + вывод функции `php -i | grep "ваше расширение"`
- прислать вывод команды make, т.е. `make > make_output.txt` + вывод функции `php -i | grep "ваше расширение"`

####task2
2. Необходимо создать свой пакет, и выложить в git и/или на packagist.org
- прислать команду для клонирования с гита
- прислать команду для установки через composer

####task3
3. Создать Docker-образ для работы
Необходимо создать образ, который будет включать:
- образ php, берем с https://hub.docker.com/_/php/
- необходимые утилиты (git, curl, wget, grep...)
- установленный composer
- установленные расширения redis, memcached, pecl_http, pdo_pgsql
Критерии оценки: Урок 1 - 4 балла
Урок 2 - 3 балла
Урок 3 - 3 балла

1. Каждый RUN в Dockerfile будет создавать промежуточный образ при сборке. Помните об этом. Желательно снизить их 
   использование до минимума.
2. Пакет должен соответствовать PSR-4


##hw-2

Домашнее задание
Веб-серверы и логика
Цель: Научиться создавать приложения, которые запускают и работают в экосистеме контейнеров.
Исследовать возможность общения скриптов через механизм сокетов.
Научиться работать с базовыми средствами исследования уязвимостей инфраструктуры.

Это домашнее задание посвящено 2 части 1 модуля (занятия 4-5). Делайте его постепенно, от занятия к занятию. Сдавать 
можно как постепенно, так и "всё сразу".

###hw-2-1-brackets-socket
К уроку 4

####task1
1. Используя Docker, вы описали сборку двух контейнеров – один с nginx, второй – с php-fpm и вашим кодом.
Используя docker-compose вы запускаете оба контейнера.
Контейнер с nginx пробрасывает 80 порт на вашу хостовую машину и ожидает соединений.
Клиент соединяется, и шлёт следующий HTTP-запрос:

POST / HTTP/1.1

string=(()()()()))((((()()()))(()()()(((()))))))

String - это POST-параметр, который можно проверять:

1.1. [ обязательно ] На длину и непустоту
1.2. [ по желанию ] На корректность кол-ва открытых и закрытых скобок

Все запросы с динамическим содержимым (*.php) nginx, используя директиву fastcgi_pass, проксирует в контейнер с php-fpm 
и вашим кодом.
Nginx должен обрабатывать запросы не обращая внимания на директиву Host. После обработки,
• если строка корректна, то пользователю возвращается ответ 200 OK, с информационным текстом, что всё хорошо;
• если строка некорректна, то пользователю возвращается ответ 400 Bad Request, с информационным текстом, что всё плохо.

####task2
2. Создать логику, размещаемую в двух контейнерах (server и client), объединённых общим volume. Скрипты запускаются в 
   режиме прослушивания STDIN и обмениваются друг с другом вводимыми сообщениями через unix-сокеты.

----

###hw-2-2
К уроку 5

####task1
1. Приложение верификации email

1.1. Реализовать приложение (сервис/функцию) для верификации email.
1.2. Реализация будет в будущем встроена в более крупное решение.
1.3. Минимальный функционал - список строк, которые необходимо проверить на наличие валидных email.
1.4. Валидация по регулярным выражения и проверке DNS mx записи, без полноценной отправки письма-подтверждения.

####task2
2. Создать как минимум три машины/контейнера
2.1. Балансировщик nginx-upstream
2.2. Балансируемые бэкенды на nginx+php-fpm
Критерии оценки: К уроку 4 - 6 баллов
К уроку 5 - 4 балла

1. Строка в примере - только пример. На тестах она должна быть любой
2. Соответствие скобок должно быть и с точки зрения скобок. Тест ")(" не должен проходить
3. Конструкции @ и die неприемлемы. Вместо них используйте исключения
4. С точки зрения логики веб-сервиса ответ 400 - это валидное завершение работы скрипта
5. В рамках одной машины (без сетевого соединения) сборка LNMP гораздо быстрее работает при соединении FPM и Nginx 
   через socket. Плюс за использование именно такой настройки.
6. Принимается только Unix-сокет
7. Код здесь и далее мы пишем с применением ООП
8. Код здесь и далее должен быть конфигурируем через файлы настроек типа config.ini
9. Желательно иметь возможность лёгкого расширения правил верификации дополнительными средствами.
10. Проверка MX-записи должна производиться встроенными средствами PHP
11. Каждая балансируемая нода должна выводить свой IP, чтобы клиент видел, на какую ноду он пришёл.
12. Обратите внимание на паттерн FrontController (он же - единая точка доступа). Все приложения, которые 
    Вы создаёте здесь и далее должны вызываться через один файл index.php, в котором есть ТОЛЬКО

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

##hw-3
Домашнее задание
Реляционные СУБД
Цель: Закрепить навыки проектирования баз данных;
Научиться правильно нормализовать хранение данных;
Научиться описывать БД через DDL;
Потренироваться в написании сложных SQL-запросов поверх схемы для проверки правильности структуры.
Усилить схему гибким хранением значений различного типа без нарушения нормализации.
Научиться повышать производительность сервера БД на уровне администрирования настроек.

Это домашнее задание посвящено 1 части 2 модуля (занятия 7-10). Делайте его постепенно, от занятия к занятию. 
Сдавать можно как постепенно, так и "всё сразу".
К уроку 7
###hw-3-1-lesson7

Спроектируйте схему данных для системы управления кинотеатром
* Кинотеатр имеет несколько залов, в каждом зале идет несколько разных сеансов, клиенты могут купить билеты на сеансы
* Спроектировать базу данных для управления кинотеатром
* Задокументировать с помощью логической модели
* Написать DDL скрипты
* Написать SQL для нахождения самого прибыльного фильма

----

К уроку 9
###hw-3-2-lesson9

Спроектировать EAV-хранение для базы данных кинотеатра
4 таблицы: фильмы, атрибуты, типы атрибутов, значения.
Типы атрибутов и соответствующие им атрибуты (для примера):
- рецензии (текстовые значения) - рецензии критиков, отзыв неизвестной киноакадемии ...
- премия (заменяется при печати баннеров и билетов на изображение, логическое значение) - оскар, ника ...
- "важные даты" даты (при печати - наименование атрибута и значение даты, тип дата) - мировая премьера, 
  премьера в РФ ...
- служебные даты (используются при планировании, тип дата) - дата начала продажи билетов, когда запускать 
  рекламу на ТВ ...
  View сборки служебных данных в форме (три колонки):
- фильм, задачи актуальные на сегодня, задачи актуальные через 20 дней
  View сборки данных для маркетинга в форме (три колонки):
- фильм, тип атрибута, атрибут, значение (значение выводим как текст)

----

К уроку 10
###hw-3-3-lesson10

Подготовить список из 6 основных запросов к БД, разработанной на предыдущих занятиях. Целесообразно выбрать 3 "простых" 
(задействована 1 таблица), 3 "сложных" (агрегатные функции, связи таблиц).
Скрипт для наполнения основных таблиц БД тестовыми данными.
Заполнить таблицы, увеличив общее количество строк текстовых данных до 10000.
Провести анализ производительности запросов к БД, сохранить планы выполнения.
Заполнить таблицы, увеличив общее количество строк текстовых данных до 10000000.
Провести анализ производительности запросов к БД, сохранить планы выполнения.
На основе анализа запросов и планов предложить оптимизации (индексы, структура, параметры и др.), выполнить их, 
сравнить результат (планы выполнения).
Критерии оценки: К уроку 7 - 3 балла
К уроку 9 - 3 балла
К уроку 10 - 4 балла

1. Достаточность таблиц и связей между ними
2. Выполнение правил нормализации
3. Наличие логической модели
4. Указание типов данных в логической модели

5. Учтены все допустимые типы данных
6. Учтена специфика хранения и последующего использования float-данных
7. EAV-схема оснащена индексами

8. Результат:
- скрипт создания БД (с предыдущих занятий)
- скрипт заполнения БД тестовыми данными
- таблица с результатами по каждому из 6 запросов
- запрос
- план на БД до 10000 строк
- план на БД до 10000000 строк
- план на БД до 10000000 строк, что удалось улучшить
- перечень оптимизаций с пояснениями
- отсортированный список (15 значений) самых больших по размеру объектов БД (таблицы, включая индексы, сами индексы)
- отсортированные списки (по 5 значений) самых часто и редко используемых индексов

##hw-4
NoSQL, работа PHP с хранилищем
Цель: Научиться создавать приложение для анализа каналов на Youtube.
Научиться писать систему.
Закрепить навыки работы с БД на уровне логики;
Научиться применять на практике востребованные паттерны работы с хранилищами.

Это домашнее задание посвящено 2 части 2 модуля (занятия 11-14). Делайте его постепенно, от занятия к занятию. Сдавать 
можно как постепенно, так и "всё сразу".
###hw-4-1-lesson11-youtube
К уроку 11

1. Создать приложение для анализа каналов на Youtube:
   1.1. Создать структуру/структуры хранения информации о канале и видео канала в Elasticsearch, описать в виде JSON с 
   указанием типов полей. Описать какие индексы понадобятся в данной структуре?
   1.2. Создать необходимые модели для добавления и удаления данных из коллекций
   1.3. Реализовать класс статистики, который может возвращать:
- Суммарное кол-во лайков и дизлайков для канала по всем его видео
- Топ N каналов с лучшим соотношением кол-во лайков/кол-во дизлайков
  1.4*. Можно создать паука, который будет ходить по Youtube и наполнять базу данными

###hw-4-2-lesson12
К уроку 12
2. Аналитик хочет иметь систему со следующими возможностями:
   2.1. Система должна хранить события, которые в последующем будут отправляться сервису событий
   2.2. События характеризуются важностью (аналитик готов выставлять важность в целых числах)
   2.3. События характеризуются критериями возникновения. Событие возникает только если выполнены все критерии его 
   возникновения. Для простоты все критерии заданы так: <критерий>=<значение>

Таким образом предположим, что аналитик заносит в систему следующие события:
{
priority: 1000,
conditions: {
param1 = 1
},
event: {
::event::
},
},
{
priority: 2000,
conditions: {
param1 = 2,
param2 = 2
},
event: {
::event::
},
},
{
priority: 3000,
conditions: {
param1 = 1,
param2 = 2
},
event: {
::event::
},
},

От пользователя приходит запрос:
{
params: {
param1 = 1,
param2 = 2
}
}

Под этот запрос подходят первая и третья запись, т.к. в них обеих выполнены все условия, но приоритетнее третья, так как
имеет больший priority.

Написать систему, которая будет уметь:
1) добавлять новое событие в систему хранения событий
2) очищать все доступные события
3) отвечать на запрос пользователя наиболее подходящим событием
4) использовать для хранения событий redis

----

###hw-4-3-lesson14
К уроку 14

Необходимо реализовать один из паттернов: Table Data Gateway, Raw Data Gateway, Active Record, DataMapper для 
произвольной таблицы. 
Паттерн должен содержать метод массового получения информации из таблицы, результат которого возвращается в виде 
коллекции.
Дополнительно можно использовать паттерн Identity Map для устранения дублирования объектов, ссылающихся на одну строку
в БД 
или Lazy Load для отложенной загрузки связанных записей в таблице или коллекции.
Критерии оценки: К уроку 11 - 5 баллов
К уроку 14 - 5 баллов

1. Желательно параллельно попрактиковаться и выполнить ДЗ в других NoSQL хранилищах
2. Слой кода, отвечающий за работу с хранилищем должен позволять легко менять хранилище
3. Основная задача - реализация одного из перечисленных паттернов на произвольной таблице
4. Желательно реализовать метод массового получения информации
5. Желательно реализовать один из паттернов: Identity Map или Lazy Load


##hw-5-code-architecture
Анализ кода

Цель:
Применить на практике изученные принципы; Научиться работать над аналитическими задачами в отношении кода.

Выберите один из своих проектов Проведите анализ на предмет соответствия изученным принципам. 
Предложите свои варианты исправления.

Критерии оценки:
Все утверждения подкреплены кодом "до" и "после" (8 баллов)
Желательно составить uml-схемы "до" и "после" (2 балла)


##hw-6-design patterns
Паттерны проектирования

Цель:
Набор задач на реализацию изученных паттернов. Требуется решить минимум 5 задач.

>Есть абстрактная фабрика, которая генерирует статьи в разных форматах (например, html, xml, json), статьи бывают
>разных видов (новости, обзоры, что-то ещё)
> 
>Наблюдатель будет использоваться, чтобы отслеживать появление статей
>
>Посетитель будет обходить статьи и определять их вид, оставляя только новости
>
>Адаптер понадобится, чтобы преобразовать новости из разных форматов в какой-то единый
>
>Прокси предоставляет "заглушку" для новости сразу, как только посетитель определил, что это новость
>(например, сразу отдаёт заголовок новости, а тело - только после разбора и преобразования в нужный формат

Выберите пять из 12 паттернов:

Абстрактная фабрика
Адаптер
Декоратор
Инверсия зависимости
Фабричный метод
Итератор
Маппер
Наблюдатель
Прокси
Прототип
Стратегия
Посетитель
Запросите задачи у преподавателя

Реализуйте паттерн на базе предложенного кода.

Критерии оценки:
Каждый паттерн - 2 балла Реализация должна соответствовать определению паттерна, DRY, KISS, SOLID.


##hw-7-unit-tests
Разработка кейсов тестирования

Цель:
В этом домашнем задании мы тренируем умение разрабатывать кейсы тестирования на трёх уровнях:
модульном, интеграционном и системном. Данное умение необходимо, если разрабатываемое приложение покрывается тестами
с какими-либо целями.

Скачать файл с заданием https://drive.google.com/file/d/1yAtmj9DE2yFeGh26WxDwr42j7RVbB_PI/view?usp=sharing
Внутри файла содержится задача, результат выполнения задачи необходимо сохранить в md-файл или doc-файл.
Полученный файл выложить в git, Google Drive или любой другой файлообменник
Ссылку на файл прислать в чат с преподавателем
Критерии оценки:
Критерии оценивания содержатся внутри файла с задачей.


##hw-8-queue
Работа с очередью

Создать простое веб-приложение, принимающее POST запрос
Передать тело запроса в очередь
Написать скрипт, который будет читать сообщения из очереди и выводить информацию о них в консоль
Приложить инструкцию по запуску системы

Критерии оценки:
Работоспособность решения
Чистота кода

##hw-9-design-api
API

Цель:
Научиться создавать универсальный интерфейс для различных потребителей (frontend фреймворки, мобильные приложения,
сторонние приложения)

Необходимо реализовать Rest API с использованием очередей. Ваши клиенты будут отправлять запросы на обработку,
а вы будете складывать их в очередь и возвращать номер запроса. В фоновом режиме вы будете обрабатывать запросы,
а ваши клиенты периодически, используя номер запроса, будут проверять статус его обработки.

Разрешается

Использование Composer-зависимостей
Использование микрофреймворков (Lumen, Silex и т.п.)
Критерии оценки:
5 баллов за реализацию API 3 балла за применение очередей 2 балла за документацию (например, в Swagger)


##hw-10-deployment
Скрипт деплоя

Цель:
Научиться доставлять приложение до указанной среды

Используя выбранный инструмент автоматического деплоя, необходимо реализовать автоматическую выкатку написанного ранее
мини-приложения на собственный виртуальный сервер.

Критерии оценки:
Автоматическая доставка на любую среду
Доставка без downtime
Желательно организовать отдельный закрытый репозиторий настроек, из которого формируются файлы конфигурации для
выбранной среды в момент деплоя
