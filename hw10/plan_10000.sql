-- 1) запрос на все билеты с ценой выше 1000
explain (ANALYZE,BUFFERS) SELECT id FROM tickets
WHERE price >= 1000;
-- QUERY PLAN                                                                                             |
-- -------------------------------------------------------------------------------------------------------|
-- Seq Scan on tickets  (cost=0.00..184.80 rows=3221 width=4) (actual time=0.019..7.530 rows=4506 loops=1)|
--   Filter: (price >= '1000'::numeric)                                                                   |
--   Rows Removed by Filter: 5494                                                                         |
--   Buffers: shared hit=64                                                                               |
-- Planning Time: 0.068 ms                                                                                |
-- Execution Time: 13.328 ms                                                                              |

-- 2) запрос на сумму с продаж для сессий на определенные места
explain (ANALYZE,BUFFERS) SELECT session_id, SUM(price) FROM public.tickets
WHERE place_id in (1, 8, 5, 5587, 9999, 111, 123)
GROUP BY session_id
ORDER BY session_id;
-- QUERY PLAN                                                                                                                                             |
-- -------------------------------------------------------------------------------------------------------------------------------------------------------|
-- Sort  (cost=112.71..113.12 rows=164 width=36) (actual time=1.487..1.622 rows=100 loops=1)                                                              |
--   Sort Key: session_id                                                                                                                                 |
--   Sort Method: quicksort  Memory: 29kB                                                                                                                 |
--   Buffers: shared hit=79                                                                                                                               |
--   ->  HashAggregate  (cost=104.63..106.68 rows=164 width=36) (actual time=1.111..1.327 rows=100 loops=1)                                               |
--         Group Key: session_id                                                                                                                          |
--         Buffers: shared hit=79                                                                                                                         |
--         ->  Bitmap Heap Scan on tickets  (cost=32.60..102.94 rows=338 width=18) (actual time=0.063..0.582 rows=300 loops=1)                            |
--               Recheck Cond: (place_id = ANY ('{1,8,5,5587,9999,111,123}'::integer[]))                                                                  |
--               Heap Blocks: exact=64                                                                                                                    |
--               Buffers: shared hit=79                                                                                                                   |
--               ->  Bitmap Index Scan on tickets_place_id_session_id_key  (cost=0.00..32.52 rows=338 width=0) (actual time=0.045..0.047 rows=300 loops=1)|
--                     Index Cond: (place_id = ANY ('{1,8,5,5587,9999,111,123}'::integer[]))                                                              |
--                     Buffers: shared hit=15                                                                                                             |
-- Planning Time: 0.107 ms                                                                                                                                |
-- Execution Time: 1.803 ms                                                                                                                               |

-- 3) Запрос значений атрибутов для определенных фильмов и атрибутов
explain (ANALYZE,BUFFERS) SELECT * from movies_attr_value mav
WHERE length(mav.value_string) > 10
order by length(mav.value_string);

-- QUERY PLAN                                                                                                                 |
-- ---------------------------------------------------------------------------------------------------------------------------|
-- Sort  (cost=414.36..422.69 rows=3333 width=47) (actual time=3.753..4.792 rows=794 loops=1)                                 |
--   Sort Key: (length((value_string)::text))                                                                                 |
--   Sort Method: quicksort  Memory: 87kB                                                                                     |
--   Buffers: shared hit=61                                                                                                   |
--   ->  Seq Scan on movies_attr_value mav  (cost=0.00..219.33 rows=3333 width=47) (actual time=0.013..2.465 rows=794 loops=1)|
--         Filter: (length((value_string)::text) > 10)                                                                        |
--         Rows Removed by Filter: 9206                                                                                       |
--         Buffers: shared hit=61                                                                                             |
-- Planning Time: 0.111 ms                                                                                                    |
-- Execution Time: 5.922 ms                                                                                                   |

-- 4) запрос на сборы по фильмам, по билетам с ценой места в зале более 500 и с ценой сеанса менее 500
explain (ANALYZE,BUFFERS) SELECT m.name, SUM(t.price) FROM public.tickets t
INNER JOIN public.sessions s ON t.session_id = s.id
INNER JOIN public.halls h ON h.id = s.hall_id
INNER JOIN public.places p ON h.id = p.hall_id AND t.place_id = p.id
INNER JOIN public.movies m ON m.id = s.movie_id
WHERE p.place_tariff > 500
and s.session_tariff < 500
GROUP BY m.id
ORDER BY m.name;
-- QUERY PLAN                                                                                                                                            |
-- ------------------------------------------------------------------------------------------------------------------------------------------------------|
-- Sort  (cost=276.14..276.16 rows=8 width=552) (actual time=44.252..44.266 rows=10 loops=1)                                                             |
--   Sort Key: m.name                                                                                                                                    |
--   Sort Method: quicksort  Memory: 25kB                                                                                                                |
--   Buffers: shared hit=1122                                                                                                                            |
--   ->  GroupAggregate  (cost=275.86..276.02 rows=8 width=552) (actual time=43.653..44.219 rows=10 loops=1)                                             |
--         Group Key: m.id                                                                                                                               |
--         Buffers: shared hit=1122                                                                                                                      |
--         ->  Sort  (cost=275.86..275.88 rows=8 width=534) (actual time=43.569..43.874 rows=264 loops=1)                                                |
--               Sort Key: m.id                                                                                                                          |
--               Sort Method: quicksort  Memory: 45kB                                                                                                    |
--               Buffers: shared hit=1122                                                                                                                |
--               ->  Nested Loop  (cost=70.38..275.74 rows=8 width=534) (actual time=0.402..43.207 rows=264 loops=1)                                     |
--                     Join Filter: (s.hall_id = h.id)                                                                                                   |
--                     Buffers: shared hit=1122                                                                                                          |
--                     ->  Nested Loop  (cost=70.23..274.42 rows=5 width=542) (actual time=0.392..41.708 rows=264 loops=1)                               |
--                           Buffers: shared hit=594                                                                                                     |
--                           ->  Hash Join  (cost=70.09..273.07 rows=5 width=26) (actual time=0.379..40.205 rows=264 loops=1)                            |
--                                 Hash Cond: ((t.session_id = s.id) AND (p.hall_id = s.hall_id))                                                        |
--                                 Buffers: shared hit=66                                                                                                |
--                                 ->  Hash Join  (cost=37.16..223.24 rows=3219 width=22) (actual time=0.178..33.462 rows=4900 loops=1)                  |
--                                       Hash Cond: (t.place_id = p.id)                                                                                  |
--                                       Buffers: shared hit=65                                                                                          |
--                                       ->  Seq Scan on tickets t  (cost=0.00..160.64 rows=9664 width=22) (actual time=0.007..12.897 rows=10000 loops=1)|
--                                             Buffers: shared hit=64                                                                                    |
--                                       ->  Hash  (cost=30.38..30.38 rows=543 width=8) (actual time=0.163..0.164 rows=49 loops=1)                       |
--                                             Buckets: 1024  Batches: 1  Memory Usage: 10kB                                                             |
--                                             Buffers: shared hit=1                                                                                     |
--                                             ->  Seq Scan on places p  (cost=0.00..30.38 rows=543 width=8) (actual time=0.006..0.088 rows=49 loops=1)  |
--                                                   Filter: (place_tariff > '500'::numeric)                                                             |
--                                                   Rows Removed by Filter: 51                                                                          |
--                                                   Buffers: shared hit=1                                                                               |
--                                 ->  Hash  (cost=26.38..26.38 rows=437 width=12) (actual time=0.192..0.194 rows=56 loops=1)                            |
--                                       Buckets: 1024  Batches: 1  Memory Usage: 11kB                                                                   |
--                                       Buffers: shared hit=1                                                                                           |
--                                       ->  Seq Scan on sessions s  (cost=0.00..26.38 rows=437 width=12) (actual time=0.012..0.105 rows=56 loops=1)     |
--                                             Filter: (session_tariff < '500'::numeric)                                                                 |
--                                             Rows Removed by Filter: 44                                                                                |
--                                             Buffers: shared hit=1                                                                                     |
--                           ->  Index Scan using movies_pk on movies m  (cost=0.14..0.27 rows=1 width=520) (actual time=0.002..0.002 rows=1 loops=264)  |
--                                 Index Cond: (id = s.movie_id)                                                                                         |
--                                 Buffers: shared hit=528                                                                                               |
--                     ->  Index Only Scan using halls_pk on halls h  (cost=0.14..0.25 rows=1 width=4) (actual time=0.002..0.002 rows=1 loops=264)       |
--                           Index Cond: (id = p.hall_id)                                                                                                |
--                           Heap Fetches: 264                                                                                                           |
--                           Buffers: shared hit=528                                                                                                     |
-- Planning Time: 0.700 ms                                                                                                                               |
-- Execution Time: 44.379 ms                                                                                                                             |

-- 5) запрос на сборы по фильмам (с определенными типами атрибутов), сгруппированные по залам.
explain (ANALYZE,BUFFERS) SELECT h.name, m.name, m.description, sum(t.price) from tickets t
inner join public.sessions s on s.id = t.session_id
inner join public.movies m on m.id = s.movie_id
inner join public.halls h on h.id = s.hall_id
where m.id = 100
group by (h.id, m.id)
order by (h.name, m.name);

-- QUERY PLAN                                                                                                                                 |
-- -------------------------------------------------------------------------------------------------------------------------------------------|
-- Sort  (cost=221.54..221.79 rows=100 width=609) (actual time=0.023..0.024 rows=0 loops=1)                                                   |
--   Sort Key: (ROW(h.name, m.name))                                                                                                          |
--   Sort Method: quicksort  Memory: 25kB                                                                                                     |
--   Buffers: shared hit=1                                                                                                                    |
--   ->  HashAggregate  (cost=216.97..218.22 rows=100 width=609) (actual time=0.017..0.019 rows=0 loops=1)                                    |
--         Group Key: h.id, m.id                                                                                                              |
--         Buffers: shared hit=1                                                                                                              |
--         ->  Hash Join  (cost=15.57..216.22 rows=100 width=550) (actual time=0.013..0.014 rows=0 loops=1)                                   |
--               Hash Cond: (s.hall_id = h.id)                                                                                                |
--               Buffers: shared hit=1                                                                                                        |
--               ->  Nested Loop  (cost=2.42..202.80 rows=100 width=34) (actual time=0.010..0.011 rows=0 loops=1)                             |
--                     Buffers: shared hit=1                                                                                                  |
--                     ->  Index Scan using movies_pk on movies m  (cost=0.15..8.17 rows=1 width=25) (actual time=0.006..0.008 rows=0 loops=1)|
--                           Index Cond: (id = 100)                                                                                           |
--                           Buffers: shared hit=1                                                                                            |
--                     ->  Hash Join  (cost=2.26..193.62 rows=100 width=13) (never executed)                                                  |
--                           Hash Cond: (t.session_id = s.id)                                                                                 |
--                           ->  Seq Scan on tickets t  (cost=0.00..164.00 rows=10000 width=9) (never executed)                               |
--                           ->  Hash  (cost=2.25..2.25 rows=1 width=12) (never executed)                                                     |
--                                 ->  Seq Scan on sessions s  (cost=0.00..2.25 rows=1 width=12) (never executed)                             |
--                                       Filter: (movie_id = 100)                                                                             |
--               ->  Hash  (cost=11.40..11.40 rows=140 width=520) (never executed)                                                            |
--                     ->  Seq Scan on halls h  (cost=0.00..11.40 rows=140 width=520) (never executed)                                        |
-- Planning Time: 0.337 ms                                                                                                                    |
-- Execution Time: 0.099 ms                                                                                                                   |

-- 6) вывести все атрибуты c длиной текстового значения меньше 10.
explain (ANALYZE,BUFFERS) SELECT m."name" as movie_id, ma.name as movie_attr_name, mav.value_date from public.movies_attr_value mav
inner join public.movies m on m.id = mav.movie_id
inner join public.movies_attr ma on ma.id  = mav.movie_attr_id
where length(mav.value_string) < 10
order by m.name;

-- QUERY PLAN                                                                                                                             |
-- ---------------------------------------------------------------------------------------------------------------------------------------|
-- Sort  (cost=270.24..274.67 rows=1769 width=1040) (actual time=11.146..12.127 rows=808 loops=1)                                         |
--   Sort Key: m.name                                                                                                                     |
--   Sort Method: quicksort  Memory: 87kB                                                                                                 |
--   Buffers: shared hit=69                                                                                                               |
--   ->  Hash Join  (cost=24.73..174.82 rows=1769 width=1040) (actual time=3.053..9.808 rows=808 loops=1)                                 |
--         Hash Cond: (mav.movie_attr_id = ma.id)                                                                                         |
--         Buffers: shared hit=69                                                                                                         |
--         ->  Hash Join  (cost=11.57..156.92 rows=1769 width=528) (actual time=0.055..4.500 rows=808 loops=1)                            |
--               Hash Cond: (mav.movie_id = m.id)                                                                                         |
--               Buffers: shared hit=62                                                                                                   |
--               ->  Seq Scan on movies_attr_value mav  (cost=0.00..140.61 rows=1769 width=16) (actual time=0.010..2.168 rows=808 loops=1)|
--                     Filter: (length((value_string)::text) < 10)                                                                        |
--                     Rows Removed by Filter: 9192                                                                                       |
--                     Buffers: shared hit=61                                                                                             |
--               ->  Hash  (cost=10.70..10.70 rows=70 width=520) (actual time=0.036..0.038 rows=10 loops=1)                               |
--                     Buckets: 1024  Batches: 1  Memory Usage: 9kB                                                                       |
--                     Buffers: shared hit=1                                                                                              |
--                     ->  Seq Scan on movies m  (cost=0.00..10.70 rows=70 width=520) (actual time=0.004..0.019 rows=10 loops=1)          |
--                           Buffers: shared hit=1                                                                                        |
--         ->  Hash  (cost=11.40..11.40 rows=140 width=520) (actual time=2.990..2.991 rows=1000 loops=1)                                  |
--               Buckets: 1024  Batches: 1  Memory Usage: 56kB                                                                            |
--               Buffers: shared hit=7                                                                                                    |
--               ->  Seq Scan on movies_attr ma  (cost=0.00..11.40 rows=140 width=520) (actual time=0.013..1.490 rows=1000 loops=1)       |
--                     Buffers: shared hit=7                                                                                              |
-- Planning Time: 0.217 ms                                                                                                                |
-- Execution Time: 13.179 ms                                                                                                              |