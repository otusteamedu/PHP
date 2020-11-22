## Сеансы, начинающиеся после 01 декабря 2020

Исходный запрос:
````sql
select * from seanse where start_show >= '2020-12-01 09:00:00';

500 rows retrieved starting from 1 in 58 ms (execution: 9 ms, fetching: 49 ms)
````

План выполнения:
````sql
QUERY PLAN                                                                  |
----------------------------------------------------------------------------|
Seq Scan on seanse  (cost=0.00..19.50 rows=760 width=20)                    |
  Filter: (start_show >= '2020-12-01 09:00:00'::timestamp without time zone)|
````

Создадим полный индекс для поля `start_now`
````sql
create index seanse_start_show on seanse (start_show);

QUERY PLAN                                                                  |
----------------------------------------------------------------------------|
Seq Scan on seanse  (cost=0.00..19.50 rows=760 width=20)                    |
  Filter: (start_show >= '2020-12-01 09:00:00'::timestamp without time zone)|
````

Видим, что без сортировки индекс не применяется. Добавим сортировку:
````sql
explain select * from seanse where start_show >= '2020-12-01 09:00:00' order by start_show;

QUERY PLAN                                                                        |
----------------------------------------------------------------------------------|
Index Scan using seanse_start_show on seanse  (cost=0.28..57.56 rows=760 width=20)|
  Index Cond: (start_show >= '2020-12-01 09:00:00'::timestamp without time zone)  |
````

При этом увеличилось время выполнения запроса c 9 до 11 ms:
````sql
select * from seanse where start_show >= '2020-12-01 09:00:00' order by start_show;
500 rows retrieved starting from 1 in 48 ms (execution: 11 ms, fetching: 37 ms)
````

Добавление частичного индекса не дает ни какого эффекта:
````sql
create index seanse_start_show_december on seanse (start_show) where start_show >= '2020-12-01 09:00:00';

QUERY PLAN                                                                        |
----------------------------------------------------------------------------------|
Index Scan using seanse_start_show on seanse  (cost=0.28..57.56 rows=760 width=20)|
  Index Cond: (start_show >= '2020-12-01 09:00:00'::timestamp without time zone)  |
````