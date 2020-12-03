# hw10. ДЗ: Скрипт деплоя

## Framework & application
Деплой организован с помощью **capistrano v3.14.1**

Деплоим приложение на фреймворке Laravel 8.11

## Server
На целевом сервере https://example.com создаем каталоги деплоя и прописываем необходимые права:
```
$ sudo mkdir /var/www/laravel-capistrano
$ sudo chown -R username:group /var/www/laravel-capistrano
```

## Инициализация скрипта
В корневом каталоге приложения устнавливаем **capistrano**
```
$ cap install
```
Конфигурируем деплой в файлах **/config/deploy.rb**, **/config/deploy/production.rb**

## let’s deploy
Запускаем деплой:
```
$ cap production deploy
```
