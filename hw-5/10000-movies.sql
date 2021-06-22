#Количество фильмов с одинаковым названием
EXPLAIN ANALYZE
SELECT name, COUNT(name) AS doubles FROM movies GROUP BY "name" ORDER BY doubles DESC;

QUERY PLAN                                                                                                            |
----------------------------------------------------------------------------------------------------------------------+
Sort  (cost=279.21..279.76 rows=220 width=68) (actual time=29.975..30.229 rows=220 loops=1)                           |
  Sort Key: (count(name)) DESC                                                                                        |
  Sort Method: quicksort  Memory: 55kB                                                                                |
  ->  HashAggregate  (cost=268.45..270.65 rows=220 width=68) (actual time=29.389..29.678 rows=220 loops=1)            |
        Group Key: name                                                                                               |
        ->  Seq Scan on movies  (cost=0.00..218.30 rows=10030 width=60) (actual time=0.020..12.593 rows=10030 loops=1)|
Planning Time: 0.118 ms                                                                                               |
Execution Time: 30.533 ms                                                                                             |
----------------------------------------------------------------------------------------------------------------------+


#Исторические фильмы
EXPLAIN ANALYZE
SELECT name FROM movies WHERE name LIKE '%замок%';

QUERY PLAN                                                                                              |
--------------------------------------------------------------------------------------------------------+
Seq Scan on movies  (cost=0.00..243.38 rows=1661 width=60) (actual time=0.024..12.642 rows=1628 loops=1)|
  Filter: ((name)::text ~~ '%замок%'::text)                                                             |
  Rows Removed by Filter: 8402                                                                          |
Planning Time: 0.219 ms                                                                                 |
Execution Time: 14.413 ms                                                                               |
--------------------------------------------------------------------------------------------------------+


#Всего фильмов
EXPLAIN ANALYZE
SELECT COUNT(*) FROM movies;

QUERY PLAN                                                                                                     |
---------------------------------------------------------------------------------------------------------------+
Aggregate  (cost=243.38..243.38 rows=1 width=8) (actual time=24.654..24.660 rows=1 loops=1)                    |
  ->  Seq Scan on movies  (cost=0.00..218.30 rows=10030 width=0) (actual time=0.021..12.928 rows=10030 loops=1)|
Planning Time: 0.104 ms                                                                                        |
Execution Time: 24.714 ms                                                                                      |
---------------------------------------------------------------------------------------------------------------+


#Информация о фильмах со всеми параметрами
EXPLAIN ANALYZE
SELECT 
  movies.id             AS id,
  movies.name           AS name,
  movie_attr_types.name AS attr_type,
  movie_attrs.name      AS attr_name,
  COALESCE(
    movie_attr_values.val_float::text,
    movie_attr_values.val_int::text,
    movie_attr_values.val_date::text,
    movie_attr_values.val_text
  ) AS attr_value
FROM 
  movies
  LEFT JOIN movie_attr_values ON movies.id = movie_attr_values.movie_id
  LEFT JOIN movie_attrs       ON movie_attr_values.attr_id = movie_attrs.id
  LEFT JOIN movie_attr_types  ON movie_attrs.type_id = movie_attr_types.id
ORDER BY
  movies.id, movie_attrs.name;

QUERY PLAN                                                                                                                                   |
---------------------------------------------------------------------------------------------------------------------------------------------+
Sort  (cost=10631.99..10729.74 rows=39100 width=242) (actual time=638.533..688.309 rows=39330 loops=1)                                       |
  Sort Key: movies.id, movie_attrs.name                                                                                                      |
  Sort Method: external merge  Disk: 4584kB                                                                                                  |
  ->  Hash Left Join  (cost=1585.89..3103.16 rows=39100 width=242) (actual time=168.519..540.290 rows=39330 loops=1)                         |
        Hash Cond: (movie_attrs.type_id = movie_attr_types.id)                                                                               |
        ->  Hash Left Join  (cost=1563.74..2391.07 rows=39100 width=125) (actual time=168.470..431.978 rows=39330 loops=1)                   |
              Hash Cond: (movie_attr_values.attr_id = movie_attrs.id)                                                                        |
              ->  Hash Right Join  (cost=343.68..1068.36 rows=39100 width=97) (actual time=37.510..193.480 rows=39330 loops=1)               |
                    Hash Cond: (movie_attr_values.movie_id = movies.id)                                                                      |
                    ->  Seq Scan on movie_attr_values  (cost=0.00..622.00 rows=39100 width=37) (actual time=0.017..49.086 rows=39100 loops=1)|
                    ->  Hash  (cost=218.30..218.30 rows=10030 width=64) (actual time=37.455..37.459 rows=10030 loops=1)                      |
                          Buckets: 16384  Batches: 1  Memory Usage: 1069kB                                                                   |
                          ->  Seq Scan on movies  (cost=0.00..218.30 rows=10030 width=64) (actual time=0.018..11.671 rows=10030 loops=1)     |
              ->  Hash  (cost=730.03..730.03 rows=39203 width=36) (actual time=130.601..130.605 rows=39203 loops=1)                          |
                    Buckets: 65536  Batches: 1  Memory Usage: 3231kB                                                                         |
                    ->  Seq Scan on movie_attrs  (cost=0.00..730.03 rows=39203 width=36) (actual time=0.015..48.991 rows=39203 loops=1)      |
        ->  Hash  (cost=15.40..15.40 rows=540 width=122) (actual time=0.028..0.031 rows=4 loops=1)                                           |
              Buckets: 1024  Batches: 1  Memory Usage: 9kB                                                                                   |
              ->  Seq Scan on movie_attr_types  (cost=0.00..15.40 rows=540 width=122) (actual time=0.011..0.017 rows=4 loops=1)              |
Planning Time: 0.462 ms                                                                                                                      |
Execution Time: 733.905 ms                                                                                                                   |
---------------------------------------------------------------------------------------------------------------------------------------------+



#Вывести места по центру для каждого ряда
EXPLAIN ANALYZE
SELECT
  halls.name     AS hall,
  rows.row_num   AS row,
  COUNT(seats.*) AS seats_count,
  CEIL(AVG(seats.seat_num)) AS center_seat
FROM
  halls
  LEFT JOIN rows  ON halls.id = rows.hall_id
  LEFT JOIN seats ON rows.id = seats.row_id
GROUP BY
  halls.name,
  rows.row_num
ORDER BY
  halls.name;

QUERY PLAN                                                                                                                    |
------------------------------------------------------------------------------------------------------------------------------+
GroupAggregate  (cost=1012.38..1365.81 rows=12852 width=160) (actual time=53.644..67.721 rows=226 loops=1)                    |
  Group Key: halls.name, rows.row_num                                                                                         |
  ->  Sort  (cost=1012.38..1044.51 rows=12852 width=154) (actual time=53.621..59.895 rows=5356 loops=1)                       |
        Sort Key: halls.name, rows.row_num                                                                                    |
        Sort Method: quicksort  Memory: 946kB                                                                                 |
        ->  Hash Right Join  (cost=29.21..135.25 rows=12852 width=154) (actual time=0.796..39.253 rows=5356 loops=1)          |
              Hash Cond: (rows.hall_id = halls.id)                                                                            |
              ->  Hash Right Join  (cost=7.06..98.94 rows=5355 width=38) (actual time=0.730..25.201 rows=5355 loops=1)        |
                    Hash Cond: (seats.row_id = rows.id)                                                                       |
                    ->  Seq Scan on seats  (cost=0.00..77.55 rows=5355 width=36) (actual time=0.022..9.875 rows=5355 loops=1) |
                    ->  Hash  (cost=4.25..4.25 rows=225 width=8) (actual time=0.695..0.698 rows=225 loops=1)                  |
                          Buckets: 1024  Batches: 1  Memory Usage: 17kB                                                       |
                          ->  Seq Scan on rows  (cost=0.00..4.25 rows=225 width=8) (actual time=0.012..0.377 rows=225 loops=1)|
              ->  Hash  (cost=15.40..15.40 rows=540 width=122) (actual time=0.052..0.055 rows=10 loops=1)                     |
                    Buckets: 1024  Batches: 1  Memory Usage: 9kB                                                              |
                    ->  Seq Scan on halls  (cost=0.00..15.40 rows=540 width=122) (actual time=0.015..0.029 rows=10 loops=1)   |
Planning Time: 0.451 ms                                                                                                       |
Execution Time: 68.056 ms                                                                                                     |
------------------------------------------------------------------------------------------------------------------------------+



#Топ 100 эпичных фильмов с самым высоким рейтингом
EXPLAIN ANALYZE
SELECT
  movies.name AS film,
  MAX(movie_attr_values.val_float) AS ranking,
  MAX(movie_attr_values.val_text)  AS reviw
FROM
  movies
  LEFT JOIN movie_attr_values ON movies.id = movie_attr_values.movie_id
  LEFT JOIN movie_attrs       ON movie_attr_values.attr_id = movie_attrs.id
WHERE
  movies.name LIKE '%Эпичный%'
  AND movie_attrs.name LIKE '%Оценка%'
  OR  movie_attrs.name LIKE '%Отзыв%'
GROUP BY
  film
ORDER BY
  ranking, film
LIMIT
  100;

QUERY PLAN                                                                                                                                                                         |
-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+
Limit  (cost=2345.24..2345.49 rows=100 width=96) (actual time=338.531..338.921 rows=100 loops=1)                                                                                   |
  ->  Sort  (cost=2345.24..2345.79 rows=220 width=96) (actual time=338.527..338.669 rows=100 loops=1)                                                                              |
        Sort Key: (max(movie_attr_values.val_float)), movies.name                                                                                                                  |
        Sort Method: top-N heapsort  Memory: 48kB                                                                                                                                  |
        ->  HashAggregate  (cost=2334.63..2336.83 rows=220 width=96) (actual time=336.957..337.293 rows=216 loops=1)                                                               |
              Group Key: movies.name                                                                                                                                               |
              ->  Hash Join  (cost=1483.13..2252.48 rows=10954 width=81) (actual time=111.157..310.826 rows=11442 loops=1)                                                         |
                    Hash Cond: (movie_attr_values.movie_id = movies.id)                                                                                                            |
                    Join Filter: ((((movies.name)::text ~~ '%Эпичный%'::text) AND ((movie_attrs.name)::text ~~ '%Оценка%'::text)) OR ((movie_attrs.name)::text ~~ '%Отзыв%'::text))|
                    Rows Removed by Join Filter: 8158                                                                                                                              |
                    ->  Hash Join  (cost=1139.46..1864.11 rows=17028 width=53) (actual time=71.454..208.515 rows=19600 loops=1)                                                    |
                          Hash Cond: (movie_attr_values.attr_id = movie_attrs.id)                                                                                                  |
                          ->  Seq Scan on movie_attr_values  (cost=0.00..622.00 rows=39100 width=29) (actual time=0.019..49.126 rows=39100 loops=1)                                |
                          ->  Hash  (cost=926.04..926.04 rows=17073 width=32) (actual time=71.279..71.283 rows=19600 loops=1)                                                      |
                                Buckets: 32768  Batches: 1  Memory Usage: 1644kB                                                                                                   |
                                ->  Seq Scan on movie_attrs  (cost=0.00..926.04 rows=17073 width=32) (actual time=0.028..41.881 rows=19600 loops=1)                                |
                                      Filter: (((name)::text ~~ '%Оценка%'::text) OR ((name)::text ~~ '%Отзыв%'::text))                                                            |
                                      Rows Removed by Filter: 19603                                                                                                                |
                    ->  Hash  (cost=218.30..218.30 rows=10030 width=64) (actual time=39.668..39.671 rows=10030 loops=1)                                                            |
                          Buckets: 16384  Batches: 1  Memory Usage: 1080kB                                                                                                         |
                          ->  Seq Scan on movies  (cost=0.00..218.30 rows=10030 width=64) (actual time=0.022..21.160 rows=10030 loops=1)                                           |
Planning Time: 0.872 ms                                                                                                                                                            |
Execution Time: 339.316 ms                                                                                                                                                         |
-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+
