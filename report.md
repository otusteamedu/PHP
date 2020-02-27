# Планы выполнения

План выполнения при объеме данных 10 000 записей и 10 000 000 записей в таблице `attribute_value`.

## До оптимизации
№ | Запрос | План выполнения при 10K | План выполнения при 10M
--- | ---  | --- | ---
1|`EXPLAIN SELECT * FROM attribute_value;`|Seq Scan on attribute_value  (cost=0.00..170.00 rows=10000 width=46)|Seq Scan on attribute_value  (cost=0.00..169805.46 rows=10005746 width=45)
2|`EXPLAIN INSERT INTO attribute_value (attribute_id, film_id, val_bool) VALUES (8, 12, TRUE);`|Insert on attribute_value  (cost=0.00..0.01 rows=1 width=81)<br /> ->  Result  (cost=0.00..0.01 rows=1 width=81)|Insert on attribute_value  (cost=0.00..0.01 rows=1 width=81)<br />  ->  Result  (cost=0.00..0.01 rows=1 width=81)
3|`EXPLAIN DELETE FROM attribute_value WHERE id > 4000;`|Delete on attribute_value  (cost=0.00..195.00 rows=6000 width=6)<br />  ->  Seq Scan on attribute_value  (cost=0.00..195.00 rows=6000 width=6)<br /> Filter: (id > 4000)|Delete on attribute_value  (cost=0.00..194819.83 rows=10002145 width=6)<br />  ->  Seq Scan on attribute_value  (cost=0.00..194819.83 rows=10002145 width=6)<br />        Filter: (id > 4000)<br />JIT:<br />  Functions: 3<br />  Options: Inlining false, Optimization false, Expressions true, Deforming true
4|`EXPLAIN SELECT av.*, film."name" FROM attribute_value av INNER JOIN film ON av.film_id = film.id WHERE film.id = 2;`|Nested Loop  (cost=0.14..208.35 rows=519 width=562)<br />  ->  Index Scan using film_pk on film  (cost=0.14..8.16 rows=1 width=520)<br />        Index Cond: (id = 2)<br />  ->  Seq Scan on attribute_value av  (cost=0.00..195.00 rows=519 width=46)<br />        Filter: (film_id = 2)|Nested Loop  (cost=1000.14..181899.93 rows=536641 width=561)<br />  ->  Index Scan using film_pk on film  (cost=0.14..8.16 rows=1 width=520)<br />        Index Cond: (id = 2)<br />  ->  Gather  (cost=1000.00..176525.36 rows=536641 width=45)<br />        Workers Planned: 2<br />        ->  Parallel Seq Scan on attribute_value av  (cost=0.00..121861.26 rows=223600 width=45)<br />              Filter: (film_id = 2)<br />JIT:<br />  Functions: 6<br />  Options: Inlining false, Optimization false, Expressions true, Deforming true
5|`EXPLAIN SELECT * FROM attribute_value av INNER JOIN film ON av.film_id = film.id;`|Hash Join  (cost=13.15..210.19 rows=10000 width=598)<br />  Hash Cond: (av.film_id = film.id)<br />  ->  Seq Scan on attribute_value av  (cost=0.00..170.00 rows=10000 width=46)<br />  ->  Hash  (cost=11.40..11.40 rows=140 width=552)<br />        ->  Seq Scan on film  (cost=0.00..11.40 rows=140 width=552)|Hash Join  (cost=13.15..196878.80 rows=10005746 width=597)<br />  Hash Cond: (av.film_id = film.id)<br />  ->  Seq Scan on attribute_value av  (cost=0.00..169805.46 rows=10005746 width=45)<br />  ->  Hash  (cost=11.40..11.40 rows=140 width=552)<br />        ->  Seq Scan on film  (cost=0.00..11.40 rows=140 width=552)<br />JIT:<br />  Functions: 10<br />  Options: Inlining false, Optimization false, Expressions true, Deforming true
6|`EXPLAIN SELECT av.film_id, SUM(av.val_numeric) FROM attribute_value av WHERE av.film_id = 10 GROUP BY (av.film_id);`|GroupAggregate  (cost=0.00..197.87 rows=20 width=36)<br />  Group Key: film_id<br />  ->  Seq Scan on attribute_value av  (cost=0.00..195.00 rows=523 width=10)<br />        Filter: (film_id = 10)|Finalize GroupAggregate  (cost=1000.00..124010.47 rows=20 width=36)<br />  Group Key: film_id<br />  ->  Gather  (cost=1000.00..124009.92 rows=40 width=36)<br />        Workers Planned: 2<br />        ->  Partial GroupAggregate  (cost=0.00..123005.92 rows=20 width=36)<br />              Group Key: film_id<br />              ->  Parallel Seq Scan on attribute_value av  (cost=0.00..121861.26 rows=228881 width=10)<br />                    Filter: (film_id = 10)<br />JIT:<br />  Functions: 10<br />  Options: Inlining false, Optimization false, Expressions true, Deforming true

## Проведенные меры оптимизации

Из всех опробованных методов успешным оказался только создание индекса по полю `film_id` таблицы `attribute_value`. По указанному полю происходит объединение в запросах 4, 5, а также задано условие по этому полю в запросе 6. Поэтому считаю, что создание такого индекса может дать прирост производительности для запросов 4, 5, 6.

## После оптимизации

План выполнения при объеме данных 10 000 000 записей в таблице `attribute_value`.

№ | Запрос | План до оптимизации | План после оптимизации
--- | ---  | --- | ---
4|`EXPLAIN SELECT av.*, film."name" FROM attribute_value av INNER JOIN film ON av.film_id = film.id WHERE film.id = 2;`|Nested Loop  (cost=1000.14..181899.93 rows=536641 width=561)<br />  ->  Index Scan using film_pk on film  (cost=0.14..8.16 rows=1 width=520)<br />        Index Cond: (id = 2)<br />  ->  Gather  (cost=1000.00..176525.36 rows=536641 width=45)<br />        Workers Planned: 2<br />        ->  Parallel Seq Scan on attribute_value av  (cost=0.00..121861.26 rows=223600 width=45)<br />              Filter: (film_id = 2)<br />JIT:<br />  Functions: 6<br />  Options: Inlining false, Optimization false, Expressions true, Deforming true|Nested Loop  (cost=9808.41..154150.77 rows=523333 width=561)<br />  ->  Index Scan using film_pk on film  (cost=0.14..8.16 rows=1 width=520)<br />        Index Cond: (id = 2)<br />  ->  Bitmap Heap Scan on attribute_value av  (cost=9808.27..148909.28 rows=523333 width=45)<br />        Recheck Cond: (film_id = 2)<br />        ->  Bitmap Index Scan on av_film_id_index  (cost=0.00..9677.43 rows=523333 width=0)<br />              Index Cond: (film_id = 2)<br />JIT:<br />  Functions: 7<br />  Options: Inlining false, Optimization false, Expressions true, Deforming true
5|`EXPLAIN SELECT * FROM attribute_value av INNER JOIN film ON av.film_id = film.id;`|Hash Join  (cost=13.15..196878.80 rows=10005746 width=597)<br />  Hash Cond: (av.film_id = film.id)<br />  ->  Seq Scan on attribute_value av  (cost=0.00..169805.46 rows=10005746 width=45)<br />  ->  Hash  (cost=11.40..11.40 rows=140 width=552)<br />        ->  Seq Scan on film  (cost=0.00..11.40 rows=140 width=552)<br />JIT:<br />  Functions: 10<br />  Options: Inlining false, Optimization false, Expressions true, Deforming true|Hash Join  (cost=13.15..196808.80 rows=10000000 width=597)<br />  Hash Cond: (av.film_id = film.id)<br />  ->  Seq Scan on attribute_value av  (cost=0.00..169751.00 rows=10000000 width=45)<br />  ->  Hash  (cost=11.40..11.40 rows=140 width=552)<br />        ->  Seq Scan on film  (cost=0.00..11.40 rows=140 width=552)<br />JIT:<br />  Functions: 10<br />  Options: Inlining false, Optimization false, Expressions true, Deforming true
6|`EXPLAIN SELECT av.film_id, SUM(av.val_numeric) FROM attribute_value av WHERE av.film_id = 10 GROUP BY (av.film_id);`|Finalize GroupAggregate  (cost=1000.00..124010.47 rows=20 width=36)<br />  Group Key: film_id<br />  ->  Gather  (cost=1000.00..124009.92 rows=40 width=36)<br />        Workers Planned: 2<br />        ->  Partial GroupAggregate  (cost=0.00..123005.92 rows=20 width=36)<br />              Group Key: film_id<br />              ->  Parallel Seq Scan on attribute_value av  (cost=0.00..121861.26 rows=228881 width=10)<br />                    Filter: (film_id = 10)<br />JIT:<br />  Functions: 10<br />  Options: Inlining false, Optimization false, Expressions true, Deforming true|Finalize GroupAggregate  (cost=11110.85..110926.76 rows=20 width=36)<br />  Group Key: film_id<br />  ->  Gather  (cost=11110.85..110926.21 rows=40 width=36)<br />        Workers Planned: 2<br />        ->  Partial GroupAggregate  (cost=10110.85..109922.21 rows=20 width=36)<br />              Group Key: film_id<br />              ->  Parallel Bitmap Heap Scan on attribute_value av  (cost=10110.85..108797.66 rows=224861 width=10)<br />                    Recheck Cond: (film_id = 10)<br />                    ->  Bitmap Index Scan on av_film_id_index  (cost=0.00..9975.94 rows=539667 width=0)<br />                          Index Cond: (film_id = 10)<br />JIT:<br />  Functions: 10<br />  Options: Inlining false, Optimization false, Expressions true, Deforming true

## Таблица самых больших по размеру объектов

schema_name|object|size
---|---|---
public|attribute_value|545 MB
public|av_film_id_index|215 MB
public|attribute_value_pk|214 MB
information_schema|sql_features|64 kB
public|attribute_type_pk|16 kB
public|attribute_pk|16 kB
public|film_pk|16 kB
public|attribute_type_id_seq|8192 bytes
public|attribute|8192 bytes
information_schema|sql_packages|8192 bytes
public|film|8192 bytes
public|attribute_value_id_seq|8192 bytes
public|film_id_seq|8192 bytes
public|attribute_id_seq|8192 bytes
public|attribute_type|8192 bytes

## Таблица наиболее часто используемых индексов

В БД используется всего 5 индексов. Поэтому для наиболее часто и редко используемых индексов приведена одна единая таблица, отсортированная по частоте сканирования (по убыванию)

Индекс|Таблица|Кол-во сканирований|Кол-во индексных чтений
---|---|---|---
attribute_pk|attribute|10 000 000|10 000 000
film_pk|film|10 000 000|10 000 000
attribute_type_pk|attribute_type|10|10
attribute_value_pk|attribute_value|4|4
av_film_id_index|attribute_value|0|4
