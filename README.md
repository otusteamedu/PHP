### 1.Установить расширение через pecl и make
Было установлен pecl репозиторий модулей для PHP, через команду `sudo apt-get install php-pear`.
Список установленных расширений можно увидеть на скриншоте ![hw1-3/pecl-list.png](/hw1-3/pecl-list.png). Вывод команды `php -i | grep "xdebug"` и `php -i | grep "redis"`
можно увидеть на скриншотах ![hw1-3/xdebug.png](/hw1-3/xdebug.png) и ![hw1-3/redis.png](/hw1-3/redis.png).
 вывод команды make на скриншоте ![hw1-3/make_output.txt](/hw1-3/make_output.txt)

---

### 2. Установка своего пакета
Клонирование репозитария:
````bash
$ git clone https://github.com/AidarIlyasov/curl-composer.git
````
Для установки через Composer, необходимо в файле composer.json в секции require добавить путь к пакету
```
"require": {
    "ilyasov/curl-parser": "dev-master"
},
```

---

### 3. Создать Docker-образ для работы
создан образ ![Dockerfile](/hw1-3/Dockerfile), который включает расширения redis, memcached, pecl_http, pdo_pgsql
Запустить образ можно командой `docker build -t test/app .`