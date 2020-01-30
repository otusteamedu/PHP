Перед сборкой образов необходимо в файле .env указать 
правильные хосты и порты для подключения к хранилищам Redis и MongoDB
пример .env можно посотмреть .env.example



### Установка окружения выполнения
```shell script
docker-compose up -d
```

##### Установка зависимостей 
```shell script
composer install
```

##### Регенерация автозагрузчика
```shell script
composer dump-autoload -o
```