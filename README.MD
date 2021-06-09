## Старт

* Запустить миграцию `php artisan migrate:fresh`
* Создать очередь `php artisan rabbitmq:queue-declare order`
* Запустить приёмник `php artisan rabbitmq:consume --queue=order`

## Ручной запуск

* Отправить post запрос на `/api/orders/` с параметром `price`
* Отправить get запрос на `/api/orders/#id#/`

## Postman

* Импортировать коллекцию из `./postman/`
* Выполнить запросы

## Swagger

* Запустить `php artisan swagger-lume:publish-views` для создания view
* Запустить `php artisan swagger-lume:generate` для генерации документации
* Открыть `/` (корень сайта).