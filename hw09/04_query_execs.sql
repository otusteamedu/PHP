-- 1
EXPLAIN ANALYZE
SELECT COUNT(*)
FROM order_details
WHERE film_session_id = 1;
-- 10000
-- Aggregate  (cost=189.00..189.01 rows=1 width=8) (actual time=2.091..2.091 rows=1 loops=1)
--   ->  Seq Scan on order_details  (cost=0.00..189.00 rows=2 width=0) (actual time=0.741..2.085 rows=1 loops=1)
--         Filter: (film_session_id = 1)
--         Rows Removed by Filter: 9999
-- Planning Time: 2.481 ms
-- Execution Time: 2.132 ms


-- 1000000

-- 2
-- поиск фильма по названию
EXPLAIN ANALYZE
SELECT name
FROM movies
WHERE name LIKE '%qwerty%';

-- 10000
-- Seq Scan on movies  (cost=0.00..42.50 rows=1 width=204) (actual time=0.403..0.403 rows=0 loops=1)
--   Filter: ((name)::text ~~ '%qwerty%'::text)
--   Rows Removed by Filter: 1000
-- Planning Time: 1.297 ms
-- Execution Time: 0.416 ms


-- 1000000
--
-- Gather  (cost=1000.00..35630.38 rows=100 width=204) (actual time=355.706..365.202 rows=0 loops=1)
--   Workers Planned: 2
--   Workers Launched: 2
--   ->  Parallel Seq Scan on movies  (cost=0.00..34620.38 rows=42 width=204) (actual time=303.428..303.428 rows=0 loops=3)
--         Filter: ((name)::text ~~ '%qwerty%'::text)
--         Rows Removed by Filter: 333333
-- Planning Time: 0.106 ms
-- Execution Time: 365.219 ms



-- 3
-- Фильмы "сегодня"
EXPLAIN ANALYZE
SELECT movies.name
FROM movies
         LEFT JOIN film_sessions fs ON movies.movie_id = fs.movie_id
WHERE fs.time_from >= now()
  AND fs.time_to <= now();

-- 10000
-- Hash Join  (cost=52.50..326.54 rows=14 width=204) (actual time=0.482..3.250 rows=16 loops=1)
--   Hash Cond: (fs.movie_id = movies.movie_id)
--   ->  Seq Scan on film_sessions fs  (cost=0.00..274.00 rows=14 width=4) (actual time=0.041..2.782 rows=16 loops=1)
--         Filter: ((time_from >= now()) AND (time_to <= now()))
--         Rows Removed by Filter: 9984
--   ->  Hash  (cost=40.00..40.00 rows=1000 width=208) (actual time=0.430..0.430 rows=1000 loops=1)
--         Buckets: 1024  Batches: 1  Memory Usage: 243kB
--         ->  Seq Scan on movies  (cost=0.00..40.00 rows=1000 width=208) (actual time=0.007..0.151 rows=1000 loops=1)
-- Planning Time: 0.200 ms
-- Execution Time: 3.319 ms



-- 1000000

-- 4
-- выручка по всем заказам за последний месяц
EXPLAIN ANALYZE
SELECT sum(od.price)
FROM orders AS o
         LEFT JOIN order_details od ON o.order_id = od.order_id
WHERE o.datetime >= now() - INTERVAL '1 month';
-- 10000
-- Aggregate  (cost=467.57..467.58 rows=1 width=8) (actual time=5.334..5.334 rows=1 loops=1)
--   ->  Hash Right Join  (cost=269.43..459.69 rows=3154 width=8) (actual time=3.320..5.131 rows=4291 loops=1)
--         Hash Cond: (od.order_id = o.order_id)
--         ->  Seq Scan on order_details od  (cost=0.00..164.00 rows=10000 width=12) (actual time=0.013..0.590 rows=10000 loops=1)
--         ->  Hash  (cost=230.00..230.00 rows=3154 width=4) (actual time=3.300..3.300 rows=3139 loops=1)
--               Buckets: 4096  Batches: 1  Memory Usage: 143kB
--               ->  Seq Scan on orders o  (cost=0.00..230.00 rows=3154 width=4) (actual time=0.021..2.965 rows=3139 loops=1)
--                     Filter: (datetime >= (now() - '1 mon'::interval))
--                     Rows Removed by Filter: 6861
-- Planning Time: 1.121 ms
-- Execution Time: 5.358 ms


-- 1000000

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
-- Limit  (cost=967.41..967.43 rows=5 width=212) (actual time=26.311..26.314 rows=5 loops=1)
--   ->  Sort  (cost=967.41..968.25 rows=333 width=212) (actual time=26.310..26.310 rows=5 loops=1)
--         Sort Key: (sum(od.price)) DESC
--         Sort Method: top-N heapsort  Memory: 26kB
--         ->  HashAggregate  (cost=949.38..961.88 rows=333 width=212) (actual time=25.968..26.140 rows=998 loops=1)
--               Group Key: m.name
--               Filter: (sum(od.price) > '0'::double precision)
--               Rows Removed by Filter: 1
--               ->  Hash Left Join  (cost=631.50..874.38 rows=10000 width=212) (actual time=7.913..20.788 rows=13676 loops=1)
--                     Hash Cond: (fs.movie_id = m.movie_id)
--                     ->  Hash Left Join  (cost=579.00..795.52 rows=10000 width=12) (actual time=7.480..16.964 rows=13676 loops=1)
--                           Hash Cond: (od.film_session_id = fs.film_session_id)
--                           ->  Hash Right Join  (cost=280.00..470.26 rows=10000 width=12) (actual time=2.876..8.348 rows=13676 loops=1)
--                                 Hash Cond: (od.order_id = orders.order_id)
--                                 ->  Seq Scan on order_details od  (cost=0.00..164.00 rows=10000 width=16) (actual time=0.034..0.926 rows=10000 loops=1)
--                                 ->  Hash  (cost=155.00..155.00 rows=10000 width=4) (actual time=2.781..2.781 rows=10000 loops=1)
--                                       Buckets: 16384  Batches: 1  Memory Usage: 480kB
--                                       ->  Seq Scan on orders  (cost=0.00..155.00 rows=10000 width=4) (actual time=0.015..1.149 rows=10000 loops=1)
--                           ->  Hash  (cost=174.00..174.00 rows=10000 width=8) (actual time=4.528..4.529 rows=10000 loops=1)
--                                 Buckets: 16384  Batches: 1  Memory Usage: 519kB
--                                 ->  Seq Scan on film_sessions fs  (cost=0.00..174.00 rows=10000 width=8) (actual time=0.022..2.245 rows=10000 loops=1)
--                     ->  Hash  (cost=40.00..40.00 rows=1000 width=208) (actual time=0.417..0.417 rows=1000 loops=1)
--                           Buckets: 1024  Batches: 1  Memory Usage: 243kB
--                           ->  Seq Scan on movies m  (cost=0.00..40.00 rows=1000 width=208) (actual time=0.022..0.169 rows=1000 loops=1)
-- Planning Time: 0.500 ms
-- Execution Time: 26.654 ms
--

-- 1000000

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

--     Nested Loop  (cost=371.26..371.86 rows=2 width=204) (actual time=3.167..3.172 rows=3 loops=1)
--     ->  Unique  (cost=370.98..370.99 rows=2 width=4) (actual time=3.155..3.156 rows=3 loops=1)
--     ->  Sort  (cost=370.98..370.99 rows=2 width=4) (actual time=3.154..3.154 rows=3 loops=1)
--     Sort Key: fs.movie_id
--     Sort Method: quicksort  Memory: 25kB
--     ->  Nested Loop  (cost=180.31..370.97 rows=2 width=4) (actual time=2.329..3.147 rows=3 loops=1)
--     ->  Hash Join  (cost=180.03..370.29 rows=2 width=4) (actual time=2.307..3.119 rows=3 loops=1)
--     Hash Cond: (od.order_id = orders.order_id)
--     ->  Seq Scan on order_details od  (cost=0.00..164.00 rows=10000 width=8) (actual time=0.023..0.673 rows=10000 loops=1)
--     ->  Hash  (cost=180.00..180.00 rows=2 width=4) (actual time=1.708..1.708 rows=2 loops=1)
--     Buckets: 1024  Batches: 1  Memory Usage: 9kB
--     ->  Seq Scan on orders  (cost=0.00..180.00 rows=2 width=4) (actual time=1.241..1.695 rows=2 loops=1)
--     Filter: (client_id = 100)
--     Rows Removed by Filter: 9998
--     ->  Index Scan using film_sessions_pkey on film_sessions fs  (cost=0.29..0.34 rows=1 width=8) (actual time=0.008..0.008 rows=1 loops=3)
--     Index Cond: (film_session_id = od.film_session_id)
--     ->  Index Scan using movies_pkey on movies  (cost=0.28..0.43 rows=1 width=208) (actual time=0.004..0.004 rows=1 loops=3)
--     Index Cond: (movie_id = fs.movie_id)
--     Planning Time: 0.382 ms
--     Execution Time: 3.225 ms


-- 1000000