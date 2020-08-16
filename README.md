# Homework 3

## 1. Установка расширений

Необходимо установить любое расширение через pecl и через make (xdebug, redis)

#### 1.1 Установка расширения через pecl
С помощью pecl было установлено расширение *redis*.

![Pecl list](https://downloader.disk.yandex.ru/preview/8d820a53f3d694277a979563f4efa166ea8b38d5ac04648b26371f731743d1fb/5f392e9e/LVCJgf9rphUoQNd3GRGskxKACy16qmAkwIkSzC2xiXC2VAVvDVXravghohAXi0lnZRm4tUUGk8U0crgSi6KT3w==?uid=0&filename=pecl_list%2Bphp_ini_grep.png&disposition=inline&hash=&limit=0&content_type=image%2Fpng&tknv=v2&owner_uid=195427551&size=2048x2048)

#### 1.2 Установка расширения через make
С помощью make было установлено расширение *xdebug*. Вывод команд `make` и `make install` представлен в файлах *output-make.txt* и *output-make-install.txt* соответсвенно.
Вывод команды `php -i | grep xdebug` представлен в файле *php-i-xdebug.txt*.

## 2. Создание и публикация пакета.

Ссылки на пакет:
- https://github.com/faskerov/helloworld.git
- https://packagist.org/packages/nifay/helloworld

Для установки через composer в *composer.json* необходимо прописать

```composer
"require": {
    "nifay/helloworld": "master-dev"
}
```

Для установки через гит

```composer
"require": {
    "nifay/helloworld": "dev-master"
},
"repositories":[
    {
      "type":"git",
      "url":"https://github.com/faskerov/helloworld.git"
    }
]
```

## 3. Создать docker образ для работы

Docker файл приложен к pull request.