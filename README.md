# Сокеты

Два PHP-скрипта запускаются на одной машине и обмениваются сообщениями через unix-сокеты

## Options:
    -m, --msg        сообщение
    -q, --quit       остановить сервер после обмена сообщениями

### Usage

```sh
$ php server.php &
$ php client.php -m "Привет!"
$ php client.php -m "До скорого!" -q
```
