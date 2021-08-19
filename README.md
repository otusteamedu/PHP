# Домашняя работа № 5

## Часть 1 - Docker-Balancer
____
### Набор контейнеров для работы
| Обозначение | Путь к dockerfile | Описание |
|----|:----:|:----|
| `>app-1`| ./fpm | 1й контейнер исполнения скриптов |
| `>app-2`| ./fpm | 2й контейнер исполнения скриптов |
| `>workspace` | ./workspace | контейнер для выполнения служебных функций (composer, npm и т.д)  |
| `>webserver`| ./nginx | webserver проекта |
| `>memcached-1`| ./memcached | 1й контейнер, где крутиться memcached |
| `>memcached-2`| ./memcached | 2й контейнер, где крутиться memcached |

### Назначение папок
- code (Место расположения исполняемого кода)
    - [application.loc](./code/application.loc) - код для сайта application.loc
- log (Логи)
    - [memprof](log/memprof) - путь сохранения в проекте для данных из memprof берется из `$_SERVER['MEMPROF_LOG_PATH']`
  ```
   Используется в коде например так:
   $memprofPath = $_SERVER['MEMPROF_LOG_PATH'];
   memprof_dump_callgrind(fopen($memprofPath."memprof_logs.out", "w"));
  ```
    - [php_errors](log/php_errors) - расположение логов ошибок PHP
    - [xdebug](log/x-debug) - расопложение логов x-debug
- ZoneForSTORAGE->docker (Хранение данных)
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

>#### memCached
|Параметр|Назначение|
|----|----|
|MEMCACHED_CLUSTER=1| включает использование кластера |
|MEMCACHED_USE_SESSION=1| включает использование MemCached в качестве хранения сессий |

## Часть 2 - Верификация Email

### Структура
1. [app](app) - 
    1. [Exceptions](app/Exceptions) - Исключения проекта
    2. [Http](app/Http) - Контроллеры, посредники, запросы, системная информация
    3. [Logger](app/Logger) - Классы реализующие логирование
    4. [Services](app/Services) - Сервисный функционал
        1. [Validators](app/Services/Validators) - различные валидаторы в проекте
            1. [EmailValidator](app/Services/Validators/Email/EmailValidator.php) - класс валидации почтовых ящиков
        2. [AbstractValidator](app/Services/Validators/AbstractValidator.php) - базовый класс всех Валидаторов. Требует реализации методов
           >`abstract public function setDataToValidate(array $data): void;` - устанавливает данные для проверки
           
           >`abstract protected function isValidItem(string $item): bool;` - проверяет, является ли элемент валидным
           
           На их основе реализован базовый публичный метод валидации.
           >`public function validate(): array` - производит проверку элементов установленных в свойстве `protected array $ItemsList;`
           
           Если нужно, в дочерних классах его можно переопределить. 
        3. [ValidatorFactory](app/Services/Validators/ValidatorFactory.php) - фабрика создания Валидаторов. Используется параметр тип валидатора для создания конкретного Валидатора. 
           
           Реализован только [EmailValidator](app/Services/Validators/Email/EmailValidator.php) - класс валидации Email-ов. Можно дополнить любой другой валидацией. Например, имен пользователей, их паролей и т.д.
    5. [start.php](app/start.php) - точка входа в приложение
2. [bootstrap](bootstrap) - начальная загрузка используемых библиотек (dotenv)
3. [public](public) - место, куда попадает запрос
4. [composer.json](composer.json) - файл зависимостей для проекта и автозагрузкой по стандарту PSR-4
5. [.env.example](.env.example) - параметры используемые в проекте

### Требования
1. PHP >=8.0
2. Composer

### Используются библиотеки
1. "vlucas/phpdotenv": "^5.1",
2. "monolog/monolog": "2.x-dev"

### Структура .env

>#### environment
|Параметр|Назначение|
|----|----|
|EMAIL_VALIDATOR=Email| Наименование Валидатора для Email |

>#### Sites
|Параметр|Назначение|
|----|----|
|LOG_PATH=application.log| Место хранения логов приложения |
