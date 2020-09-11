# Домашнее задание к уроку №5

## Приложение верификации email
1. Всю логику валидации почтового ящика вынес в отдельный пакет, опубликовал его на packegist.org (https://packagist.org/packages/chelout/simple-email-validator)
### Использование
```php
$validation = new EmailValidator([
    new RegexpRule(),
    new MxRule(),
]);
$validation->validate('user@example.com'); // boolean result
var_dump($validation->getErrors());
```

### Добавление новых правил
Чтобы создать новое правило, необходимо реализовать интерфейс `Chelout\EmailValidator\Rules\RuleContract`:

```php
class FilterVarRule implements RuleContract
{
    public function isValid(string $email): bool
    {
        return ! (filter_var($email, FILTER_VALIDATE_EMAIL) === false);
    }

    public function getError(): string
    {
        return 'Filter Var Rule failed.';
    }
}
```

2. Пакет используется в работе сервиса проверки списка почтовых адресов. Пример использования:
```shell
curl --location --request POST 'localhost:8080/' \
--header 'Content-Type: application/x-www-form-urlencoded' \
--data-urlencode 'emails[0]=qwe' \
--data-urlencode 'emails[1]=chelout@gmail.com'
```

Или с помощью `json`:
```shell
curl --location --request POST 'localhost:8080/' \
--header 'Content-Type: application/json' \
--data-raw '{
    "emails": [
        "qwe",
        "chelout@gmail.com",
        "слаффка@gmail.com",
        "слаффка@москва.рф",
        "chelout@@gmail.com"
    ]
}'
```

## Балансировка

Сделал два варианта балансировки:
1. Тупо скопировал нужное количество сервисов. Минус такого решения в том, что при необходимости запустить большее количество сервисов необходимо вносить правки в `docker-compose.yml`. Единственный плюс данного подхода на мой взгляд - работа через сокеты.
    Запуск приложения:
    ```
    cd homework-5/2-load-balancer-multicontainers
    docker-compose up
    ```
2. Использовал параметр `--scale`, который позволяет нам запускать произвольное количество сервисов. Минус такого подхода заключается в отсутствии возможности подключать `nginx` и `php-fpm` через сокеты. Кроме того, есть еще один нюанс - подключение `nginx` и `php-fpm` будет работать через `round robin` из-за специфики работы внутренней маршрутизации внутри докера.  
    ```
    cd homework-5/2-load-balancer-scale
    docker-compose up --scale nginx=3 --scale app=5
    ```