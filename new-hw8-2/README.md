# Очереди (rabbitmq)

## Получаем и запускаем rabbitmq+management

```
$ docker pull rabbitmq:3-management
$ docker run -d -p 15672:15672 -p 5672:5672 --name rabbit-docker rabbitmq:3-management
```
Работой RabbitMq управляем по адресу ``localhost:15672``
## Запускаем приложение 
```
$ php cli.php Send -d="/files/data.json" -t="invoice"
```
в параметрах передаем:

``-d="/files/data.json"``  массив json-данных для генерации накладной,

``-t="invoice"`` шаблон для генерации накладной.


## Запускаем необходимое число воркеров в консоли

```
$ php cli.php Receive
```
Получаем вывод об обработке сообщений в консоли.

Расширенные сообщения получаем в логах.

### По завершении прерываем процессы отслеживания ``Ctrl+C``

## Используемые паттерны
Front Controller, Active Record, Proxy