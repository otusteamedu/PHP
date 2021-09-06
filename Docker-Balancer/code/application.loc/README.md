# Описание приложения Checkers

### Требования
1. PHP >=8.0
2. Composer
3. Набор серверов (установленные сервера Mysql, Postgres, MemCached, Redis? Elasticsearch)

### Используются библиотеки
1. "vlucas/phpdotenv": "^5.1",
2. "monolog/monolog": "2.x-dev"
3. "elasticsearch/elasticsearch": "~7.0"

### Запуск
1. Используя браузер необходимо в адресной строке ввести путь http://application.loc
В приложении использованы как вывод информации, сформированной на сервере, так и Ajax запросы (кирпичного цвета кнопки на главной странице).
Если параметр MEMCACHED_CLUSTER установлен в true, то в разделе NoSql->MemcahcedCluser можно протестировать репликацию обоих серверов.
2. В режиме cli для запуска используется файл 'App/Console/checker.php'
    >php App/Console/checker.php параметр1 параметр2 
   
   параметр1 - используется для выбора проверяемого сервера
   параметр2 - драйвер для серверов mysql и postgres

   Возможны следующие варианты выбора параметров
    1. checker.php elasticsearch - запускает проверку Elasticsearch
    2. checker.php redis - запускает проверку Redis
    3. checker.php memcached - запускает проверку Memcached
    4. checker.php mysql mysqli - запускает проверку Mysql с драйвером mysqli
    5. checker.php mysql pdo - запускает проверку Mysql с драйвером PDO
    6. checker.php postgres pdo - запускает проверку Postgres с драйвером PDO
    7. checker.php postgres pg_connect - запускает проверку Postgres с драйвером pg_connect
    8. checker.php sysinfo - выводи системную информацию.
    
### Структура
1. [App](App) - основной код проекта
    1. [Exceptions](App/Exceptions) - Исключения проекта
    2. [Helpers](App/Helpers) - Хелперы используемые в проекте
    3. [Http](App/Http) - Контроллеры (путь настраивается в .env в параметре CONTROLLERS_BASE_PATH), посредники, запросы, системная информация
    4. [Logger](App/Logger) - Классы реализующие логирование
    5. [Models](App/Models) - Модели
    6. [Services](App/Services) - Сервисный функционал
        1. [Checkers](App/Services/Checkers) - различные Чекеры в проекте
            1. [NoSql](App/Services/Checkers/NoSql) - Nosql чекеры
                1. [ElasticSearchChecker.php](App/Services/Checkers/NoSql/ElasticsearchChecker.php) - чекер для проверки работы Elasticsearch
                2. [MemcachedChecker.php](App/Services/Checkers/NoSql/MemcachedChecker.php) - чекер для проверки работы Memcached
                3. [RedisChecker](App/Services/Checkers/NoSql/RedisChecker.php) - чекер для проверки работы Redis
            2. [Sql](App/Services/Checkers/Sql) - Sql чекеры
                1. [Mysql](App/Services/Checkers/Sql/Mysql) - чекеры для mysql
                    1. [MySqlPdoChecker.php](App/Services/Checkers/Sql/Mysql/MysqlPdoChecker.php) - чекер для проверки сервера Mysql с драйвером PDO
                    2. [MySQLiteChecker.php](App/Services/Checkers/Sql/Mysql/MySQLiteChecker.php) - чекер для проверки сервера Mysql с драйвером Mysqli
                2. [Postgres](App/Services/Checkers/Sql/Postgres) - чекеры для postgres
                    1. [PostgresPdoChecker.php](App/Services/Checkers/Sql/Postgres/PostgresPdoChecker.php) чекер для проверки сервера Postgres с драйвером PDO
                    2. [Postgres](App/Services/Checkers/Sql/Postgres/PostgresPgConnectChecker.php) - чекер для проверки сервера Postgres с драйвером PgConnect
            3. [SysInfo](App/Services/Checkers/Sysinfo)
            4. [AbstractChecker](App/Services/Checkers/AbstractChecker.php) - базовый класс всех Чекеров. Требует реализации методов
               >`abstract public function check(): self;` -запускает проверку

            5. [CheckerFactory](App/Services/Checkers/CheckersFactory.php) - фабрика чекеров
            6. [ErrorChecker](App/Services/Checkers/ErrorChecker.php) - Класс, который подставляется в качестве чекера, в случае возникновения ошибки
            7. [Inspector](App/Services/Checkers/Inspector.php)
    7. [start.php](App/start.php) - точка входа в приложение
2. [assets](assets) - настройки для фронта
3. [bootstrap](bootstrap) - начальная загрузка используемых библиотек (dotenv)
4. [images](images) - картинки используемые в проекте
5. [log](log) - местоположение логов проекта (путь настраивается в .env в параметре APP_LOG_PATH)
6. [public](public) - место, куда попадает запрос
7. [resource](resources) - ресурсы проекта
    1. [Views](resources/Views) - представления (путь настраивается в .env в параметре VIEW_BASE_PATH)
        1. [Default](resources/Views/Default) - набор файлов для представления для контроллера Default
        2. [Memcached](resources/Views/Memcached) - набор файлов для представления для контроллера Memcached/Cluster
        3. [NoSql](resources/Views/NoSql) - набор файлов для представления для контроллера NoSql
        4. [Sql](resources/Views/Sql) - набор файлов для представления для контроллера Sql
        5. [Sysinfo](resources/Views/Sysinfo) - набор файлов для представления для контроллера Sysinfo
        6. [Templates](resources/Views/Templates) - шаблоны header и footer

8. [routes](routes) - маршруты (реализован один класс Router, который определяет имя контроллера)
9. [src](src) - sources
    1. [Database](src/Database) - базы данных
        1. [Connectors](src/Database/Connectors) - классы реализующие соединения с базами данных
            1. [IConnector.php](src/Database/Connectors/IConnector.php) - интерфейс реализующий DIP принцип для классов соединения
            2. [Connector.php](src/Database/Connectors/Connector.php) - абстракция для всех коннекторов реализующий принцип LSP
            3. [ElasticsearchConnector](src/Database/Connectors/ElasticsearchConnector.php) - коннектор к эластике
            4. [MemcachedConnector](src/Database/Connectors/MemcachedConnector.php) - коннектор к мемкеш
            5. [MySQLiteConnector](src/Database/Connectors/MySQLiteConnector.php) - коннектор Mysql для драйвера Mysqli
            6. [MySqlPdoConnector](src/Database/Connectors/MySqlPdoConnector.php) - коннектор Mysql для драйвера PDO
            7. [PostgresPdoConnector](src/Database/Connectors/PostgresPdoConnector.php) - коннектор Postgres для драйвера PDO
            8. [PostgresPgConnect](src/Database/Connectors/PostgresPdoConnector.php) - коннектор Postgres для драйвера PgConnect
            9. [Redis](src/Database/Connectors/RedisConnector.php) - Коннектор Redis
        2. [Traits](src/Database/Traits) - трейты для коннекторов
10. [composer.json](composer.json) - файл зависимостей для проекта и автозагрузкой по стандарту PSR-4
11. [.env.example](.env.example) - параметры используемые в проекте

### Структура .env

>#### path
|Параметр|Назначение|
|----|----|
|CONTROLLERS_BASE_PATH| Базовый каталог, где хранятся контроллеры |
|VIEW_BASE_PATH| Базовый каталог, где хранятся представления |
|APP_LOG_PATH| Каталог размещения логов |

>#### framework
|Параметр|Назначение|
|----|----|
|DEFAULT_CONTROLLER_NAME| Имя контроллера по умолчанию |
|DEFAULT_CONTROLLER_METHOD| Имя метода по умолчанию вызываемого в контроллера |
|DEFAULT_SCRIPT_NAME| Имя скрипта, которое используется системой (index.php) |
|DEFAULT_VIEW_NAME| Имя файла, которое используется в качестве загружаемого в виде представления по умолчанию (index.php) |

>#### mysql
|Параметр|Назначение|
|----|----|
|MYSQL_DRIVER| драйвер используемый для подключения через PDO |
|MYSQLITE_DRIVER| драйвер используемый для подключения через mysqlite |

>#### mysql-Master
|Параметр|Назначение|
|----|----|
|MYSQL_MASTER_HOST| имя сервера для базы данных mysql-master |
|MYSQL_MASTER_PORT| номер порта |
|MYSQL_MASTER_DB| Имя базы данных |
|MYSQL_MASTER_USER| Имя пользователя для подключения |
|MYSQL_MASTER_PASSWORD| Пароль для пользователя |

>#### mysql-Slave
|Параметр|Назначение|
|----|----|
|MYSQL_SLAVE_HOST| имя сервера для базы данных mysql-slave |
|MYSQL_SLAVE_PORT| номер порта |
|MYSQL_SLAVE_DB| Имя базы данных |
|MYSQL_SLAVE_USER| Имя пользователя для подключения |
|MYSQL_SLAVE_PASSWORD| Пароль для пользователя |

>#### postgres
|Параметр|Назначение|
|----|----|
|PGSQL_DB_HOST| имя сервера для базы данных postgres |
|PGSQL_DB_PORT| номер порта |
|PGSQL_DB_NAME| Имя базы данных |
|PGSQL_DB_USER| Имя пользователя для подключения |
|PGSQL_DB_PASSWORD| Пароль для пользователя |
|PGSQL_DRIVER| драйвер используемый для подключения через PDO (pgsql)|
|PGSQL_PG_DRIVER| драйвер используемый для подключения через pg_connect (pg_connect) |

>#### redis
|Параметр|Назначение|
|----|----|
|REDIS_HOST| имя сервера для базы данных redis |
|REDIS_PORT| номер порта |
|REDIS_TIMEOUT| timeout |
|REDIS_RESERVED| reserved |
|REDIS_RETRY_INTERVAL| интервал повторений |
|REDIS_READ_TIMEOUT| timeout на чтение|

>#### memcached
|Параметр|Назначение|
|----|----|
|MEMCACHED_HOST| имя сервера при использовании одиночного сервера memcached |
|MEMCACHED_PORT| порт |
|MEMCACHED_CLUSTER| использование кластера серверов |
|MEMCACHED_1_HOST| имя 1-го сервера |
|MEMCACHED_1_PORT| порт 1-го сервера |
|MEMCACHED_2_HOST| имя 2-го сервера |
|MEMCACHED_2_PORT| порт 2-го сервера |
|MEMCACHED_DRIVER| какой клиент используется (memcached или memcache) |

>#### elasticsearch
|Параметр|Назначение|
|----|----|
|ELASTICSEARCH_HOST| имя сервера Elasticsearch |
|ELASTICSEARCH_PORT| порт |
|ELASTICSEARCH_DRIVER| драйвер использования |
