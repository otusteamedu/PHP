# Docker
____
### Набор контейнеров для работы
| Обозначение | Путь к dockerfile | Описание |
|----|:----:|:----|
| `>app`| ./fpm |исполнение скриптов |
| `>workspace` | ./workspace | контейнер для выполнения служебных функций (composer, npm и т.д)  |
| `>webserver`| ./nginx | webserver проекта |
| `>mysql-master`| Из репозитория | мастер база данных Mysql |
| `>mysql-slave`| Из репозитория | slave база данных Mysql |
| `>postgres`| Из репозитория | база данных Postgres |
| `>redis`| ./redis | база данных Redis |
| `>elasticsearch`| Из репозитория | база данных Elasticsearch |
| `>memcached`| ./memcached | контейнер, где крутиться memcached |

### Назначение папок
- code (Место расположения исполняемого кода)
  - [application.loc](./code/application.loc) - код для сайта application.loc
  - [otus.loc](./code/otus.loc) - код для сайта otus.loc
- log (Логи)
  - [memprof](log/memprof) - путь сохранения в проекте для данных из memprof берется из `$_SERVER['MEMPROF_LOG_PATH']`
  ```
   Используется в коде например так:
   $memprofPath = $_SERVER['MEMPROF_LOG_PATH'];
   memprof_dump_callgrind(fopen($memprofPath."memprof_logs.out", "w"));
  ```
  - [php_errors](log/php_errors) - расположение логов ошибок PHP
  - [xdebug](log/x-debug) - расопложение логов x-debug
- storage->docker (Хранение данных)
    - elasticsearch 
        - data
            - nodes
                - 0 - `нулевая нода у эластики`
    - mysql1 - `Место хранения данных Mysql-master`
    - mysql2 - `Место хранения данных Mysql-slave`
    - postgres - `Место хранения данных Postgres`
    - redis - `Место хранения данных elasticsearch`
    - sock - `Место хранения unix-socket`

### Структура .env

>#### environment
|Параметр|Назначение|
|----|----|
|TIMEZONE=Europe/Moscow| Зона времени, устанавливаемая на все контейнеры |

>#### Sites
|Параметр|Назначение|
|----|----|
|SITES_ENABLED_PATH=./nginx/hosts| Место на хосте, где находятся конфигурационные файлы для папки sites-enabled Веб-сервера. |

Достаточно положить в эту папку новый, настроенный файл типа `newsite.loc.conf`,
в ./code создать новую директорию с кодом, 
установить в файле `hosts` связь доменного имени с localhost,
перезагрузить веб-сервер и готово. Можно пользоваться новым доменным именем `http://newsite.loc`

>#### IDE
|Параметр|Назначение|
|----|----|
|PHP_IDE_CONFIG=serverName=Docker| Имя сервера в IDE, для режима пошаговой отладки x-debug, должно совпадать со значением в serverName |


>#### code
|Параметр|Назначение|
|----|----|
|PHP_VERSION=8.0| версия PHP |
|APP_CODE_PATH_HOST=./code| Местоположение кода на хосте |
|APP_CODE_PATH_DOCKER=/var/www/html| Местоположение кода в контейнерах |
|PHP_ERROR_LOG_PATH=./log/php_errors/ | Место складывания логов ошибок PHP |

>#### x-debug
|Параметр|Назначение|
|----|----|
|X_DEBUG=1|при true или 1 включается x-debug|
|X_DEBUG_ERROR_LOG_PATH=./log/x-debug/| Место складывания логов x-Debug |

>#### memprof
|Параметр|Назначение|
|----|----|
|MEMPROF_LOG_PATH_HOST=./log/memprof| путь для лога memprof на хосте |
|MEMPROF_LOG_PATH_DOCKER=/var/log/memprof/| путь для лога memprof в контейнере |

>#### unix socket
|Параметр|Назначение|
|----|----|
|UNIX_SOCKET_PATH_HOST=./storage/docker/sock| путь для файла сокета на хосте |
|UNIX_SOCKET_PATH_DOCKER=/sock| путь для файла сокета в контейнере |

>#### mysql-Master
|Параметр|Назначение|
|----|----|
|MYSQL_MASTER_DB=laravel| имя базы данных mysql-master |
|MYSQL_MASTER_ROOT_PASSWORD=password| пароль |
|MYSQL_MASTER_STORAGE_PLACE=./storage/docker/mysql1| путь к каталогу хранения данных |
|MYSQL_MASTER_LOG_PATH_HOST=./log/mysql/master| Место где можно смотреть логи на хосте |
|MYSQL_MASTER_LOG_PATH_DOCKER=/var/log/mysql/| Место хранения MySql логов в контейнере |

>#### mysql-Slave
|Параметр|Назначение|
|----|----|
|MYSQL_SLAVE_DB=laravel| имя базы данных mysql-slave |
|MYSQL_SLAVE_ROOT_PASSWORD=password| пароль |
|MYSQL_SLAVE_STORAGE_PLACE=./storage/docker/mysql2| путь к каталогу хранения данных |
|MYSQL_SLAVE_LOG_PATH_HOST=./log/mysql/master| Место где можно смотреть логи на хосте |
|MYSQL_SLAVE_LOG_PATH_DOCKER=/var/log/mysql/| Место хранения MySql логов в контейнере |

>#### postgres
|Параметр|Назначение|
|----|----|
|PGSQL_DB_NAME=postgres| имя базы данных Postgres - задается при создании контейнера, если базы нет |
|PGSQL_DB_USER=postgres| имя пользователя - задается при создании контейнера, если базы нет |
|PGSQL_DB_PASSWORD=password| пароль - задается при создании контейнера, если базы нет |
|PGSQL_STORAGE_PLACE=./storage/docker/postgres/data| путь к каталогу хранения данных |

>#### Redis
|Параметр|Назначение|
|----|----|
|REDIS_CONF=./redis/conf/redis/etc|местоположение конфигурационного файла redis|
|REDIS_DATA=./storage/docker/redis/data| путь к каталогу хранения данных |
|REDIS_LOG=./log/docker/redis/|  путь к каталогу логов |

>#### Elasticsearch
|Параметр|Назначение|
|----|----|
|ELASTICSEARCH_DATA=./storage/docker/elasticsearch/data| путь к каталогу хранения данных |
