## Вступление
Сервис актуализации информации о туре, предоставляет информацию о перелётах,
услугах, входящих в стоимость (виза, топливный сборы и прочие доплаты) на
текущий момент.  
От клиента приходит GET запрос с параметрами `int:operator` (идентификатор
туроператора в нашей системе поиска), `string:link` (ссылка полученная из поиска).
Ранее `int:tourId` (идентификатор тура в нашей системе поиска), ныне не используется.  
Возникла необходимость провести рефакторинг кода, так как код писался ещё под 
PHP 5.3 и со временем менялись разными программистами некоторые конструкции языка,
стандартные функции и всё это выросло в трудноподдерживаемого зверя.  
## План рефакторинга:
1. Переписать код, используя общепринятые практики, паттерны, в частности:
    - избавиться от самописного `spl_autoload_register` в пользу `composer autoload`
    - перейти на использование нэймспейсов
    - перенести настройки подключения к БД и другие в ENV (`htaccess`) из XML
2. В связи с прекращением работы класса Html парсинга SimpleHtmlDom для PHP > 7.1
перейти на `symfony/dom-crawler` 
3. Выпилить из кода самописную ООП обёртку для cURL 
(классы common/ HttpCurlRequest, HttpCurlRequestPull, HttpCurlResponse, 
HttpStatusCode). В качестве замены использовать `guzzlehttp/guzzle`.
4. Выпилить из кода самописный `DbLink` - обёртка для выполнения запросов к БД. 
Так как в приложении используются достаточно простые запросы – использовать PDO,
в `doctrine` необходимости нет никакой.  `<DbLink>` написан как реестр-синглтон,
то есть при инициализации без параметров использует текущее соединение с БД,
а передаче в конструктор `<DbConfig>` инициализирует новое соединение с заданными
настройками и сохраняет его как текущее, написан с использованием расшираения mysqli.
```
Сейчас вышеперечисленные пункты находятся на стадии реализации
``` 
- В продолжение необходимо подготовить следующие изменения:
    * Приложение будет работать в контейнере (подразумевается масштабирование и 
    как следствие перенос на другой сервер), в свзяи с этим необходимо запросы 
    к операторам проксировать (так как запросы должны приходить с определённого 
    _"разрешённого IP"_)
    * После _контейнеризации_ обновить версию PHP до 7.4 - произвести
    соответствующие изменения в коде.

## Реализация       
### Было:  
    before.png
в service.php приходит запрос вида  
`GET /getTourDetails?operator=<operatorId>&link=<urlencoded Url>&tourId=<id tour>`
Класс `<RestRequest>` занимается роутингом, вызовом метода контроллера,
является композицией сущностей `<RestResponse>` (ответ клиенту) и контроллера, храня
его сущность полученную при помощи магии (как и метод)
```php
private function query()
    {
        if (is_string($this->controller)) {
            $controllerClassName = $this->controller;
            $this->controller = new $controllerClassName();
        } else {
            throw new RestException(...);
        }
```
метод query() вызывается в конструкторе класса `<RestRequest>`,
`$controllerClassName` определяется исходя из настроек хранящихся в файле `rest.xml`
```xml
<RestRequest>
        <request>/getTourDetails</request>
        <controller>TourRestController</controller>
        <method>getTourDetails</method>
        <description>Возвращает дополненную информацию по туру.</description>
        <format>json</format>
    </RestRequest>
```

 TourRestController через фабричный метод 
`DetailsParser::getInstance()` нужного парсера, в зависимости от того, к 
какому оператору требуется сделать запрос на актуализацию. В парсер через конструктор
передаётся сущность `<Tour>`, хранящая в себе настройки запроса и сведения
об операторе.  
Контроллер последовательно вызывает методы парсера `queryOperator()` – запрос к 
шлюзу данных/странице сайта туроператора, `validateResponse()` – первичная
проверка корректности данных, полученных от туроператора (стоп-слова, наличие тэгов), 
`parseResponse()` – прасинг ответа, подготовка ожидаемого ответа для клиента в
`RestResponse::$result` – сущность `<Details>`
:)) Назвал бы этот паттерн «Чёртова петля», если когда-нибудь решу 
запатентовать название :)) 

### В процессе исправления ошибок своей неопытности
    after.png    
1. Настройки приложения вынесены в htaccess в дерективу SetEnv
    ```apacheconfig
    ...
    SetEnv APPLICATION_ENV <default: production>
    SetEnv db_link <for example: mysql://user:pass@host:3306/db_name?parameter[1..N]=value[1..N]>
    SetEnv air_company_thumbs_path <path to thumbnails *>
    SetEnv anticaptcha_url <*>
    SetEnv anticaptcha_key <*>
    ```
1. Классы разнесены по неймспейсам   
1. Реализовано использование `composer autoload` с корневым неймспейсом `App\` для
отделения кода vendor
    ```composer
        "autoload": {
            "psr-4": {
                "App\\": "src"
            }
        }
    ```
1. Организация объектов программы, их взаимодействие упорядоченно по слоям следующим
образом:   
    ***
    **Слой работы с запросом от клиента**   
    - Точка входа index.php 
    - Возможность запуска из командной строки (`cli.adapter.php`)
        ```php            
            $env = new \App\Core\Environment();
            $app = new \App\Core\Bootstrap($env);
            $app->run();
        ```     
    - Инициализируется объект, хранящий настройки приложения `<Environment>`:
    по-умолчанию настройки берутся из `getenv()`
    (для гибкости можно явно передавать массив настроек в констркутор `<Environment>`).
        ```php
          public function __construct(?array $env = null)
              {
                  $this->profile = $env['APPLICATION_ENV'] ??
                                   getenv('APPLICATION_ENV') ?: self::APP_ENV_PRODUCTION;
                  $this->link = $env['db_link'] ?? getenv('db_link') ?: '';
              }
        ```
    - `<Environment>` передаётся в программу.
    - `<Bootstrap>` – петля, хрнанит в себе объекты как реестр приложения, является
    композицией объектов классов `<Environment>`, `<PDO>` (для избежания повторной инициализации
    соединения с БД), `<Request>` (клиентский запрос) и `<Response>` 
    (подготовленный ответ сервиса клиенту).
        ```php
           public function run()
              {
                  $processor = new Processor($this);
                  $processor->validateRequest();
                  $processor->execute();
              }
        ```
    - Запуск приложение `<Bootstrap>->run();`
    ***
    **Слой приложения – обработки запроса**
    - Упарвление выполнением программы передаётся в `<Processor>`
    - Происходит маршрутизация запроса (роутинг)
    - Валидация запроса в соответсвие маршруту  
    - Обработка исключений уровня `AppException`
    _Обработчик запроса определяется в файле `config.routes.php`_ как метод 
    контроллера приложения, который передаётся лямбда функцией.
    Происходит инжектирование реестра `<Bootstrap>` через конструктор.
    В данном сервисе существует лишь один обработчик `<TourInfoController>->actualizeTour()`
        ```php
           if (!$this->router->handlerExists()) {
                       $this->errorClient(new Exception('handler not found', 404));
           
                }       
        ```
        ```php
               try {
                   $this->router->runHandler($this->app);
               } catch (AppException $e) {
                   $this->errorApp($e);
               }
               $this->app->getResponse()->flush();
        ```
    ***
    **Сервисный слой**
    - Контроллер создаёт сервис-контроллер , передаёт ему необходимые параметры,
    инжектит реестр через сеттер как необязательный (в ином случае возможно не 
    использовать бд, request и response для выполнения задачи).
    - Контроллер валидирует переданные параметры `validateRequest()` если требуется.  
    - Вызывается метод сервис-контроллера, в данном случае инициализируется 
    нужный парсер по средствам фабричного метода. 
    - Сервис возвращает в сервисный контроллер ожидаемый ответ в виде данных, либо
    кидает исключение перехватываемое вызвавшим сервис котнтроллером.
    - Обработка исключений уровня сервиса, в данном случае `<TourDetailsException>` 
    – проброс в контроллер обработки клиенсткого запроса.  
        ```php
              $operator = Operator::getById(
                          $this->app->getPdo(),
                          intval($_GET['operator'])
                      );
                      $queryData = new TourInfoQueryData($operator, $_GET['link']);
              
                      try {
                          return TourInfoParser::getParser($operator->getEngine())
                                               ->setQueryData($queryData)
                                               ->setApp($this->app)
                                               ->query()
                                               ->validateResponse()
                                               ->parseTourInfo();
                      } catch (TourDetailsException | SoapFault $e) {
                          throw new TourDetailsException(
                              TourDetailsException::NO_DATA_AVAILABLE
                          );
                      }
        ```
    Далее, контроллер приложения (обработчик клиентского запроса), получая ответ в виде
    ожидаемых данных (в моём случае `<TourInfo>` сведения о туре)  или ловя исключения
    формирует ответ `<Bootstrap>::<Response>` 
        ```
        
             try {
                  $details = (new TourInfoService())->setApp($this->app)
                                                                  ->validateRequest()
                                                                  ->actualizeTour();
                  $this->app->getResponse()->setBody(
                                    json_encode(
                                        ['result' => $details->fetch(), 'error' => false],
                                        JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE
                                    )
                                );
             } catch (TourDetailsException $err) {
                   // todo: тута можно логировать
                   $this->app->getResponse()->setBody(
                               json_encode(
                                        [
                                            'result' => null,
                                            'error'  => $err->fetch(),
                                        ],
                                        JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE
                                    )
                                )->setStatusCode(200);
                   }
                            
        ```   
    Ошибки уровня `<TourDetailsException>` можно логировать в зависимости от кода. 
1. Сущности требующиеся в ответе JSON реализуют интерфейс IEntity
    ```php
       public function fetch(): array;
    ```
1. Замена самописного DbLink на PDO (сущности Entity требующие данные из БД)

    ### В процессе
1. Замена самописного CurlRequest библиотекой `guzzlehttp/guzzle` в парсерах
1. Замена неработающей библиотеки SimpleHtmlDom на `symfony/dom-crawler` и
`symfony/css-selector`
    ### Предстоит
1. Избавиться от конструкции $_SERVER['DOCUMENT_ROOT'], проверять наличие картинки
    (логотипы авиакомпаний) по HTTP, так как файловая система, где хрантся эти
    картинки будет недоступна контейнеру
1. Проксирование запросов (необходимость)
1. Логику работы парсеров стараюсь не трогать и не менять. Но очень длинные классы
нужно тоже как-то реорганизовать (удобство)
1. Обвязка тестами с использованием мока (должно быть) 