## Настройки репозитория

Реализованы 3 вида хранилищ.
- **mysql (eloquent)**
- **redis**
- **elasticsearch**

Для выбора хранилища необходимо в `.env` установить параметр 
- `EVENTS_REPOSITORY = eloquent` для Mysql
- `EVENTS_REPOSITORY = redis` для Redis
- `EVENTS_REPOSITORY = elasticsearch` для ElasticSearch

по умолчанию используется MySql. 
## Заполнение данными

>Для наполнения базы MySql используется консольная команда: php artisan db:seed --class=EventSeeder
или в адресной строке браузера http://project_name/event/seedMysql

>Для наполнения базы Redis или ElasticSearch используется http://project_name/event/seedNosql

Имена событий в базе уникальные

>добавление одной записи:
http://project_name/event/create?create?name=EventName-777&priority=10&param1=10&param5=15

>Удаление одной записи:
http://project_name/event/delete/EventName-777

>Очистка всего хранилища:
http://project_name/event/clear

## Поиск

>Показать все события:
http://project_name/event/showAll

>Показать события по условию:
http://project_name/event?q=param4=10,%20param2=7
> 
> Или в поисковой строке http://project_name внести значение параметров:
> `param4=10, param2=7` <a href="">search</a>


### Пример
создание 4х событий
>http://project_name/event/create?name=NewEvent-1&priority=1&param1=1
> 
>http://project_name/event/create?name=NewEvent-2&priority=2&param1=1&param2=2
> 
>http://project_name/event/create?name=NewEvent-3&priority=3&param1=2&parpa2=2
> 
>http://project_name/event/create?name=NewEvent-4&priority=4&param1=1

поиск
>http://project_name/event?q=param1=1,param2=2

результат: `NewEvent-4`
>http://project_name/event?q=param1=2,param2=2

результат: `NewEvent-2`

## Структура проекта:
>`routes/web.php`
обработка маршрутов

>`app/Http/Controllers/EventController.php`
контроллер для маршрутов /event

>`app/Providers/AppServiceProvider.php` 
связывание интерфейсов с классом реализации

> `App\Services\Event\Repositories\`
Репозитории
> 
> `App\Services\Event\Repositories\Elastic;`
Реализация хранилища Эластики
> 
> `App\Services\Event\Repositories\Eloquent` 
Реализация хранилища Mysql
> 
> `App\Services\Event\Repositories\Redis`
Реализация хранилища Redis
> 
> `app/Services/Event/Repositories/ISearchEventRepository.php`
Интерфейс для поиска в хранилищах
> 
> `app/Services/Event/Repositories/IWriteEventRepository.php`
Интерфейс для записи в хранилищах
> 
> `app/Services/Event/EventService.php`
> Сервис для обращения к методам хранилищ через интерфейсы

> `resources/views/Events/`
Представления для событий
