### Принцип заполнения БД
* Все данные заполняются статично до опделённого количества (фильмы, покупатели, залы, места)
* Данные по сеансам, билетам и ценам на места заполняются при запуске функции `fill_seances_fake_data(n)`
* Количество записей в таблице сеансов (seances) = n
* Количество записей в таблице цен на места (seats_price) = n * 3
* Количество записей в таблице билетов (tickets) = n * 30

### Количество записей на 10к
schemaname|relname           |count     |
----------|------------------|----------|
public    |tickets           |    300000|
public    |seats_price       |     30000|
public    |seances           |     10000|
public    |seats             |       200|
public    |customers         |       100|
public    |movies            |        38|
public    |movie_attrs_values|        33|
public    |movie_attrs       |        12|
public    |movie_attrs_types |         6|
public    |halls             |         5|
public    |seats_type        |         3|

### Количество записей на 1кк

schemaname|relname           |n_live_tup|
----------|------------------|----------|
public    |tickets           |  30000000|
public    |seats_price       |   3000000|
public    |seances           |   1000000|
public    |seats             |       200|
public    |customers         |       100|
public    |movies            |        38|
public    |movie_attrs_values|        33|
public    |movie_attrs       |        12|
public    |movie_attrs_types |         6|
public    |halls             |         5|
public    |seats_type        |         3|

### Ссылка на результаты и статистику
* [Ссылка на google таблицу c возможностью комментировать](https://docs.google.com/spreadsheets/d/1SPnpGzab9gvDLUZ2ZauQfqpQLtyPY4YmuRL_zM19TS8/edit?usp=sharing)

### Пояснения
* Настройки брались с рекомендации на [pgtune](https://pgtune.leopard.in.ua/#/)
* Для оптимизации в настройках бд выставлены были следующие параметры:
```
random_page_cost=1.1
default_statistics_target=100
effective_io_concurrency=200
shared_buffers=500MB
work_mem=32MB
maintenance_work_mem=1GB
effective_cache_size=11GB
max_worker_processes=14
max_parallel_workers_per_gather=4
max_parallel_workers=14
max_parallel_maintenance_workers=4
```
* Так же были созданы различные индексы из которых большая часть оказалась не нужна для текущих запросов
* Для улучшения результатов можно ещё создать таблицы, куда скидывать уже готовые данные, как аналитические или использовать другие бд, например Elastic