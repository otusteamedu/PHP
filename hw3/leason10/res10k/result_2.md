## Значения аттрибута, начинающегося на букву `D`

Исходный запрос:
````sql
select * from attr_values where attr_value like 'D%';
````

План выполнения:
````sql
QUERY PLAN                                                    |
--------------------------------------------------------------|
Seq Scan on attr_values  (cost=0.00..199.00 rows=202 width=28)|
  Filter: (attr_value ~~ 'D%'::text)                          |
````

Построим полный индекс и посмотрим план выполнения:
````sql
create index attr_values_value on attr_values (attr_value);

explain select * from attr_values where attr_value like 'D%';

QUERY PLAN                                                    |
--------------------------------------------------------------|
Seq Scan on attr_values  (cost=0.00..199.00 rows=202 width=28)|
  Filter: (attr_value ~~ 'D%'::text)                          |
````
Видим, что все так же используется полный перебор всей таблицы, но после добавления сортировки в запрос, план выполнения меняется:
````sql
select * from attr_values where attr_value like 'D%' order by attr_value;

QUERY PLAN                                                          |
--------------------------------------------------------------------|
Sort  (cost=206.73..207.24 rows=202 width=28)                       |
  Sort Key: attr_value                                              |
  ->  Seq Scan on attr_values  (cost=0.00..199.00 rows=202 width=28)|
        Filter: (attr_value ~~ 'D%'::text)                          |
````

Добавление частичного индекса, существенно не изменило время выполнения запрос:
````sql
select * from attr_values where attr_value like 'D%' order by attr_value;
176 rows retrieved starting from 1 in 22 ms (execution: 3 ms, fetching: 19 ms)

create index attr_values_value_d on attr_values (attr_value) where attr_value like 'D%';
explain select * from attr_values where attr_value like 'D%' order by attr_value;
QUERY PLAN                                                                              |
----------------------------------------------------------------------------------------|
Sort  (cost=93.34..93.84 rows=202 width=28)                                             |
  Sort Key: attr_value                                                                  |
  ->  Bitmap Heap Scan on attr_values  (cost=9.08..85.60 rows=202 width=28)             |
        Recheck Cond: (attr_value ~~ 'D%'::text)                                        |
        ->  Bitmap Index Scan on attr_values_value_d  (cost=0.00..9.03 rows=202 width=0)|

select * from attr_values where attr_value like 'D%' order by attr_value
176 rows retrieved starting from 1 in 29 ms (execution: 3 ms, fetching: 26 ms)
````
