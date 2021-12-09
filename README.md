# Домашняя работа по созданию API

### Требования
1. PHP >=8.0
2. Composer
3. Набор серверов (установленный сервер Redis используется в качестве очереди)

### Используются библиотеки
1. "vlucas/phpdotenv": "^5.1",
2. "monolog/monolog": "2.x-dev",


### Описание проекта
Маршруты для API:
[routes/api.php](./api/routes/api.php)

Контроллеры для обработки маршрутов:
[UserController](api/app/Http/Controllers/Api/V1/Users/UserController.php)
В нем используются методы:

>list - вывод всех пользователей

>store - сохранение нового пользователя (используется очередь)

>show - вывод информации по конкретному пользователю

>update - изменение информации о пользователей

>destroy - удаление пользователя

>getEstate - Поиск имущества для пользователя (используется очередь)

В слое Service созданы сервисы для сущностей `Users` и `Estate`

[Repositories](api/app/Services/Users/Repositories) - репозитории для работы с базами данных

[Jobs](api/app/Services/Users/Jobs) - задания помещаемые в очередь

[Handlers](api/app/Services/Users/Handlers) - обработчики заданий

### Использование очереди
В контроллере метод поиска недвижимости `getEstate` обращается в сервис для предоставления данных.
В нем происходит постановка заданий в очередь путем вызова метода
`FindUserMovableEstateJob::dispatch($user);`

Чтобы запустить обработчик очередей используется команда: `>php artisan queue:work --queue=findUserMovableEstate`

### Документирование API
Для документирования API используется библиотека "knuckleswtf/scribe"
с помощью команды `php artisan scribe:generate` создается документация и помещается в [public/docs](public/docs)
Для ее просмотра можно использовать `api/public/docs/openapi.yaml` или обратиться по адресу: http://localhost/docs
