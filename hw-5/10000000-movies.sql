#Количество фильмов с одинаковым названием
EXPLAIN ANALYZE
SELECT name, COUNT(name) AS doubles FROM movies GROUP BY "name" ORDER BY doubles DESC;

QUERY PLAN                                                                                                                                             |
-------------------------------------------------------------------------------------------------------------------------------------------------------+
Sort  (cost=39769.48..39770.02 rows=216 width=67) (actual time=3044.623..3069.326 rows=220 loops=1)                                                    |
  Sort Key: (count(name)) DESC                                                                                                                         |
  Sort Method: quicksort  Memory: 55kB                                                                                                                 |
  ->  Finalize GroupAggregate  (cost=39706.38..39761.10 rows=216 width=67) (actual time=3041.310..3068.740 rows=220 loops=1)                           |
        Group Key: name                                                                                                                                |
        ->  Gather Merge  (cost=39706.38..39756.78 rows=432 width=67) (actual time=3041.293..3067.530 rows=652 loops=1)                                |
              Workers Planned: 2                                                                                                                       |
              Workers Launched: 2                                                                                                                      |
              ->  Sort  (cost=38706.35..38706.89 rows=216 width=67) (actual time=3027.955..3028.216 rows=217 loops=3)                                  |
                    Sort Key: name                                                                                                                     |
                    Sort Method: quicksort  Memory: 55kB                                                                                               |
                    Worker 0:  Sort Method: quicksort  Memory: 55kB                                                                                    |
                    Worker 1:  Sort Method: quicksort  Memory: 55kB                                                                                    |
                    ->  Partial HashAggregate  (cost=38695.82..38697.98 rows=216 width=67) (actual time=3026.360..3026.627 rows=217 loops=3)           |
                          Group Key: name                                                                                                              |
                          ->  Parallel Seq Scan on movies  (cost=0.00..34206.88 rows=897788 width=59) (actual time=0.014..1397.533 rows=718036 loops=3)|
Planning Time: 0.110 ms                                                                                                                                |
Execution Time: 3069.635 ms                                                                                                                            |
-------------------------------------------------------------------------------------------------------------------------------------------------------+


#Исторические фильмы
EXPLAIN ANALYZE
SELECT name FROM movies WHERE name LIKE '%замок%';

QUERY PLAN                                                                                                      |
----------------------------------------------------------------------------------------------------------------+
Seq Scan on movies  (cost=0.00..52162.64 rows=388288 width=59) (actual time=0.021..1860.625 rows=358732 loops=1)|
  Filter: ((name)::text ~~ '%замок%'::text)                                                                     |
  Rows Removed by Filter: 1795375                                                                               |
Planning Time: 0.150 ms                                                                                         |
Execution Time: 2258.882 ms                                                                                     |
----------------------------------------------------------------------------------------------------------------+


#Всего фильмов
EXPLAIN ANALYZE
SELECT COUNT(*) FROM movies;

QUERY PLAN                                                                                                                                |
------------------------------------------------------------------------------------------------------------------------------------------+
Finalize Aggregate  (cost=37451.56..37451.57 rows=1 width=8) (actual time=2855.996..2887.369 rows=1 loops=1)                              |
  ->  Gather  (cost=37451.35..37451.56 rows=2 width=8) (actual time=2853.889..2887.348 rows=3 loops=1)                                    |
        Workers Planned: 2                                                                                                                |
        Workers Launched: 2                                                                                                               |
        ->  Partial Aggregate  (cost=36451.35..36451.36 rows=1 width=8) (actual time=2845.931..2845.936 rows=1 loops=3)                   |
              ->  Parallel Seq Scan on movies  (cost=0.00..34206.88 rows=897788 width=0) (actual time=0.017..1526.192 rows=718036 loops=3)|
Planning Time: 0.133 ms                                                                                                                   |
Execution Time: 2887.443 ms                                                                                                               |
------------------------------------------------------------------------------------------------------------------------------------------+


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

QUERY PLAN                                                                                                                                                                |
--------------------------------------------------------------------------------------------------------------------------------------------------------------------------+
Gather Merge  (cost=807189.07..1644957.16 rows=7180368 width=241) (actual time=71904.361..91629.402 rows=8615608 loops=1)                                                 |
  Workers Planned: 2                                                                                                                                                      |
  Workers Launched: 2                                                                                                                                                     |
  ->  Sort  (cost=806189.05..815164.51 rows=3590184 width=241) (actual time=71721.618..75551.993 rows=2871869 loops=3)                                                    |
        Sort Key: movies.id, movie_attrs.name                                                                                                                             |
        Sort Method: quicksort  Memory: 639223kB                                                                                                                          |
        Worker 0:  Sort Method: quicksort  Memory: 640335kB                                                                                                               |
        Worker 1:  Sort Method: quicksort  Memory: 637329kB                                                                                                               |
        ->  Hash Left Join  (cost=286621.95..415296.52 rows=3590184 width=241) (actual time=27293.756..61214.476 rows=2871869 loops=3)                                    |
              Hash Cond: (movie_attrs.type_id = movie_attr_types.id)                                                                                                      |
              ->  Parallel Hash Left Join  (cost=286599.80..351923.42 rows=3590184 width=124) (actual time=27293.689..49541.222 rows=2871869 loops=3)                     |
                    Hash Cond: (movie_attr_values.attr_id = movie_attrs.id)                                                                                               |
                    ->  Parallel Hash Left Join  (cost=131506.14..187405.53 rows=3590184 width=96) (actual time=12724.717..22194.167 rows=2871869 loops=3)                |
                          Hash Cond: (movies.id = movie_attr_values.movie_id)                                                                                             |
                          ->  Parallel Seq Scan on movies  (cost=0.00..34206.88 rows=897788 width=63) (actual time=0.022..1761.449 rows=718036 loops=3)                   |
                          ->  Parallel Hash  (cost=86628.84..86628.84 rows=3590184 width=37) (actual time=12696.044..12696.053 rows=2871792 loops=3)                      |
                                Buckets: 16777216  Batches: 1  Memory Usage: 569280kB                                                                                     |
                                ->  Parallel Seq Scan on movie_attr_values  (cost=0.00..86628.84 rows=3590184 width=37) (actual time=0.047..5868.585 rows=2871792 loops=3)|
                    ->  Parallel Hash  (cost=110218.85..110218.85 rows=3589985 width=36) (actual time=14457.691..14457.695 rows=2871829 loops=3)                          |
                          Buckets: 16777216  Batches: 1  Memory Usage: 754848kB                                                                                           |
                          ->  Parallel Seq Scan on movie_attrs  (cost=0.00..110218.85 rows=3589985 width=36) (actual time=1458.709..7025.804 rows=2871829 loops=3)        |
              ->  Hash  (cost=15.40..15.40 rows=540 width=122) (actual time=0.044..0.048 rows=4 loops=3)                                                                  |
                    Buckets: 1024  Batches: 1  Memory Usage: 9kB                                                                                                          |
                    ->  Seq Scan on movie_attr_types  (cost=0.00..15.40 rows=540 width=122) (actual time=0.029..0.035 rows=4 loops=3)                                     |
Planning Time: 3.440 ms                                                                                                                                                   |
JIT:                                                                                                                                                                      |
  Functions: 81                                                                                                                                                           |
  Options: Inlining true, Optimization true, Expressions true, Deforming true                                                                                             |
  Timing: Generation 46.175 ms, Inlining 761.781 ms, Optimization 2467.791 ms, Emission 1142.590 ms, Total 4418.337 ms                                                    |
Execution Time: 101429.365 ms                                                                                                                                             |
--------------------------------------------------------------------------------------------------------------------------------------------------------------------------+



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

QUERY PLAN                                                                                                                           |
-------------------------------------------------------------------------------------------------------------------------------------+
Sort  (cost=15233.08..15294.96 rows=24750 width=63) (actual time=4595.999..4621.453 rows=21621 loops=1)                              |
  Sort Key: halls.name                                                                                                               |
  Sort Method: quicksort  Memory: 2458kB                                                                                             |
  ->  HashAggregate  (cost=13055.68..13426.93 rows=24750 width=63) (actual time=4392.935..4437.823 rows=21621 loops=1)               |
        Group Key: halls.name, rows.row_num                                                                                          |
        ->  Hash Right Join  (cost=585.62..9176.75 rows=387893 width=57) (actual time=59.894..3527.716 rows=514533 loops=1)          |
              Hash Cond: (rows.hall_id = halls.id)                                                                                   |
              ->  Hash Right Join  (cost=555.35..8123.90 rows=387893 width=38) (actual time=57.058..2217.574 rows=514532 loops=1)    |
                    Hash Cond: (seats.row_id = rows.id)                                                                              |
                    ->  Seq Scan on seats  (cost=0.00..6468.14 rows=419114 width=36) (actual time=0.022..828.785 rows=514532 loops=1)|
                    ->  Hash  (cost=319.60..319.60 rows=18860 width=8) (actual time=56.966..56.970 rows=21620 loops=1)               |
                          Buckets: 32768  Batches: 1  Memory Usage: 1101kB                                                           |
                          ->  Seq Scan on rows  (cost=0.00..319.60 rows=18860 width=8) (actual time=0.016..27.197 rows=21620 loops=1)|
              ->  Hash  (cost=17.90..17.90 rows=990 width=25) (actual time=2.817..2.820 rows=866 loops=1)                            |
                    Buckets: 1024  Batches: 1  Memory Usage: 59kB                                                                    |
                    ->  Seq Scan on halls  (cost=0.00..17.90 rows=990 width=25) (actual time=0.028..1.346 rows=866 loops=1)          |
Planning Time: 0.505 ms                                                                                                              |
Execution Time: 4644.388 ms                                                                                                          |
-------------------------------------------------------------------------------------------------------------------------------------+



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

QUERY PLAN                                                                                                                                                                                           |
-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+
Limit  (cost=301844.49..301844.74 rows=100 width=95) (actual time=41642.911..41896.234 rows=100 loops=1)                                                                                             |
  ->  Sort  (cost=301844.49..301845.03 rows=216 width=95) (actual time=41512.216..41765.331 rows=100 loops=1)                                                                                        |
        Sort Key: (max(movie_attr_values.val_float)), movies.name                                                                                                                                    |
        Sort Method: top-N heapsort  Memory: 42kB                                                                                                                                                    |
        ->  Finalize GroupAggregate  (cost=301780.43..301836.24 rows=216 width=95) (actual time=41508.350..41764.085 rows=216 loops=1)                                                               |
              Group Key: movies.name                                                                                                                                                                 |
              ->  Gather Merge  (cost=301780.43..301830.84 rows=432 width=95) (actual time=41508.314..41762.875 rows=648 loops=1)                                                                    |
                    Workers Planned: 2                                                                                                                                                               |
                    Workers Launched: 2                                                                                                                                                              |
                    ->  Sort  (cost=300780.41..300780.95 rows=216 width=95) (actual time=41369.271..41369.530 rows=216 loops=3)                                                                      |
                          Sort Key: movies.name                                                                                                                                                      |
                          Sort Method: quicksort  Memory: 55kB                                                                                                                                       |
                          Worker 0:  Sort Method: quicksort  Memory: 55kB                                                                                                                            |
                          Worker 1:  Sort Method: quicksort  Memory: 55kB                                                                                                                            |
                          ->  Partial HashAggregate  (cost=300769.87..300772.03 rows=216 width=95) (actual time=41367.655..41367.970 rows=216 loops=3)                                               |
                                Group Key: movies.name                                                                                                                                               |
                                ->  Parallel Hash Join  (cost=193133.06..293288.72 rows=997487 width=80) (actual time=13979.452..38857.862 rows=837506 loops=3)                                      |
                                      Hash Cond: (movie_attr_values.movie_id = movies.id)                                                                                                            |
                                      Join Filter: ((((movies.name)::text ~~ '%Эпичный%'::text) AND ((movie_attrs.name)::text ~~ '%Оценка%'::text)) OR ((movie_attrs.name)::text ~~ '%Отзыв%'::text))|
                                      Rows Removed by Join Filter: 598405                                                                                                                            |
                                      ->  Parallel Hash Join  (cost=147703.83..243756.90 rows=1562892 width=53) (actual time=10284.122..27582.862 rows=1435910 loops=3)                              |
                                            Hash Cond: (movie_attr_values.attr_id = movie_attrs.id)                                                                                                  |
                                            ->  Parallel Seq Scan on movie_attr_values  (cost=0.00..86628.84 rows=3590184 width=29) (actual time=0.022..6194.279 rows=2871792 loops=3)               |
                                            ->  Parallel Hash  (cost=128168.77..128168.77 rows=1562805 width=32) (actual time=10274.275..10274.278 rows=1435912 loops=3)                             |
                                                  Buckets: 8388608 (originally 4194304)  Batches: 1 (originally 1)  Memory Usage: 418912kB                                                           |
                                                  ->  Parallel Seq Scan on movie_attrs  (cost=0.00..128168.77 rows=1562805 width=32) (actual time=0.720..5571.512 rows=1435912 loops=3)              |
                                                        Filter: (((name)::text ~~ '%Оценка%'::text) OR ((name)::text ~~ '%Отзыв%'::text))                                                            |
                                                        Rows Removed by Filter: 1435917                                                                                                              |
                                      ->  Parallel Hash  (cost=34206.88..34206.88 rows=897788 width=63) (actual time=3675.409..3675.413 rows=718036 loops=3)                                         |
                                            Buckets: 4194304  Batches: 1  Memory Usage: 241504kB                                                                                                     |
                                            ->  Parallel Seq Scan on movies  (cost=0.00..34206.88 rows=897788 width=63) (actual time=71.938..1710.486 rows=718036 loops=3)                           |
Planning Time: 1.097 ms                                                                                                                                                                              |
JIT:                                                                                                                                                                                                 |
  Functions: 88                                                                                                                                                                                      |
  Options: Inlining false, Optimization false, Expressions true, Deforming true                                                                                                                      |
  Timing: Generation 52.968 ms, Inlining 0.000 ms, Optimization 36.220 ms, Emission 302.517 ms, Total 391.705 ms                                                                                     |
Execution Time: 41912.334 ms                                                                                                                                                                         |
-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+
