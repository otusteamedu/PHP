#Количество фильмов с одинаковым названием
EXPLAIN ANALYZE
SELECT name, COUNT(name) AS doubles FROM movies GROUP BY "name" ORDER BY doubles DESC;

QUERY PLAN                                                                                                                                             |
-------------------------------------------------------------------------------------------------------------------------------------------------------+
Sort  (cost=39765.83..39766.37 rows=216 width=67) (actual time=3196.477..3223.478 rows=220 loops=1)                                                    |
  Sort Key: (count(name)) DESC                                                                                                                         |
  Sort Method: quicksort  Memory: 55kB                                                                                                                 |
  ->  Finalize GroupAggregate  (cost=39702.73..39757.45 rows=216 width=67) (actual time=3189.309..3218.816 rows=220 loops=1)                           |
        Group Key: name                                                                                                                                |
        ->  Gather Merge  (cost=39702.73..39753.13 rows=432 width=67) (actual time=3189.289..3217.667 rows=652 loops=1)                                |
              Workers Planned: 2                                                                                                                       |
              Workers Launched: 2                                                                                                                      |
              ->  Sort  (cost=38702.71..38703.25 rows=216 width=67) (actual time=3125.199..3125.451 rows=217 loops=3)                                  |
                    Sort Key: name                                                                                                                     |
                    Sort Method: quicksort  Memory: 55kB                                                                                               |
                    Worker 0:  Sort Method: quicksort  Memory: 55kB                                                                                    |
                    Worker 1:  Sort Method: quicksort  Memory: 55kB                                                                                    |
                    ->  Partial HashAggregate  (cost=38692.17..38694.33 rows=216 width=67) (actual time=3123.559..3123.833 rows=217 loops=3)           |
                          Group Key: name                                                                                                              |
                          ->  Parallel Seq Scan on movies  (cost=0.00..34204.45 rows=897545 width=59) (actual time=0.016..1467.959 rows=718036 loops=3)|
Planning Time: 0.318 ms                                                                                                                                |
Execution Time: 3223.789 ms                                                                                                                            |
-------------------------------------------------------------------------------------------------------------------------------------------------------+


#Исторические фильмы
EXPLAIN ANALYZE
SELECT name FROM movies WHERE name LIKE '%замок%';

QUERY PLAN                                                                                                      |
----------------------------------------------------------------------------------------------------------------+
Seq Scan on movies  (cost=0.00..52155.34 rows=388183 width=59) (actual time=0.033..1840.968 rows=358732 loops=1)|
  Filter: ((name)::text ~~ '%замок%'::text)                                                                     |
  Rows Removed by Filter: 1795375                                                                               |
Planning Time: 2.366 ms                                                                                         |
Execution Time: 2233.051 ms                                                                                     |
----------------------------------------------------------------------------------------------------------------+


#Всего фильмов
EXPLAIN ANALYZE
SELECT COUNT(*) FROM movies;

QUERY PLAN                                                                                                                                |
------------------------------------------------------------------------------------------------------------------------------------------+
Finalize Aggregate  (cost=37448.52..37448.53 rows=1 width=8) (actual time=2742.837..2768.554 rows=1 loops=1)                              |
  ->  Gather  (cost=37448.31..37448.52 rows=2 width=8) (actual time=2741.533..2768.530 rows=3 loops=1)                                    |
        Workers Planned: 2                                                                                                                |
        Workers Launched: 2                                                                                                               |
        ->  Partial Aggregate  (cost=36448.31..36448.32 rows=1 width=8) (actual time=2698.219..2698.224 rows=1 loops=3)                   |
              ->  Parallel Seq Scan on movies  (cost=0.00..34204.45 rows=897545 width=0) (actual time=0.017..1396.013 rows=718036 loops=3)|
Planning Time: 0.128 ms                                                                                                                   |
Execution Time: 2768.626 ms                                                                                                               |
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
Gather Merge  (cost=816996.92..1654661.40 rows=7179480 width=241) (actual time=72630.114..91238.144 rows=8615608 loops=1)                                                 |
  Workers Planned: 2                                                                                                                                                      |
  Workers Launched: 2                                                                                                                                                     |
  ->  Sort  (cost=815996.90..824971.25 rows=3589740 width=241) (actual time=72327.472..76094.900 rows=2871869 loops=3)                                                    |
        Sort Key: movies.id, movie_attrs.name                                                                                                                             |
        Sort Method: quicksort  Memory: 642071kB                                                                                                                          |
        Worker 0:  Sort Method: quicksort  Memory: 644255kB                                                                                                               |
        Worker 1:  Sort Method: quicksort  Memory: 630561kB                                                                                                               |
        ->  Hash Left Join  (cost=286586.42..425155.92 rows=3589740 width=241) (actual time=27953.060..61777.220 rows=2871869 loops=3)                                    |
              Hash Cond: (movie_attrs.type_id = movie_attr_types.id)                                                                                                      |
              ->  Parallel Hash Left Join  (cost=286585.33..351901.69 rows=3589740 width=124) (actual time=27952.994..50269.605 rows=2871869 loops=3)                     |
                    Hash Cond: (movie_attr_values.attr_id = movie_attrs.id)                                                                                               |
                    ->  Parallel Hash Left Join  (cost=131496.15..187389.44 rows=3589740 width=96) (actual time=12248.079..21689.225 rows=2871869 loops=3)                |
                          Hash Cond: (movies.id = movie_attr_values.movie_id)                                                                                             |
                          ->  Parallel Seq Scan on movies  (cost=0.00..34204.45 rows=897545 width=63) (actual time=0.017..1459.958 rows=718036 loops=3)                   |
                          ->  Parallel Hash  (cost=86624.40..86624.40 rows=3589740 width=37) (actual time=12216.487..12216.496 rows=2871792 loops=3)                      |
                                Buckets: 16777216  Batches: 1  Memory Usage: 569280kB                                                                                     |
                                ->  Parallel Seq Scan on movie_attr_values  (cost=0.00..86624.40 rows=3589740 width=37) (actual time=0.041..5493.820 rows=2871792 loops=3)|
                    ->  Parallel Hash  (cost=110216.86..110216.86 rows=3589786 width=36) (actual time=15624.434..15624.438 rows=2871829 loops=3)                          |
                          Buckets: 16777216  Batches: 1  Memory Usage: 754848kB                                                                                           |
                          ->  Parallel Seq Scan on movie_attrs  (cost=0.00..110216.86 rows=3589786 width=36) (actual time=1704.247..7697.520 rows=2871829 loops=3)        |
              ->  Hash  (cost=1.04..1.04 rows=4 width=122) (actual time=0.045..0.049 rows=4 loops=3)                                                                      |
                    Buckets: 1024  Batches: 1  Memory Usage: 9kB                                                                                                          |
                    ->  Seq Scan on movie_attr_types  (cost=0.00..1.04 rows=4 width=122) (actual time=0.029..0.035 rows=4 loops=3)                                        |
Planning Time: 5.831 ms                                                                                                                                                   |
JIT:                                                                                                                                                                      |
  Functions: 81                                                                                                                                                           |
  Options: Inlining true, Optimization true, Expressions true, Deforming true                                                                                             |
  Timing: Generation 74.535 ms, Inlining 450.117 ms, Optimization 2938.994 ms, Emission 1720.737 ms, Total 5184.383 ms                                                    |
Execution Time: 100653.496 ms                                                                                                                                             |
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
Sort  (cost=18100.11..18161.98 rows=24750 width=63) (actual time=5298.027..5323.226 rows=21621 loops=1)                              |
  Sort Key: halls.name                                                                                                               |
  Sort Method: quicksort  Memory: 2458kB                                                                                             |
  ->  HashAggregate  (cost=15922.71..16293.96 rows=24750 width=63) (actual time=5101.423..5145.699 rows=21621 loops=1)               |
        Group Key: halls.name, rows.row_num                                                                                          |
        ->  Hash Right Join  (cost=647.73..10777.39 rows=514532 width=57) (actual time=115.321..4089.286 rows=514533 loops=1)        |
              Hash Cond: (rows.hall_id = halls.id)                                                                                   |
              ->  Hash Right Join  (cost=617.45..9390.68 rows=514532 width=38) (actual time=112.693..2615.686 rows=514532 loops=1)   |
                    Hash Cond: (seats.row_id = rows.id)                                                                              |
                    ->  Seq Scan on seats  (cost=0.00..7422.32 rows=514532 width=36) (actual time=0.032..999.478 rows=514532 loops=1)|
                    ->  Hash  (cost=347.20..347.20 rows=21620 width=8) (actual time=112.588..112.592 rows=21620 loops=1)             |
                          Buckets: 32768  Batches: 1  Memory Usage: 1101kB                                                           |
                          ->  Seq Scan on rows  (cost=0.00..347.20 rows=21620 width=8) (actual time=0.015..65.588 rows=21620 loops=1)|
              ->  Hash  (cost=17.90..17.90 rows=990 width=25) (actual time=2.610..2.613 rows=866 loops=1)                            |
                    Buckets: 1024  Batches: 1  Memory Usage: 59kB                                                                    |
                    ->  Seq Scan on halls  (cost=0.00..17.90 rows=990 width=25) (actual time=0.104..1.588 rows=866 loops=1)          |
Planning Time: 5.137 ms                                                                                                              |
Execution Time: 5347.117 ms                                                                                                          |
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
Limit  (cost=301827.93..301828.18 rows=100 width=95) (actual time=42067.669..42333.080 rows=100 loops=1)                                                                                             |
  ->  Sort  (cost=301827.93..301828.47 rows=216 width=95) (actual time=41921.682..42186.885 rows=100 loops=1)                                                                                        |
        Sort Key: (max(movie_attr_values.val_float)), movies.name                                                                                                                                    |
        Sort Method: top-N heapsort  Memory: 42kB                                                                                                                                                    |
        ->  Finalize GroupAggregate  (cost=301763.87..301819.67 rows=216 width=95) (actual time=41911.582..42185.570 rows=216 loops=1)                                                               |
              Group Key: movies.name                                                                                                                                                                 |
              ->  Gather Merge  (cost=301763.87..301814.27 rows=432 width=95) (actual time=41911.487..42183.780 rows=648 loops=1)                                                                    |
                    Workers Planned: 2                                                                                                                                                               |
                    Workers Launched: 2                                                                                                                                                              |
                    ->  Sort  (cost=300763.84..300764.38 rows=216 width=95) (actual time=41784.788..41785.083 rows=216 loops=3)                                                                      |
                          Sort Key: movies.name                                                                                                                                                      |
                          Sort Method: quicksort  Memory: 55kB                                                                                                                                       |
                          Worker 0:  Sort Method: quicksort  Memory: 55kB                                                                                                                            |
                          Worker 1:  Sort Method: quicksort  Memory: 55kB                                                                                                                            |
                          ->  Partial HashAggregate  (cost=300753.31..300755.47 rows=216 width=95) (actual time=41782.743..41783.047 rows=216 loops=3)                                               |
                                Group Key: movies.name                                                                                                                                               |
                                ->  Parallel Hash Join  (cost=193123.53..293273.09 rows=997363 width=80) (actual time=15812.744..39469.757 rows=837506 loops=3)                                      |
                                      Hash Cond: (movie_attr_values.movie_id = movies.id)                                                                                                            |
                                      Join Filter: ((((movies.name)::text ~~ '%Эпичный%'::text) AND ((movie_attrs.name)::text ~~ '%Оценка%'::text)) OR ((movie_attrs.name)::text ~~ '%Отзыв%'::text))|
                                      Rows Removed by Join Filter: 598405                                                                                                                            |
                                      ->  Parallel Hash Join  (cost=147699.77..243747.24 rows=1562699 width=53) (actual time=10523.426..27088.203 rows=1435910 loops=3)                              |
                                            Hash Cond: (movie_attr_values.attr_id = movie_attrs.id)                                                                                                  |
                                            ->  Parallel Seq Scan on movie_attr_values  (cost=0.00..86624.40 rows=3589740 width=29) (actual time=0.012..6254.227 rows=2871792 loops=3)               |
                                            ->  Parallel Hash  (cost=128165.79..128165.79 rows=1562719 width=32) (actual time=10515.177..10515.182 rows=1435912 loops=3)                             |
                                                  Buckets: 8388608 (originally 4194304)  Batches: 1 (originally 1)  Memory Usage: 418912kB                                                           |
                                                  ->  Parallel Seq Scan on movie_attrs  (cost=0.00..128165.79 rows=1562719 width=32) (actual time=1.228..5839.856 rows=1435912 loops=3)              |
                                                        Filter: (((name)::text ~~ '%Оценка%'::text) OR ((name)::text ~~ '%Отзыв%'::text))                                                            |
                                                        Rows Removed by Filter: 1435917                                                                                                              |
                                      ->  Parallel Hash  (cost=34204.45..34204.45 rows=897545 width=63) (actual time=5249.846..5249.849 rows=718036 loops=3)                                         |
                                            Buckets: 4194304  Batches: 1  Memory Usage: 241536kB                                                                                                     |
                                            ->  Parallel Seq Scan on movies  (cost=0.00..34204.45 rows=897545 width=63) (actual time=72.879..2272.344 rows=718036 loops=3)                           |
Planning Time: 1.171 ms                                                                                                                                                                              |
JIT:                                                                                                                                                                                                 |
  Functions: 88                                                                                                                                                                                      |
  Options: Inlining false, Optimization false, Expressions true, Deforming true                                                                                                                      |
  Timing: Generation 43.040 ms, Inlining 0.000 ms, Optimization 44.320 ms, Emission 313.897 ms, Total 401.257 ms                                                                                     |
Execution Time: 42350.468 ms                                                                                                                                                                         |
-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+
