-- количество проданных билетов на сеанс
EXPLAIN ANALYSE
SELECT COUNT(*)
FROM order_details
WHERE film_session_id = 1;

-- 10000

-- Aggregate  (cost=189.01..189.01 rows=1 width=8)
--            ->  Seq Scan on order_details  (cost=0.00..189.00 rows=2 width=0)
--         Filter: (film_session_id = 1)

-- 1 000 000 before

-- Aggregate  (cost=12578.54..12578.55 rows=1 width=8) (actual time=74.106..74.106 rows=1 loops=1)
--   ->  Gather  (cost=1000.00..12578.53 rows=2 width=0) (actual time=73.873..77.424 rows=1 loops=1)
--         Workers Planned: 2
--         Workers Launched: 2
--         ->  Parallel Seq Scan on order_details  (cost=0.00..11578.33 rows=1 width=0) (actual time=33.141..36.982 rows=0 loops=3)
--               Filter: (film_session_id = 1)
--               Rows Removed by Filter: 333333
-- Planning time: 0.053 ms
-- Execution time: 77.448 ms

-- 1 000 000 after
-- Создан индекс
CREATE INDEX ON order_details(film_session_id);
-- результат - значительно сократилось время выполнения
-- Aggregate  (cost=12.46..12.47 rows=1 width=8) (actual time=0.088..0.088 rows=1 loops=1)
--   ->  Index Only Scan using order_details_film_session_id_idx1 on order_details  (cost=0.42..12.46 rows=2 width=0) (actual time=0.083..0.083 rows=1 loops=1)
--         Index Cond: (film_session_id = 1)
--         Heap Fetches: 1
-- Planning time: 1.023 ms
-- Execution time: 0.107 ms


-- Все заказы определенного пользователя
EXPLAIN ANALYSE
SELECT *
FROM orders
WHERE client_id IN (1, 5, 87, 987);

-- 10000
-- Seq Scan on orders  (cost=0.00..205.00 rows=6 width=16)
--   Filter: (client_id = ANY ('{1,5,87,987}'::integer[]))

-- 1 000 000 before
-- Gather  (cost=1000.00..12656.80 rows=8 width=16) (actual time=73.133..144.731 rows=3 loops=1)
--   Workers Planned: 2
--   Workers Launched: 2
--   ->  Parallel Seq Scan on orders  (cost=0.00..11656.00 rows=3 width=16) (actual time=29.397..37.165 rows=1 loops=3)
--         Filter: (client_id = ANY ('{1,5,87,987}'::integer[]))
--         Rows Removed by Filter: 333332
-- Planning time: 0.066 ms
-- Execution time: 144.743 ms

-- 1 000 000 after
-- создан индекс
CREATE INDEX ON orders(client_id);
-- результат - значительно сократилось время выполнения
-- Bitmap Heap Scan on orders  (cost=17.76..48.96 rows=8 width=16) (actual time=0.066..0.068 rows=3 loops=1)
--   Recheck Cond: (client_id = ANY ('{1,5,87,987}'::integer[]))
--   Heap Blocks: exact=3
--   ->  Bitmap Index Scan on orders_client_id_idx  (cost=0.00..17.76 rows=8 width=0) (actual time=0.063..0.063 rows=3 loops=1)
--         Index Cond: (client_id = ANY ('{1,5,87,987}'::integer[]))
-- Planning time: 0.748 ms
-- Execution time: 0.104 ms


-- количество заказов "за сегодня"
EXPLAIN ANALYSE
SELECT count(*)
FROM orders
WHERE datetime >= date('today')
  AND datetime < date('today') + INTERVAL '1 day';

-- 10000
-- Aggregate  (cost=205.09..205.10 rows=1 width=8)
--            ->  Seq Scan on orders  (cost=0.00..205.00 rows=37 width=0)
--         Filter: ((datetime >= '2020-02-08'::date) AND (datetime < '2020-02-09 00:00:00'::timestamp without time zone))

-- 1 000 000 before
-- Finalize Aggregate  (cost=12660.24..12660.25 rows=1 width=8) (actual time=64.522..64.522 rows=1 loops=1)
--   ->  Gather  (cost=12660.03..12660.24 rows=2 width=8) (actual time=64.297..69.026 rows=3 loops=1)
--         Workers Planned: 2
--         Workers Launched: 2
--         ->  Partial Aggregate  (cost=11660.03..11660.04 rows=1 width=8) (actual time=33.862..33.862 rows=1 loops=3)
--               ->  Parallel Seq Scan on orders  (cost=0.00..11656.00 rows=1610 width=0) (actual time=0.138..33.746 rows=1356 loops=3)
--                     Filter: ((datetime >= '2020-02-08'::date) AND (datetime < '2020-02-09 00:00:00'::timestamp without time zone))
--                     Rows Removed by Filter: 331977
-- Planning time: 0.064 ms
-- Execution time: 69.052 ms

-- 1 000 000 after
-- создан индекс
CREATE INDEX ON orders(datetime);
-- результат - значительно сократилось время выполнения
-- Aggregate  (cost=5389.82..5389.83 rows=1 width=8) (actual time=2.762..2.762 rows=1 loops=1)
--   ->  Bitmap Heap Scan on orders  (cost=85.22..5379.87 rows=3980 width=0) (actual time=0.550..2.596 rows=4069 loops=1)
--         Recheck Cond: ((datetime >= '2020-02-08'::date) AND (datetime < '2020-02-09 00:00:00'::timestamp without time zone))
--         Heap Blocks: exact=2841
--         ->  Bitmap Index Scan on orders_datetime_idx  (cost=0.00..84.23 rows=3980 width=0) (actual time=0.291..0.291 rows=4069 loops=1)
--               Index Cond: ((datetime >= '2020-02-08'::date) AND (datetime < '2020-02-09 00:00:00'::timestamp without time zone))
-- Planning time: 0.103 ms
-- Execution time: 2.789 ms


-- Расписание фильмов на сегодня
EXPLAIN ANALYSE
SELECT movies.name, to_char(fs.time_from, 'DD.MM.YYYY HH:MI:SS') AS movie_start
FROM movies
         LEFT JOIN film_sessions fs ON movies.movie_id = fs.movie_id
WHERE fs.time_from >= date('today')
  AND fs.time_to < date('today') + INTERVAL '1 day'
ORDER BY movie_start;

-- 10000
-- Sort  (cost=506.28..506.39 rows=43 width=236)
--       Sort Key: (to_char(fs.time_from, 'DD.MM.YYYY HH:MI:SS'::text))
--   ->  Nested Loop  (cost=0.29..505.12 rows=43 width=236)
--         ->  Seq Scan on film_sessions fs  (cost=0.00..224.00 rows=43 width=12)
--               Filter: ((time_from >= '2020-02-08'::date) AND (time_to < '2020-02-09 00:00:00'::timestamp without time zone))
--         ->  Index Scan using movies_pkey on movies  (cost=0.29..6.54 rows=1 width=208)
--               Index Cond: (movie_id = fs.movie_id)

-- 1 000 000 before
-- Gather Merge  (cost=25489.20..25876.09 rows=3316 width=236) (actual time=129.963..140.433 rows=3888 loops=1)
--   Workers Planned: 2
--   Workers Launched: 2
--   ->  Sort  (cost=24489.17..24493.32 rows=1658 width=236) (actual time=90.149..90.281 rows=1296 loops=3)
--         Sort Key: (to_char(fs.time_from, 'DD.MM.YYYY HH:MI:SS'::text))
--         Sort Method: quicksort  Memory: 588kB
--         ->  Nested Loop  (cost=0.42..24400.51 rows=1658 width=236) (actual time=0.674..81.481 rows=1296 loops=3)
--               ->  Parallel Seq Scan on film_sessions fs  (cost=0.00..13603.00 rows=1658 width=12) (actual time=0.268..42.185 rows=1296 loops=3)
--                     Filter: ((time_from >= '2020-02-08'::date) AND (time_to < '2020-02-09 00:00:00'::timestamp without time zone))
--                     Rows Removed by Filter: 332037
--               ->  Index Scan using movies_pkey on movies  (cost=0.42..6.51 rows=1 width=208) (actual time=0.029..0.029 rows=1 loops=3888)
--                     Index Cond: (movie_id = fs.movie_id)
-- Planning time: 0.186 ms
-- Execution time: 140.716 ms

-- 1 000 000 after
-- создан индекс
CREATE INDEX ON film_sessions(time_from, time_to);
-- результат - значительно сократилось время выполнения
--
-- Gather Merge  (cost=18689.03..19085.25 rows=3396 width=236) (actual time=44.585..47.856 rows=3888 loops=1)
--   Workers Planned: 2
--   Workers Launched: 2
--   ->  Sort  (cost=17689.00..17693.25 rows=1698 width=236) (actual time=11.284..11.411 rows=1296 loops=3)
--         Sort Key: (to_char(fs.time_from, 'DD.MM.YYYY HH:MI:SS'::text))
--         Sort Method: quicksort  Memory: 1129kB
--         ->  Nested Loop  (cost=106.61..17597.91 rows=1698 width=236) (actual time=0.272..5.821 rows=1296 loops=3)
--               ->  Parallel Bitmap Heap Scan on film_sessions fs  (cost=106.18..6589.28 rows=1698 width=12) (actual time=0.264..1.132 rows=1296 loops=3)
--                     Recheck Cond: ((time_from >= '2020-02-08'::date) AND (time_to < '2020-02-09 00:00:00'::timestamp without time zone))
--                     Heap Blocks: exact=3029
--                     ->  Bitmap Index Scan on film_sessions_time_from_time_to_idx1  (cost=0.00..105.17 rows=4074 width=0) (actual time=0.487..0.487 rows=3888 loops=1)
--                           Index Cond: ((time_from >= '2020-02-08'::date) AND (time_to < '2020-02-09 00:00:00'::timestamp without time zone))
--               ->  Index Scan using movies_pkey on movies  (cost=0.42..6.48 rows=1 width=208) (actual time=0.003..0.003 rows=1 loops=3888)
--                     Index Cond: (movie_id = fs.movie_id)
-- Planning time: 0.199 ms
-- Execution time: 48.171 ms


-- выручка по всем заказам за последний месяц
EXPLAIN ANALYSE
SELECT sum(od.price)
FROM orders AS o
         LEFT JOIN order_details od ON o.order_id = od.order_id
WHERE o.datetime >= date('today') - INTERVAL '1 month';

-- 10000
-- Aggregate  (cost=417.51..417.52 rows=1 width=8)
--            ->  Hash Right Join  (cost=219.38..409.64 rows=3150 width=8)
--         Hash Cond: (od.order_id = o.order_id)
--         ->  Seq Scan on order_details od  (cost=0.00..164.00 rows=10000 width=12)
--         ->  Hash  (cost=180.00..180.00 rows=3150 width=4)
--               ->  Seq Scan on orders o  (cost=0.00..180.00 rows=3150 width=4)
--                     Filter: (datetime >= '2020-01-08 00:00:00'::timestamp without time zone)

-- 1 000 000 before
-- Aggregate  (cost=53853.07..53853.08 rows=1 width=8) (actual time=518.093..518.093 rows=1 loops=1)
--   ->  Hash Right Join  (cost=23073.71..53065.72 rows=314937 width=8) (actual time=118.610..497.638 rows=429814 loops=1)
--         Hash Cond: (od.order_id = o.order_id)
--         ->  Seq Scan on order_details od  (cost=0.00..16370.00 rows=1000000 width=12) (actual time=0.022..107.273 rows=1000000 loops=1)
--         ->  Hash  (cost=17906.00..17906.00 rows=314937 width=4) (actual time=117.303..117.303 rows=313962 loops=1)
--               Buckets: 131072  Batches: 8  Memory Usage: 2408kB
--               ->  Seq Scan on orders o  (cost=0.00..17906.00 rows=314937 width=4) (actual time=0.018..81.495 rows=313962 loops=1)
--                     Filter: (datetime >= '2020-01-08 00:00:00'::timestamp without time zone)
--                     Rows Removed by Filter: 686038
-- Planning time: 0.221 ms
-- Execution time: 518.507 ms

-- 1 000 000 after
-- созданый ранее индекс -  принес небольшой прирост производительности
-- CREATE INDEX ON orders(datetime);
-- Aggregate  (cost=51190.97..51190.98 rows=1 width=8) (actual time=446.456..446.456 rows=1 loops=1)
--   ->  Hash Right Join  (cost=20411.61..50403.62 rows=314937 width=8) (actual time=81.601..428.194 rows=429814 loops=1)
--         Hash Cond: (od.order_id = o.order_id)
--         ->  Seq Scan on order_details od  (cost=0.00..16370.00 rows=1000000 width=12) (actual time=0.013..87.719 rows=1000000 loops=1)
--         ->  Hash  (cost=15243.90..15243.90 rows=314937 width=4) (actual time=80.718..80.718 rows=313962 loops=1)
--               Buckets: 131072  Batches: 8  Memory Usage: 2408kB
--               ->  Bitmap Heap Scan on orders o  (cost=5901.19..15243.90 rows=314937 width=4) (actual time=13.332..47.318 rows=313962 loops=1)
--                     Recheck Cond: (datetime >= '2020-01-08 00:00:00'::timestamp without time zone)
--                     Heap Blocks: exact=5406
--                     ->  Bitmap Index Scan on orders_datetime_idx  (cost=0.00..5822.45 rows=314937 width=0) (actual time=12.847..12.847 rows=313962 loops=1)
--                           Index Cond: (datetime >= '2020-01-08 00:00:00'::timestamp without time zone)
-- Planning time: 0.256 ms
-- Execution time: 446.831 ms



-- фильмы которые посмотрел конкретный пользователь
EXPLAIN ANALYSE
SELECT name
FROM movies
WHERE movie_id IN (
    SELECT fs.movie_id
    FROM orders
             LEFT JOIN order_details od ON orders.order_id = od.order_id
             LEFT JOIN film_sessions fs ON od.film_session_id = fs.film_session_id
    WHERE client_id = 87
);

-- 10000
-- Nested Loop  (cost=371.27..372.01 rows=2 width=204)
--   ->  Unique  (cost=370.98..370.99 rows=2 width=4)
--         ->  Sort  (cost=370.98..370.99 rows=2 width=4)
--               Sort Key: fs.movie_id
--               ->  Nested Loop  (cost=180.31..370.97 rows=2 width=4)
--                     ->  Hash Join  (cost=180.03..370.29 rows=2 width=4)
--                           Hash Cond: (od.order_id = orders.order_id)
--                           ->  Seq Scan on order_details od  (cost=0.00..164.00 rows=10000 width=8)
--                           ->  Hash  (cost=180.00..180.00 rows=2 width=4)
--                                 ->  Seq Scan on orders  (cost=0.00..180.00 rows=2 width=4)
--                                       Filter: (client_id = 100)
--                     ->  Index Scan using film_sessions_pkey on film_sessions fs  (cost=0.29..0.34 rows=1 width=8)
--                           Index Cond: (film_session_id = od.film_session_id)
--   ->  Index Scan using movies_pkey on movies  (cost=0.29..0.51 rows=1 width=208)
--         Index Cond: (movie_id = fs.movie_id)

-- 1 000 000 before
-- Nested Loop  (cost=30610.97..30611.94 rows=2 width=204) (actual time=81.380..81.380 rows=0 loops=1)
--   ->  Unique  (cost=30610.55..30610.56 rows=2 width=4) (actual time=81.379..81.379 rows=0 loops=1)
--         ->  Sort  (cost=30610.55..30610.55 rows=2 width=4) (actual time=81.379..81.379 rows=0 loops=1)
--               Sort Key: fs.movie_id
--               Sort Method: quicksort  Memory: 25kB
--               ->  Nested Loop  (cost=11614.98..30610.54 rows=2 width=4) (actual time=81.376..81.376 rows=0 loops=1)
--                     ->  Hash Join  (cost=11614.56..30609.57 rows=2 width=4) (actual time=81.375..81.375 rows=0 loops=1)
--                           Hash Cond: (od.order_id = orders.order_id)
--                           ->  Seq Scan on order_details od  (cost=0.00..16370.00 rows=1000000 width=8) (actual time=0.011..0.011 rows=1 loops=1)
--                           ->  Hash  (cost=11614.53..11614.53 rows=2 width=4) (actual time=81.361..81.361 rows=0 loops=1)
--                                 Buckets: 1024  Batches: 1  Memory Usage: 8kB
--                                 ->  Gather  (cost=1000.00..11614.53 rows=2 width=4) (actual time=81.360..86.126 rows=0 loops=1)
--                                       Workers Planned: 2
--                                       Workers Launched: 2
--                                       ->  Parallel Seq Scan on orders  (cost=0.00..10614.33 rows=1 width=4) (actual time=38.919..38.919 rows=0 loops=3)
--                                             Filter: (client_id = 100)
--                                             Rows Removed by Filter: 333333
--                     ->  Index Scan using film_sessions_pkey on film_sessions fs  (cost=0.42..0.48 rows=1 width=8) (never executed)
--                           Index Cond: (film_session_id = od.film_session_id)
--   ->  Index Scan using movies_pkey on movies  (cost=0.42..0.69 rows=1 width=208) (never executed)
--         Index Cond: (movie_id = fs.movie_id)
-- Planning time: 0.312 ms
-- Execution time: 86.180 ms

-- 1 000 000 after
-- созданы индексы
CREATE INDEX ON orders(client_id);
CREATE INDEX ON order_details(order_id);
-- результат - значительный прирост скорости выполнения запроса
-- Nested Loop  (cost=38.82..39.79 rows=2 width=204) (actual time=0.030..0.034 rows=2 loops=1)
--   ->  Unique  (cost=38.40..38.41 rows=2 width=4) (actual time=0.026..0.027 rows=2 loops=1)
--         ->  Sort  (cost=38.40..38.40 rows=2 width=4) (actual time=0.026..0.027 rows=2 loops=1)
--               Sort Key: fs.movie_id
--               Sort Method: quicksort  Memory: 25kB
--               ->  Nested Loop  (cost=1.27..38.39 rows=2 width=4) (actual time=0.014..0.023 rows=2 loops=1)
--                     ->  Nested Loop  (cost=0.85..37.42 rows=2 width=4) (actual time=0.010..0.014 rows=2 loops=1)
--                           ->  Index Scan using orders_client_id_idx3 on orders  (cost=0.42..12.46 rows=2 width=4) (actual time=0.005..0.006 rows=2 loops=1)
--                                 Index Cond: (client_id = 87)
--                           ->  Index Scan using order_details_order_id_idx3 on order_details od  (cost=0.42..12.46 rows=2 width=8) (actual time=0.003..0.003 rows=1 loops=2)
--                                 Index Cond: (order_id = orders.order_id)
--                     ->  Index Scan using film_sessions_pkey on film_sessions fs  (cost=0.42..0.48 rows=1 width=8) (actual time=0.004..0.004 rows=1 loops=2)
--                           Index Cond: (film_session_id = od.film_session_id)
--   ->  Index Scan using movies_pkey on movies  (cost=0.42..0.69 rows=1 width=208) (actual time=0.003..0.003 rows=1 loops=2)
--         Index Cond: (movie_id = fs.movie_id)
-- Planning time: 0.570 ms
-- Execution time: 0.056 ms


-- 15 самых больших по размеру объектов бд
SELECT relname, relpages FROM pg_class ORDER BY relpages DESC LIMIT 15;

-- movies	29412
-- film_sessions	7353
-- order_details	6370
-- clients	6370
-- place_prices	6370
-- orders	5406
-- film_sessions_time_from_time_to_idx	3853
-- unique_hall_session_price	3564
-- movies_pkey	2745
-- film_sessions_pkey	2745
-- order_details_film_session_id_idx1	2745
-- orders_client_id_idx	2745
-- place_prices_pkey	2745
-- orders_pkey	2745
-- clients_pkey	2745


-- Топ часто используемых индексов
SELECT indexrelname    AS index_name,
       idstat.idx_scan AS index_scans_count
FROM pg_stat_user_indexes AS idstat
         JOIN
     pg_indexes
     ON
             indexrelname = indexname
             AND
             idstat.schemaname = pg_indexes.schemaname
         JOIN
     pg_stat_user_tables AS tabstat
     ON
         idstat.relid = tabstat.relid
ORDER BY idstat.idx_scan DESC
LIMIT 5;

-- film_sessions_pkey	3090171
-- movies_pkey	2206411
-- hall_places_pkey	2185990
-- orders_pkey	2060251
-- clients_pkey	2060000


-- Топ редко используемых индексов
SELECT indexrelname    AS index_name,
       idstat.idx_scan AS index_scans_count
FROM pg_stat_user_indexes AS idstat
         JOIN
     pg_indexes
     ON
                 indexrelname = indexname
             AND
                 idstat.schemaname = pg_indexes.schemaname
         JOIN
     pg_stat_user_tables AS tabstat
     ON
             idstat.relid = tabstat.relid
ORDER BY idstat.idx_scan ASC
LIMIT 5;

-- order_details_film_session_id_idx	0
-- movie_attr_type_pkey	0
-- movie_attr_pkey	0
-- movie_attr_values_pkey	0
-- film_sessions_time_from_time_to_idx	58
