-- 1
-- количество проданных билетов на сеанс
EXPLAIN ANALYZE
SELECT COUNT(*)
FROM order_details
WHERE film_session_id = 1;
-- 10000
-- "Aggregate  (cost=379.21..379.22 rows=1 width=8) (actual time=2.460..2.460 rows=1 loops=1)"
-- "  ->  Seq Scan on order_details  (cost=0.00..379.20 rows=2 width=0) (actual time=0.072..2.455 rows=11 loops=1)"
-- "        Filter: (film_session_id = 1)"
-- "        Rows Removed by Filter: 19989"
-- "Planning Time: 0.854 ms"
-- "Execution Time: 2.476 ms"

-- 1000000 before
-- "Finalize Aggregate  (cost=12579.52..12579.53 rows=1 width=8) (actual time=205.619..205.619 rows=1 loops=1)"
-- "  ->  Gather  (cost=12579.30..12579.51 rows=2 width=8) (actual time=202.293..213.517 rows=3 loops=1)"
-- "        Workers Planned: 2"
-- "        Workers Launched: 2"
-- "        ->  Partial Aggregate  (cost=11579.30..11579.31 rows=1 width=8) (actual time=120.739..120.739 rows=1 loops=3)"
-- "              ->  Parallel Seq Scan on order_details  (cost=0.00..11578.80 rows=201 width=0) (actual time=120.730..120.730 rows=0 loops=3)"
-- "                    Filter: (film_session_id = 1)"
-- "                    Rows Removed by Filter: 333333"
-- "Planning Time: 2.350 ms"
-- "Execution Time: 213.606 ms"

-- 1000000 after
-- создан индекс - как результат время выполнения значительно сократилось
-- create index i_film_session_id on order_details(film_session_id)
-- "Aggregate  (cost=12.46..12.47 rows=1 width=8) (actual time=0.069..0.069 rows=1 loops=1)"
-- "  ->  Index Only Scan using i_film_session_id on order_details  (cost=0.42..12.46 rows=2 width=0) (actual time=0.065..0.065 rows=0 loops=1)"
-- "        Index Cond: (film_session_id = 1)"
-- "        Heap Fetches: 0"
-- "Planning Time: 2.711 ms"
-- "Execution Time: 0.108 ms"


-- 2
-- поиск фильма по названию
EXPLAIN ANALYZE
SELECT name
FROM movies
WHERE name LIKE '%qwerty%';

-- 10000
-- "Seq Scan on movies  (cost=0.00..84.08 rows=1 width=204) (actual time=1.602..1.602 rows=0 loops=1)"
-- "  Filter: ((name)::text ~~ '%qwerty%'::text)"
-- "  Rows Removed by Filter: 2000"
-- "Planning Time: 1.833 ms"
-- "Execution Time: 1.620 ms"

-- 1000000 before
-- "Gather  (cost=1000.00..35630.38 rows=100 width=204) (actual time=592.390..597.380 rows=0 loops=1)"
-- "  Workers Planned: 2"
-- "  Workers Launched: 2"
-- "  ->  Parallel Seq Scan on movies  (cost=0.00..34620.38 rows=42 width=204) (actual time=507.242..507.242 rows=0 loops=3)"
-- "        Filter: ((name)::text ~~ '%qwerty%'::text)"
-- "        Rows Removed by Filter: 333333"
-- "Planning Time: 1.791 ms"
-- "Execution Time: 597.400 ms"

-- 1000000 after
-- создан индекс по названию фильма для регистро независимого поиска - значимого прироста скорости выполнения не дало. Тк
-- CREATE INDEX ON movies ((lower(name)));
-- "Gather  (cost=1000.00..35630.33 rows=100 width=204) (actual time=573.434..578.109 rows=0 loops=1)"
-- "  Workers Planned: 2"
-- "  Workers Launched: 2"
-- "  ->  Parallel Seq Scan on movies  (cost=0.00..34620.33 rows=42 width=204) (actual time=499.104..499.104 rows=0 loops=3)"
-- "        Filter: ((name)::text ~~ '%qwerty%'::text)"
-- "        Rows Removed by Filter: 333333"
-- "Planning Time: 2.632 ms"
-- "Execution Time: 578.128 ms"


-- 3
-- Фильмы "сегодня"
EXPLAIN ANALYZE
SELECT movies.name
FROM movies
         LEFT JOIN film_sessions fs ON movies.movie_id = fs.movie_id
WHERE fs.time_from >= now()
  AND fs.time_to <= now();

-- 10000
-- "Nested Loop  (cost=0.28..63.30 rows=1 width=204) (actual time=0.354..0.354 rows=0 loops=1)"
-- "  ->  Seq Scan on film_sessions fs  (cost=0.00..55.00 rows=1 width=4) (actual time=0.353..0.353 rows=0 loops=1)"
-- "        Filter: ((time_from >= now()) AND (time_to <= now()))"
-- "        Rows Removed by Filter: 2000"
-- "  ->  Index Scan using movies_pkey on movies  (cost=0.28..8.29 rows=1 width=208) (never executed)"
-- "        Index Cond: (movie_id = fs.movie_id)"
-- "Planning Time: 3.235 ms"
-- "Execution Time: 0.387 ms"



-- 1000000 before
-- "Nested Loop  (cost=0.42..28193.25 rows=100 width=204) (actual time=206.520..206.521 rows=0 loops=1)"
-- "  ->  Seq Scan on film_sessions fs  (cost=0.00..27353.00 rows=100 width=4) (actual time=206.520..206.520 rows=0 loops=1)"
-- "        Filter: ((time_from >= now()) AND (time_to <= now()))"
-- "        Rows Removed by Filter: 1000000"
-- "  ->  Index Scan using movies_pkey on movies  (cost=0.42..8.40 rows=1 width=208) (never executed)"
-- "        Index Cond: (movie_id = fs.movie_id)"
-- "Planning Time: 3.178 ms"
-- "Execution Time: 206.541 ms"

-- 1000000 after
-- созданы индексы
-- create index on film_sessions (time_from);
-- create index on film_sessions (time_to);
-- как результат - значительный прирос скорости выполнения

-- "Nested Loop  (cost=0.85..16.89 rows=1 width=204) (actual time=0.030..0.030 rows=0 loops=1)"
-- "  ->  Index Scan using film_sessions_time_from_idx on film_sessions fs  (cost=0.43..8.45 rows=1 width=4) (actual time=0.029..0.029 rows=0 loops=1)"
-- "        Index Cond: (time_from >= now())"
-- "        Filter: (time_to <= now())"
-- "  ->  Index Scan using movies_pkey on movies  (cost=0.42..8.44 rows=1 width=208) (never executed)"
-- "        Index Cond: (movie_id = fs.movie_id)"
-- "Planning Time: 3.727 ms"
-- "Execution Time: 0.061 ms"


-- 4
-- выручка по всем заказам за последний месяц
EXPLAIN ANALYZE
SELECT sum(od.price)
FROM orders AS o
         LEFT JOIN order_details od ON o.order_id = od.order_id
WHERE o.datetime >= now() - INTERVAL '1 month';
-- 10000
-- todo

-- 1000000 before
-- "Aggregate  (cost=58725.64..58725.65 rows=1 width=8) (actual time=1129.423..1129.423 rows=1 loops=1)"
-- "  ->  Hash Right Join  (cost=27982.19..57952.20 rows=309375 width=8) (actual time=436.169..1097.458 rows=424342 loops=1)"
-- "        Hash Cond: (od.order_id = o.order_id)"
-- "        ->  Seq Scan on order_details od  (cost=0.00..16370.00 rows=1000000 width=12) (actual time=0.055..184.871 rows=1000000 loops=1)"
-- "        ->  Hash  (cost=22906.00..22906.00 rows=309375 width=4) (actual time=433.861..433.861 rows=310348 loops=1)"
-- "              Buckets: 131072  Batches: 8  Memory Usage: 2394kB"
-- "              ->  Seq Scan on orders o  (cost=0.00..22906.00 rows=309375 width=4) (actual time=0.056..368.151 rows=310348 loops=1)"
-- "                    Filter: (datetime >= (now() - '1 mon'::interval))"
-- "                    Rows Removed by Filter: 689652"
-- "Planning Time: 1.541 ms"
-- "Execution Time: 1129.817 ms"

-- 1000000 after
-- создан индекс
-- create index on orders(datetime)
-- результат - прирост скорости выполнения
-- "Aggregate  (cost=52437.34..52437.35 rows=1 width=8) (actual time=889.411..889.411 rows=1 loops=1)"
-- "  ->  Hash Right Join  (cost=21693.92..51663.93 rows=309364 width=8) (actual time=198.246..855.896 rows=424321 loops=1)"
-- "        Hash Cond: (od.order_id = o.order_id)"
-- "        ->  Seq Scan on order_details od  (cost=0.00..16370.00 rows=1000000 width=12) (actual time=0.034..169.506 rows=1000000 loops=1)"
-- "        ->  Hash  (cost=16617.87..16617.87 rows=309364 width=4) (actual time=196.334..196.334 rows=310334 loops=1)"
-- "              Buckets: 131072  Batches: 8  Memory Usage: 2394kB"
-- "              ->  Bitmap Heap Scan on orders o  (cost=5798.00..16617.87 rows=309364 width=4) (actual time=59.128..126.517 rows=310334 loops=1)"
-- "                    Recheck Cond: (datetime >= (now() - '1 mon'::interval))"
-- "                    Heap Blocks: exact=5406"
-- "                    ->  Bitmap Index Scan on orders_datetime_idx  (cost=0.00..5720.66 rows=309364 width=0) (actual time=58.538..58.538 rows=310334 loops=1)"
-- "                          Index Cond: (datetime >= (now() - '1 mon'::interval))"
-- "Planning Time: 2.043 ms"
-- "Execution Time: 890.070 ms"

-- 5
-- top 5 прибыльных фильмов за все время
EXPLAIN ANALYZE
SELECT m.name AS movie_name, sum(od.price) AS total
FROM orders
         LEFT JOIN order_details od ON orders.order_id = od.order_id
         LEFT JOIN film_sessions fs ON od.film_session_id = fs.film_session_id
         LEFT JOIN movies m ON fs.movie_id = m.movie_id
GROUP BY movie_name
HAVING sum(od.price) > 0
ORDER BY total DESC
LIMIT 5;

-- 10000
-- "Limit  (cost=1115.82..1115.84 rows=5 width=212) (actual time=53.822..53.829 rows=5 loops=1)"
-- "  ->  Sort  (cost=1115.82..1117.49 rows=667 width=212) (actual time=53.821..53.821 rows=5 loops=1)"
-- "        Sort Key: (sum(od.price)) DESC"
-- "        Sort Method: top-N heapsort  Memory: 27kB"
-- "        ->  HashAggregate  (cost=1079.74..1104.74 rows=667 width=212) (actual time=53.014..53.493 rows=1269 loops=1)"
-- "              Group Key: m.name"
-- "              Filter: (sum(od.price) > '0'::double precision)"
-- "              Rows Removed by Filter: 1"
-- "              ->  Hash Left Join  (cost=444.00..929.74 rows=20000 width=212) (actual time=7.226..39.203 rows=21333 loops=1)"
-- "                    Hash Cond: (fs.movie_id = m.movie_id)"
-- "                    ->  Hash Left Join  (cost=340.00..773.13 rows=20000 width=12) (actual time=6.112..28.413 rows=21333 loops=1)"
-- "                          Hash Cond: (od.film_session_id = fs.film_session_id)"
-- "                          ->  Hash Right Join  (cost=280.00..660.52 rows=20000 width=12) (actual time=5.376..18.916 rows=21333 loops=1)"
-- "                                Hash Cond: (od.order_id = orders.order_id)"
-- "                                ->  Seq Scan on order_details od  (cost=0.00..328.00 rows=20000 width=16) (actual time=0.039..2.313 rows=20000 loops=1)"
-- "                                ->  Hash  (cost=155.00..155.00 rows=10000 width=4) (actual time=5.259..5.259 rows=10000 loops=1)"
-- "                                      Buckets: 16384  Batches: 1  Memory Usage: 480kB"
-- "                                      ->  Seq Scan on orders  (cost=0.00..155.00 rows=10000 width=4) (actual time=0.028..2.236 rows=10000 loops=1)"
-- "                          ->  Hash  (cost=35.00..35.00 rows=2000 width=8) (actual time=0.713..0.713 rows=2000 loops=1)"
-- "                                Buckets: 2048  Batches: 1  Memory Usage: 95kB"
-- "                                ->  Seq Scan on film_sessions fs  (cost=0.00..35.00 rows=2000 width=8) (actual time=0.017..0.393 rows=2000 loops=1)"
-- "                    ->  Hash  (cost=79.00..79.00 rows=2000 width=208) (actual time=1.090..1.091 rows=2000 loops=1)"
-- "                          Buckets: 2048  Batches: 1  Memory Usage: 485kB"
-- "                          ->  Seq Scan on movies m  (cost=0.00..79.00 rows=2000 width=208) (actual time=0.024..0.483 rows=2000 loops=1)"
-- "Planning Time: 0.834 ms"

-- 1000000 before
-- "Limit  (cost=381757.27..381757.28 rows=5 width=212) (actual time=11724.343..12276.122 rows=5 loops=1)"
-- "  ->  Sort  (cost=381757.27..382590.60 rows=333333 width=212) (actual time=11724.342..11724.343 rows=5 loops=1)"
-- "        Sort Key: (sum(od.price)) DESC"
-- "        Sort Method: top-N heapsort  Memory: 27kB"
-- "        ->  Finalize GroupAggregate  (cost=253991.63..376220.73 rows=333333 width=212) (actual time=9053.933..11600.497 rows=468834 loops=1)"
-- "              Group Key: m.name"
-- "              Filter: (sum(od.price) > '0'::double precision)"
-- "              Rows Removed by Filter: 1"
-- "              ->  Gather Merge  (cost=253991.63..357470.72 rows=833334 width=212) (actual time=9053.924..11853.440 rows=470943 loops=1)"
-- "                    Workers Planned: 2"
-- "                    Workers Launched: 2"
-- "                    ->  Partial GroupAggregate  (cost=252991.61..260283.28 rows=416667 width=212) (actual time=8865.936..9954.864 rows=156981 loops=3)"
-- "                          Group Key: m.name"
-- "                          ->  Sort  (cost=252991.61..254033.27 rows=416667 width=212) (actual time=8865.916..9795.331 rows=455927 loops=3)"
-- "                                Sort Key: m.name"
-- "                                Sort Method: external merge  Disk: 75400kB"
-- "                                Worker 0:  Sort Method: external merge  Disk: 75672kB"
-- "                                Worker 1:  Sort Method: external merge  Disk: 73712kB"
-- "                                ->  Parallel Hash Left Join  (cost=86724.01..128642.79 rows=416667 width=212) (actual time=3585.013..4201.622 rows=455927 loops=3)"
-- "                                      Hash Cond: (fs.movie_id = m.movie_id)"
-- "                                      ->  Parallel Hash Left Join  (cost=36136.01..61090.04 rows=416667 width=12) (actual time=1599.764..2037.489 rows=455927 loops=3)"
-- "                                            Hash Cond: (od.film_session_id = fs.film_session_id)"
-- "                                            ->  Parallel Hash Left Join  (cost=17780.00..35942.28 rows=416667 width=12) (actual time=694.189..1088.565 rows=455927 loops=3)"
-- "                                                  Hash Cond: (orders.order_id = od.order_id)"
-- "                                                  ->  Parallel Seq Scan on orders  (cost=0.00..9572.67 rows=416667 width=4) (actual time=0.018..79.388 rows=333333 loops=3)"
-- "                                                  ->  Parallel Hash  (cost=10536.67..10536.67 rows=416667 width=16) (actual time=425.101..425.101 rows=333333 loops=3)"
-- "                                                        Buckets: 131072  Batches: 16  Memory Usage: 4000kB"
-- "                                                        ->  Parallel Seq Scan on order_details od  (cost=0.00..10536.67 rows=416667 width=16) (actual time=1.668..222.857 rows=333333 loops=3)"
-- "                                            ->  Parallel Hash  (cost=11519.67..11519.67 rows=416667 width=8) (actual time=314.831..314.831 rows=333333 loops=3)"
-- "                                                  Buckets: 131072  Batches: 16  Memory Usage: 3552kB"
-- "                                                  ->  Parallel Seq Scan on film_sessions fs  (cost=0.00..11519.67 rows=416667 width=8) (actual time=0.024..141.279 rows=333333 loops=3)"
-- "                                      ->  Parallel Hash  (cost=33578.67..33578.67 rows=416667 width=208) (actual time=1206.935..1206.935 rows=333333 loops=3)"
-- "                                            Buckets: 32768  Batches: 64  Memory Usage: 4000kB"
-- "                                            ->  Parallel Seq Scan on movies m  (cost=0.00..33578.67 rows=416667 width=208) (actual time=2.527..687.046 rows=333333 loops=3)"
-- "Planning Time: 0.481 ms"
-- 1000000 after
-- создан индекс
-- create index on order_details(price)

-- 6
-- фильмы которые посмотрел конкретный пользователь
EXPLAIN ANALYZE
SELECT name
FROM movies
WHERE movie_id IN (
    SELECT fs.movie_id
    FROM orders
             LEFT JOIN order_details od ON orders.order_id = od.order_id
             LEFT JOIN film_sessions fs ON od.film_session_id = fs.film_session_id
    WHERE client_id = 100
)

-- 10000
--     "Nested Loop  (cost=562.03..563.82 rows=4 width=204) (actual time=4.841..4.858 rows=4 loops=1)"
--     "  ->  HashAggregate  (cost=561.76..561.80 rows=4 width=4) (actual time=4.820..4.821 rows=4 loops=1)"
--     "        Group Key: fs.movie_id"
--     "        ->  Nested Loop  (cost=180.30..561.75 rows=4 width=4) (actual time=1.990..4.810 rows=4 loops=1)"
--     "              ->  Hash Join  (cost=180.03..560.55 rows=4 width=4) (actual time=1.974..4.770 rows=4 loops=1)"
--     "                    Hash Cond: (od.order_id = orders.order_id)"
--     "                    ->  Seq Scan on order_details od  (cost=0.00..328.00 rows=20000 width=8) (actual time=0.012..1.754 rows=20000 loops=1)"
--     "                    ->  Hash  (cost=180.00..180.00 rows=2 width=4) (actual time=0.858..0.858 rows=1 loops=1)"
--     "                          Buckets: 1024  Batches: 1  Memory Usage: 9kB"
--     "                          ->  Seq Scan on orders  (cost=0.00..180.00 rows=2 width=4) (actual time=0.567..0.851 rows=1 loops=1)"
--     "                                Filter: (client_id = 100)"
--     "                                Rows Removed by Filter: 9999"
--     "              ->  Index Scan using film_sessions_pkey on film_sessions fs  (cost=0.28..0.30 rows=1 width=8) (actual time=0.007..0.007 rows=1 loops=4)"
--     "                    Index Cond: (film_session_id = od.film_session_id)"
--     "  ->  Index Scan using movies_pkey on movies  (cost=0.28..0.51 rows=1 width=208) (actual time=0.007..0.007 rows=1 loops=4)"
--     "        Index Cond: (movie_id = fs.movie_id)"
--     "Planning Time: 0.331 ms"
--     "Execution Time: 4.913 ms"

-- 1000000 before
--     "Nested Loop  (cost=23245.88..23246.85 rows=2 width=204) (actual time=319.408..319.418 rows=2 loops=1)"
-- "  ->  Unique  (cost=23245.46..23245.47 rows=2 width=4) (actual time=319.390..319.392 rows=2 loops=1)"
-- "        ->  Sort  (cost=23245.46..23245.46 rows=2 width=4) (actual time=319.389..319.390 rows=2 loops=1)"
-- "              Sort Key: fs.movie_id"
-- "              Sort Method: quicksort  Memory: 25kB"
-- "              ->  Gather  (cost=11614.77..23245.45 rows=2 width=4) (actual time=319.004..331.139 rows=2 loops=1)"
-- "                    Workers Planned: 2"
-- "                    Workers Launched: 2"
-- "                    ->  Nested Loop  (cost=10614.77..22245.25 rows=1 width=4) (actual time=203.847..222.303 rows=1 loops=3)"
-- "                          ->  Parallel Hash Join  (cost=10614.35..22244.76 rows=1 width=4) (actual time=203.825..222.270 rows=1 loops=3)"
-- "                                Hash Cond: (od.order_id = orders.order_id)"
-- "                                ->  Parallel Seq Scan on order_details od  (cost=0.00..10536.67 rows=416667 width=8) (actual time=0.711..90.894 rows=333333 loops=3)"
-- "                                ->  Parallel Hash  (cost=10614.33..10614.33 rows=1 width=4) (actual time=74.114..74.114 rows=1 loops=3)"
-- "                                      Buckets: 1024  Batches: 1  Memory Usage: 72kB"
-- "                                      ->  Parallel Seq Scan on orders  (cost=0.00..10614.33 rows=1 width=4) (actual time=67.505..73.985 rows=1 loops=3)"
-- "                                            Filter: (client_id = 100)"
-- "                                            Rows Removed by Filter: 333333"
-- "                          ->  Index Scan using film_sessions_pkey on film_sessions fs  (cost=0.42..0.48 rows=1 width=8) (actual time=0.040..0.040 rows=1 loops=2)"
-- "                                Index Cond: (film_session_id = od.film_session_id)"
-- "  ->  Index Scan using movies_pkey on movies  (cost=0.42..0.69 rows=1 width=208) (actual time=0.011..0.011 rows=1 loops=2)"
-- "        Index Cond: (movie_id = fs.movie_id)"
-- "Planning Time: 0.538 ms"
-- 1000000 after