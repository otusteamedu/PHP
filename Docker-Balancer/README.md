# Docker
____

После загрузки из репозитория необходимо зайти в папку Docker-Balancer и запустить команду `>start_copy.bat` для windows или ` >./start_copy.sh ` для linux
В результате будут скопированы требуемые конфигурационные файлы
При необходимости их следует настроить:
- **.env** (~Пример `.env.example`)
- **.gitignore** (~Пример `.gitignore.example`)
- **docker-compose.yml** (~Пример `docker-compose.yml.bak`)
- **./code/application.loc/.env**

Далее можно установить сертификаты для работы по протоколу https://
Для этого запускается ` >run.bat ` для windows или ` >./run.sh ` для linux,
и настроить соответствующие конфиг. файлы в [nginx/hosts](nginx/hosts)

### Набор контейнеров для работы
| Обозначение | Путь к dockerfile | Описание |
|----|:----:|:----|
| `>app-1`| ./fpm-1 |исполнение скриптов |
| `>app-2`| ./fpm-2 |исполнение скриптов |
| `>workspace` | ./workspace | контейнер для выполнения служебных функций (composer, npm и т.д)  |
| `>webserver`| ./nginx | webserver проекта |
| `>mysql-master`| Из репозитория | мастер база данных Mysql |
| `>mysql-slave`| Из репозитория | slave база данных Mysql |
| `>postgres`| Из репозитория | база данных Postgres |
| `>redis`| ./redis | база данных Redis |
| `>elasticsearch`| Из репозитория | база данных Elasticsearch |
| `>memcached`| ./memcached-1 | контейнер, где крутиться memcached |
| `>memcached`| ./memcached-2 | контейнер, где крутиться memcached |
    
### Назначение папок
- [code](./code) (Место расположения исполняемого кода)
  - [application.loc](./code/application.loc) - код для сайта `application.loc`. 
    Это единственная папка, находящаяся в каталоге ./code, в которой изменения отслеживаются гитом (MyDock)
  - [otus.loc](./code/otus.loc) - код для сайта `otus.loc`
    (Для работы сайта otus.loc необходимо создать каталог `/otus.loc` в папке 
    на которую указывает параметр `CODE` из файла настроек `.env`. Начальная настройка на папку `./code`. 
    Папка `./code/otus.loc`не отслеживается гитом (MyDock), поэтому можно использовать код из другого репозитория)
    - [valyakin.loc](./code/valyakin.loc) - код для сайта `valyakin.loc` 
    (Для работы сайта valyakin.loc необходимо создать каталог `/valyakin.loc` в папке
    на которую указывает параметр `CODE` из файла настроек `.env`. Начальная настройка на папку `./code`.
    Папка `./code/valyakin.loc`не отслеживается гитом (MyDock), поэтому можно использовать код из другого репозитория)
- [fpm-1](./fpm-1) - папка с данными для создания контейнера `app`
- [fpm-2](./fpm-2) - папка с данными для создания контейнера `app`
- [memcached-1](./memcached-1) - папка с данными для создания контейнера `memcached`
- [memcached-2](./memcached-2) - папка с данными для создания контейнера `memcached`
- [mysql](./mysql) - папка с данными для создания контейнеров `mysql-master` и `mysql-slave`
- [nginx](./nginx) - папка с данными для создания контейнера `webserver`
    - [hosts](./nginx/hosts) - место, где находятся конфигурационные файлы для сайтов 
- [redis](./redis) - папка с данными для создания контейнера `redis`
- [workspace](./workspace) - папка с данными для создания контейнера `workspace`
  - [scripts](workspace/scripts) - папка со скриптами
    - [certificate](workspace/scripts/certificate) - скрипты для создания сертификата сайта
      - `./create_root_ca.sh` - создает корневой сертификат с приватным для него ключем
      - `./create_certicicate_for_domain.sh mysite.loca` - создает сертификат для сайта с приватным ключем для всех сайтов (если еще не было)
- [_logs](./_logs) (Логи) Настраивается параматром `LOGS=./_logs` в файле .env
  - [memprof](_logs/memprof) - путь сохранения в проекте для данных из memprof берется из `$_SERVER['MEMPROF_LOG_PATH']`
  ```
   Используется в коде например так:
   $memprofPath = $_SERVER['MEMPROF_LOG_PATH'];
   memprof_dump_callgrind(fopen($memprofPath."memprof_logs.out", "w"));
  ```
  - [mysql](_logs/mysql) - расположение логов Mysql (/master, /slave)
  - [nginx](_logs/nginx) - расположение логов Nginx
  - [php_errors](_logs/php_errors) - расположение логов ошибок PHP
  - [redis](_logs/redis) - расположение логов redis
  - [xdebug](_logs/x-debug) - расопложение логов x-debug
- [ZoneForSTORAGE](./ZoneForSTORAGE) (Хранение данных) Настраивается параматром STORAGE=./ZoneForSTORAGE в файле .env
    - certificates - место хранения сертификатов для сайтов + корневой сертификат
    - docker
      - elasticsearch 
          - data
              - nodes
                  - 0 - `нулевая нода у эластики`
      - mysql1 - `Место хранения данных Mysql-master`
      - mysql2 - `Место хранения данных Mysql-slave`
      - postgres - `Место хранения данных Postgres`
      - redis - `Место хранения данных redis`
      - sock - `Место хранения unix-socket`

Для того чтобы базы данных подключились необходимо либо до Установки контейнеров, либо при выключенном контейнере добавить данные в нужную папку.
Этот способ не рекомендуется. Лучше воспользоваться средствами восстановления из бекапа!!!
Если не будет в наличии папок `elasticsearch`, `mysql1`, `mysql2`, `postgres`, `sock` - то при первом запуске контейнеров
они будут созданы. И в них появятся базы данных с настройками из файла .env

В контейнере Workplace /srv/scripts/certificate для создания ssl сертификата для сайта есть 2 скрипта
- create_root_ca.sh - создает корневой сертификат
- create_certifivate_for_domain.sh - создает сертификат для сайта, который используется в качестве параметра при запуске скрипта

`/srv/scripts/start.sh` - запускает их поочереди.

### Структура .env

>#### environment ################
|Параметр|Назначение|
|----|----|
|TIMEZONE=Europe/Moscow| Зона времени, устанавливаемая на все контейнеры |

>#### sites ######################
|Параметр|Назначение|
|----|----|
|SITES_ENABLED_PATH=./nginx/hosts| Место на хосте, где находятся конфигурационные файлы для папки sites-enabled Веб-сервера. |

Достаточно положить в эту папку новый, настроенный файл типа `newsite.loc.conf`,
в ./code создать новую директорию с кодом, 
установить в файле `hosts` связь доменного имени с localhost,
перезагрузить веб-сервер и готово. Можно пользоваться новым доменным именем `http://newsite.loc`

>#### IDE ########################
|Параметр|Назначение|
|----|----|
|PHP_IDE_CONFIG=serverName=Docker| Имя сервера в IDE, для режима пошаговой отладки x-debug, должно совпадать со значением в serverName |

>#### PATH ########################
|Параметр|Назначение|
|----|----|
|LOGS=./_logs| Корневая папка для хранения логов. Ее изменение переместит отображение всех логов в другое место |
|STORAGE=./ZoneForSTORAGE| Корневая папка для хранения данных контейнеров. Таких как базы данных и юникс сокета |
|CERTIFICATES=${STORAGE}/certificates| Местоположение ключей и сертификатов для сайтов |
|ADDITIONAL_CODE_PATH_HOST=c:/MyWork/School/Otus/HomeWork| Отдельная папка с кодом для сайта, код которого не располагается в стандартной папке проектов /code |
|ADDITIONAL_SITE_NAME=homework.otus| Имя сайта, которое будет использовано для ADDITIONAL_CODE_PATH_HOST. Так же его нужно настроить в хостах nginx |
|WORKSPACE_SCRIPTS_PATH_HOST=./workspace/scripts| Папка со скриптами на хосте |
|WORKSPACE_SCRIPTS_PATH_DOCKER=/srv/scripts| Папка со скриптами в контейнере |

>#### code #######################
|Параметр|Назначение|
|----|----|
|PHP_VERSION=8.0| версия PHP |
|APP_CODE_PATH_HOST=./code| Местоположение корневой папки с кодом проектов на хосте |
|APP_CODE_PATH_DOCKER=/var/www/html| Местоположение корневой папки с кодом проектов в контейнерах |
|PHP_ERROR_LOG_PATH=${LOGS}/php_errors/| Место складывания логов ошибок PHP |

>#### nginx ######################
|Параметр|Назначение|
|----|----|
|NGINX_LOG_PATH=${LOGS}/nginx| Место складывания логов webserver-а |
|NGINX_SSL_PATH_DOCKER=/etc/nginx/ssl| Папка с ключами и сертификатами в контейнере |

>#### x-debug
|Параметр|Назначение|
|----|----|
|X_DEBUG=1|при true или 1 включается x-debug|
|X_DEBUG_ERROR_LOG_PATH=${LOGS}/x-debug/| Место складывания логов x-Debug |

>#### memprof
|Параметр|Назначение|
|----|----|
|MEMPROF_PROFILE_ENABLE=1| только значение null отключает Memprof |
|MEMPROF_LOG_PATH_HOST=${LOGS}/memprof| путь для лога memprof на хосте |
|MEMPROF_LOG_PATH_DOCKER=/var/log/memprof/| путь для лога memprof в контейнере |

>#### unix socket
|Параметр|Назначение|
|----|----|
|UNIX_SOCKET_PATH_HOST=${STORAGE}/docker/sock| путь для файла сокета на хосте |
|UNIX_SOCKET_PATH_DOCKER=/sock| путь для файла сокета в контейнере |

>#### mysql-Master
|Параметр|Назначение|
|----|----|
|MYSQL_MASTER_DB=laravel| имя базы данных mysql-master |
|MYSQL_MASTER_ROOT_PASSWORD=password| пароль |
|MYSQL_MASTER_STORAGE_PLACE=${STORAGE}/docker/mysql1| путь к каталогу хранения данных |
|MYSQL_MASTER_LOG_PATH_HOST=${LOGS}/mysql/master| Место где можно смотреть логи на хосте |
|MYSQL_MASTER_LOG_PATH_DOCKER=/var/log/mysql/| Место хранения MySql логов в контейнере |
|MYSQL_SLAVE_CONFIG_PATH_HOST=./mysql/conf| Место хранения файла настроек MySql |

>#### mysql-Slave
|Параметр|Назначение|
|----|----|
|MYSQL_SLAVE_DB=laravel| имя базы данных mysql-slave |
|MYSQL_SLAVE_ROOT_PASSWORD=password| пароль |
|MYSQL_SLAVE_STORAGE_PLACE=${STORAGE}/docker/mysql2| путь к каталогу хранения данных |
|MYSQL_SLAVE_LOG_PATH_HOST=${LOGS}/mysql/master| Место где можно смотреть логи на хосте |
|MYSQL_SLAVE_LOG_PATH_DOCKER=/var/log/mysql/| Место хранения MySql логов в контейнере |
|MYSQL_SLAVE_CONFIG_PATH_HOST=./mysql/conf| Место хранения файла настроек MySql |

>#### postgres
|Параметр|Назначение|
|----|----|
|PGSQL_DB_NAME=postgres| имя базы данных Postgres - задается при создании контейнера, если базы нет |
|PGSQL_DB_USER=postgres| имя пользователя - задается при создании контейнера, если базы нет |
|PGSQL_DB_PASSWORD=password| пароль - задается при создании контейнера, если базы нет |
|PGSQL_STORAGE_PLACE=${STORAGE}/docker/postgres/data| путь к каталогу хранения данных |

>#### Redis
|Параметр|Назначение|
|----|----|
|REDIS_CONF=./redis/conf/redis/etc|местоположение конфигурационного файла redis|
|REDIS_DATA=${STORAGE}/docker/redis/data| путь к каталогу хранения данных |
|REDIS_LOG=${LOGS}/docker/redis/|  путь к каталогу логов |

>#### Elasticsearch
|Параметр|Назначение|
|----|----|
|ELASTICSEARCH_DATA=${STORAGE}/docker/elasticsearch/data| путь к каталогу хранения данных |
