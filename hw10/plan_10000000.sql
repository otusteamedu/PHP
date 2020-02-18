-- 1) запрос на все билеты с ценой выше 1000
explain (ANALYZE,BUFFERS) SELECT id FROM tickets
WHERE price >= 1000;

-- QUERY PLAN                                                                                                         |
-- -------------------------------------------------------------------------------------------------------------------|
-- Seq Scan on tickets  (cost=0.00..188696.44 rows=4974569 width=4) (actual time=0.023..7274.366 rows=4964151 loops=1)|
--   Filter: (price >= '1000'::numeric)                                                                               |
--   Rows Removed by Filter: 5035849                                                                                  |
--   Buffers: shared read=63695 dirtied=33695 written=33675                                                           |
-- Planning Time: 1.666 ms                                                                                            |
-- Execution Time: 13390.466 ms                                                                                       |

-- добавила index по цене
create index idx_tickets_price on tickets  (price);

-- QUERY PLAN                                                                                                         |
-- -------------------------------------------------------------------------------------------------------------------|
-- Seq Scan on tickets  (cost=0.00..188695.00 rows=4974512 width=4) (actual time=0.028..6927.481 rows=4964151 loops=1)|
--   Filter: (price >= '1000'::numeric)                                                                               |
--   Rows Removed by Filter: 5035849                                                                                  |
--   Buffers: shared hit=96 read=63599                                                                                |
-- Planning Time: 0.299 ms                                                                                            |
-- Execution Time: 12838.315 ms                                                                                       |

-- планер все так же использует полный перебор, индекс не использовался, скорость обработки не изменилась
drop index idx_tickets_price;

-- 2) запрос на сумму с продаж для сессий на определенные места
explain (ANALYZE,BUFFERS) SELECT session_id, SUM(price) FROM public.tickets
WHERE place_id in (1, 8, 5, 5587, 9999, 111, 123)
GROUP BY session_id
ORDER BY session_id;

-- QUERY PLAN                                                                                                                                                                     |
-- -------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
-- Finalize GroupAggregate  (cost=79013.15..93823.21 rows=52334 width=36) (actual time=603.254..1392.751 rows=100000 loops=1)                                                     |
--   Group Key: session_id                                                                                                                                                        |
--   Buffers: shared hit=12 read=22771 written=2561, temp read=159 written=160                                                                                                    |
--   ->  Gather Merge  (cost=79013.15..92384.02 rows=104668 width=36) (actual time=603.234..1062.663 rows=107537 loops=1)                                                         |
--         Workers Planned: 2                                                                                                                                                     |
--         Workers Launched: 2                                                                                                                                                    |
--         Buffers: shared hit=26 read=64749 written=7625, temp read=468 written=471                                                                                              |
--         ->  Partial GroupAggregate  (cost=78013.12..79302.71 rows=52334 width=36) (actual time=599.092..863.067 rows=35846 loops=3)                                            |
--               Group Key: session_id                                                                                                                                            |
--               Buffers: shared hit=26 read=64749 written=7625, temp read=468 written=471                                                                                        |
--               ->  Sort  (cost=78013.12..78224.93 rows=84722 width=9) (actual time=599.071..699.671 rows=66667 loops=3)                                                         |
--                     Sort Key: session_id                                                                                                                                       |
--                     Sort Method: external merge  Disk: 1272kB                                                                                                                  |
--                     Worker 0:  Sort Method: external merge  Disk: 1200kB                                                                                                       |
--                     Worker 1:  Sort Method: external merge  Disk: 1272kB                                                                                                       |
--                     Buffers: shared hit=26 read=64749 written=7625, temp read=468 written=471                                                                                  |
--                     ->  Parallel Bitmap Heap Scan on tickets  (cost=5794.90..71078.44 rows=84722 width=9) (actual time=267.935..496.743 rows=66667 loops=3)                    |
--                           Recheck Cond: (place_id = ANY ('{1,8,5,5587,9999,111,123}'::integer[]))                                                                              |
--                           Heap Blocks: exact=21716                                                                                                                             |
--                           Buffers: shared hit=12 read=64749 written=7625                                                                                                       |
--                           ->  Bitmap Index Scan on tickets_place_id_session_id_key  (cost=0.00..5744.07 rows=203333 width=0) (actual time=259.169..259.170 rows=200000 loops=1)|
--                                 Index Cond: (place_id = ANY ('{1,8,5,5587,9999,111,123}'::integer[]))                                                                          |
--                                 Buffers: shared hit=12 read=1055                                                                                                               |
-- Planning Time: 0.781 ms                                                                                                                                                        |
-- Execution Time: 1529.120 ms                                                                                                                                                    |

-- здесь сразу использовался индеес tickets_place_id_session_id_key - который использовался для уникальности сочетания места и сессии для билетов.

-- indexname                      |indexdef                                                                                                |
-- -------------------------------|--------------------------------------------------------------------------------------------------------|
-- tickets_pk                     |CREATE UNIQUE INDEX tickets_pk ON public.tickets USING btree (id)                                       |
-- tickets_place_id_session_id_key|CREATE UNIQUE INDEX tickets_place_id_session_id_key ON public.tickets USING btree (place_id, session_id)|

-- 3) Запрос значений атрибутов для определенных фильмов и атрибутов
explain (ANALYZE,BUFFERS) SELECT * from movies_attr_value mav
WHERE length(mav.value_string) > 10
order by length(mav.value_string);

-- QUERY PLAN                                                                                                                                           |
-- -----------------------------------------------------------------------------------------------------------------------------------------------------|
-- Gather Merge  (cost=354498.12..678594.85 rows=2777778 width=47) (actual time=1158.930..3024.363 rows=824503 loops=1)                                 |
--   Workers Planned: 2                                                                                                                                 |
--   Workers Launched: 2                                                                                                                                |
--   Buffers: shared hit=13809 read=46610, temp read=4903 written=4923                                                                                  |
--   ->  Sort  (cost=353498.09..356970.32 rows=1388889 width=47) (actual time=1154.204..1542.904 rows=274834 loops=3)                                   |
--         Sort Key: (length((value_string)::text))                                                                                                     |
--         Sort Method: external merge  Disk: 13168kB                                                                                                   |
--         Worker 0:  Sort Method: external merge  Disk: 13096kB                                                                                        |
--         Worker 1:  Sort Method: external merge  Disk: 12960kB                                                                                        |
--         Buffers: shared hit=13809 read=46610, temp read=4903 written=4923                                                                            |
--         ->  Parallel Seq Scan on movies_attr_value mav  (cost=0.00..126337.22 rows=1388889 width=47) (actual time=0.021..673.579 rows=274834 loops=3)|
--               Filter: (length((value_string)::text) > 10)                                                                                            |
--               Rows Removed by Filter: 3058499                                                                                                        |
--               Buffers: shared hit=13755 read=46610                                                                                                   |
-- Planning Time: 0.115 ms                                                                                                                              |
-- Execution Time: 4155.793 ms                                                                                                                          |

-- добавила функциональный индекс по длине строчных значений

create index idx_movies_attr_value_value_string on movies_attr_value(length(value_string));

-- QUERY PLAN                                                                                                                                                                  |
-- ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
-- Index Scan using idx_movies_attr_value_value_string on movies_attr_value mav  (cost=0.43..344691.10 rows=3333333 width=47) (actual time=0.026..1222.350 rows=824503 loops=1)|
--   Index Cond: (length((value_string)::text) > 10)                                                                                                                           |
--   Buffers: shared hit=74587 read=2256                                                                                                                                       |
-- Planning Time: 0.221 ms                                                                                                                                                     |
-- Execution Time: 2233.250 ms                                                                                                                                                 |

-- удалось значительно увеличить скорость обработки запроса

-- 4) запрос на сборы по фильмам, по билетам с ценой места в зале более 500 и с ценой сеанса менее 500
explain (ANALYZE,BUFFERS) SELECT m.name, SUM(t.price) FROM public.tickets t
INNER JOIN public.sessions s ON t.session_id = s.id
INNER JOIN public.places p on p.id = t.place_id
INNER JOIN public.halls h ON h.id = s.hall_id
INNER JOIN public.movies m ON m.id = s.movie_id
WHERE p.place_tariff > 500
and s.session_tariff < 500
GROUP BY m.name
ORDER BY m.name;
-- QUERY PLAN                                                                                                                                                              |
-- ------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
-- Sort  (cost=112267.51..112292.51 rows=10000 width=47) (actual time=3174.160..3186.131 rows=9996 loops=1)                                                                |
--   Sort Key: m.name                                                                                                                                                      |
--   Sort Method: quicksort  Memory: 1164kB                                                                                                                                |
--   Buffers: shared hit=864100 read=74645                                                                                                                                 |
--   ->  HashAggregate  (cost=111478.12..111603.12 rows=10000 width=47) (actual time=3137.403..3151.734 rows=9996 loops=1)                                                 |
--         Group Key: m.id                                                                                                                                                 |
--         Buffers: shared hit=864100 read=74645                                                                                                                           |
--         ->  Hash Join  (cost=312.55..111393.86 rows=16852 width=20) (actual time=27.193..2804.632 rows=234191 loops=1)                                                  |
--               Hash Cond: (s.movie_id = m.id)                                                                                                                            |
--               Buffers: shared hit=864100 read=74645                                                                                                                     |
--               ->  Nested Loop  (cost=16.55..111053.60 rows=16852 width=9) (actual time=0.386..2164.729 rows=234191 loops=1)                                             |
--                     Buffers: shared hit=864098 read=74576                                                                                                               |
--                     ->  Hash Join  (cost=16.11..2358.87 rows=16852 width=12) (actual time=0.354..450.784 rows=234191 loops=1)                                           |
--                           Hash Cond: (s.hall_id = h.id)                                                                                                                 |
--                           Buffers: shared hit=2 read=736                                                                                                                |
--                           ->  Seq Scan on sessions s  (cost=0.00..1986.00 rows=50197 width=12) (actual time=0.010..74.930 rows=49923 loops=1)                           |
--                                 Filter: (session_tariff < '500'::numeric)                                                                                               |
--                                 Rows Removed by Filter: 50077                                                                                                           |
--                                 Buffers: shared hit=1 read=735                                                                                                          |
--                           ->  Hash  (cost=15.52..15.52 rows=47 width=12) (actual time=0.335..0.336 rows=47 loops=1)                                                     |
--                                 Buckets: 1024  Batches: 1  Memory Usage: 11kB                                                                                           |
--                                 Buffers: shared hit=1 read=1                                                                                                            |
--                                 ->  Hash Join  (cost=13.15..15.52 rows=47 width=12) (actual time=0.054..0.266 rows=47 loops=1)                                          |
--                                       Hash Cond: (p.hall_id = h.id)                                                                                                     |
--                                       Buffers: shared hit=1 read=1                                                                                                      |
--                                       ->  Seq Scan on places p  (cost=0.00..2.25 rows=47 width=8) (actual time=0.005..0.084 rows=47 loops=1)                            |
--                                             Filter: (place_tariff > '500'::numeric)                                                                                     |
--                                             Rows Removed by Filter: 53                                                                                                  |
--                                             Buffers: shared hit=1                                                                                                       |
--                                       ->  Hash  (cost=11.40..11.40 rows=140 width=4) (actual time=0.041..0.043 rows=10 loops=1)                                         |
--                                             Buckets: 1024  Batches: 1  Memory Usage: 9kB                                                                                |
--                                             Buffers: shared read=1                                                                                                      |
--                                             ->  Seq Scan on halls h  (cost=0.00..11.40 rows=140 width=4) (actual time=0.008..0.024 rows=10 loops=1)                     |
--                                                   Buffers: shared read=1                                                                                                |
--                     ->  Index Scan using tickets_place_id_session_id_key on tickets t  (cost=0.43..12.46 rows=2 width=13) (actual time=0.003..0.003 rows=1 loops=234191)|
--                           Index Cond: ((place_id = p.id) AND (session_id = s.id))                                                                                       |
--                           Buffers: shared hit=864096 read=73840                                                                                                         |
--               ->  Hash  (cost=171.00..171.00 rows=10000 width=15) (actual time=26.792..26.793 rows=10000 loops=1)                                                       |
--                     Buckets: 16384  Batches: 1  Memory Usage: 602kB                                                                                                     |
--                     Buffers: shared hit=2 read=69                                                                                                                       |
--                     ->  Seq Scan on movies m  (cost=0.00..171.00 rows=10000 width=15) (actual time=0.006..13.354 rows=10000 loops=1)                                    |
--                           Buffers: shared hit=2 read=69                                                                                                                 |
-- Planning Time: 1.078 ms                                                                                                                                                 |
-- Execution Time: 3198.574 ms                                                                                                                                             |

-- добавила индексы
create index idx_sessions_session_tariff on sessions (session_tariff);
create index idx_places_place_tariff on places (place_tariff);
-- но ситуация не изменилась
create index idx_movies_name on movies (name);
create index idx_tickets_price on tickets (price, session_id, place_id);
-- все так же.
drop index idx_sessions_session_tariff;
drop index idx_places_place_tariff;
drop index idx_movies_name;
drop index idx_tickets_price;

-- 5) запрос на сборы по фильмам (с определенными типами атрибутов), сгруппированные по залам.
explain (ANALYZE,BUFFERS) SELECT h.name, m.name, m.description, sum(t.price) from tickets t
inner join public.sessions s on s.id = t.session_id
inner join public.movies m on m.id = s.movie_id
inner join public.halls h on h.id = s.hall_id
where m.id = 100
group by (h.id, m.id)
order by (h.name, m.name);

-- QUERY PLAN                                                                                                                                                              |
-- ------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
-- Sort  (cost=119576.64..119576.66 rows=10 width=609) (actual time=10330.016..10330.031 rows=10 loops=1)                                                                  |
--   Sort Key: (ROW(h.name, m.name))                                                                                                                                       |
--   Sort Method: quicksort  Memory: 26kB                                                                                                                                  |
--   Buffers: shared hit=16467 read=49565                                                                                                                                  |
--   ->  GroupAggregate  (cost=2986.55..119576.47 rows=10 width=609) (actual time=10306.217..10329.979 rows=10 loops=1)                                                    |
--         Group Key: h.id, m.id                                                                                                                                           |
--         Buffers: shared hit=16467 read=49565                                                                                                                            |
--         ->  Nested Loop  (cost=2986.55..119568.85 rows=1000 width=550) (actual time=102.938..10328.652 rows=1000 loops=1)                                               |
--               Join Filter: (s.hall_id = h.id)                                                                                                                           |
--               Rows Removed by Join Filter: 9000                                                                                                                         |
--               Buffers: shared hit=16467 read=49565                                                                                                                      |
--               ->  Index Scan using halls_pk on halls h  (cost=0.14..12.29 rows=10 width=520) (actual time=0.015..0.032 rows=10 loops=1)                                 |
--                     Buffers: shared read=2                                                                                                                              |
--               ->  Materialize  (cost=2986.41..119409.06 rows=1000 width=34) (actual time=10.293..1031.500 rows=1000 loops=10)                                           |
--                     Buffers: shared hit=16467 read=49563                                                                                                                |
--                     ->  Nested Loop  (cost=2986.41..119404.06 rows=1000 width=34) (actual time=102.911..10301.096 rows=1000 loops=1)                                    |
--                           Buffers: shared hit=16467 read=49563                                                                                                          |
--                           ->  Index Scan using movies_pk on movies m  (cost=0.29..8.30 rows=1 width=25) (actual time=0.015..0.020 rows=1 loops=1)                       |
--                                 Index Cond: (id = 100)                                                                                                                  |
--                                 Buffers: shared read=3                                                                                                                  |
--                           ->  Gather  (cost=2986.12..119385.76 rows=1000 width=13) (actual time=102.890..10297.945 rows=1000 loops=1)                                   |
--                                 Workers Planned: 2                                                                                                                      |
--                                 Workers Launched: 2                                                                                                                     |
--                                 Buffers: shared hit=16467 read=49560                                                                                                    |
--                                 ->  Hash Join  (cost=1986.12..118285.76 rows=417 width=13) (actual time=100.450..10299.770 rows=333 loops=3)                            |
--                                       Hash Cond: (t.session_id = s.id)                                                                                                  |
--                                       Buffers: shared hit=16467 read=49560                                                                                              |
--                                       ->  Parallel Seq Scan on tickets t  (cost=0.00..105361.67 rows=4166667 width=9) (actual time=0.017..5163.445 rows=3333333 loops=3)|
--                                             Buffers: shared hit=14869 read=48826                                                                                        |
--                                       ->  Hash  (cost=1986.00..1986.00 rows=10 width=12) (actual time=9.019..9.020 rows=10 loops=3)                                     |
--                                             Buckets: 1024  Batches: 1  Memory Usage: 9kB                                                                                |
--                                             Buffers: shared hit=1474 read=734                                                                                           |
--                                             ->  Seq Scan on sessions s  (cost=0.00..1986.00 rows=10 width=12) (actual time=0.124..8.999 rows=10 loops=3)                |
--                                                   Filter: (movie_id = 100)                                                                                              |
--                                                   Rows Removed by Filter: 99990                                                                                         |
--                                                   Buffers: shared hit=1474 read=734                                                                                     |
-- Planning Time: 0.466 ms                                                                                                                                                 |
-- Execution Time: 10330.188 ms                                                                                                                                            |

-- добавила индексы
create index idx_sessions_movie_id on sessions (movie_id);
create index idx_tickets_session_id on tickets  (session_id);
--
-- QUERY PLAN                                                                                                                                                             |
-- -----------------------------------------------------------------------------------------------------------------------------------------------------------------------|
-- Sort  (cost=202.10..202.12 rows=10 width=609) (actual time=6.232..6.247 rows=10 loops=1)                                                                               |
--   Sort Key: (ROW(h.name, m.name))                                                                                                                                      |
--   Sort Method: quicksort  Memory: 26kB                                                                                                                                 |
--   Buffers: shared hit=56                                                                                                                                               |
--   ->  GroupAggregate  (cost=10.62..201.93 rows=10 width=609) (actual time=0.693..6.186 rows=10 loops=1)                                                                |
--         Group Key: h.id, m.id                                                                                                                                          |
--         Buffers: shared hit=56                                                                                                                                         |
--         ->  Nested Loop  (cost=10.62..194.30 rows=1000 width=550) (actual time=0.113..4.595 rows=1000 loops=1)                                                         |
--               Buffers: shared hit=56                                                                                                                                   |
--               ->  Nested Loop  (cost=10.18..18.53 rows=10 width=549) (actual time=0.100..0.254 rows=10 loops=1)                                                        |
--                     Buffers: shared hit=7                                                                                                                              |
--                     ->  Merge Join  (cost=9.90..10.10 rows=10 width=528) (actual time=0.086..0.157 rows=10 loops=1)                                                    |
--                           Merge Cond: (s.hall_id = h.id)                                                                                                               |
--                           Buffers: shared hit=4                                                                                                                        |
--                           ->  Sort  (cost=8.63..8.66 rows=10 width=12) (actual time=0.044..0.060 rows=10 loops=1)                                                      |
--                                 Sort Key: s.hall_id                                                                                                                    |
--                                 Sort Method: quicksort  Memory: 25kB                                                                                                   |
--                                 Buffers: shared hit=3                                                                                                                  |
--                                 ->  Index Scan using idx_sessions_movie_id on sessions s  (cost=0.29..8.47 rows=10 width=12) (actual time=0.010..0.025 rows=10 loops=1)|
--                                       Index Cond: (movie_id = 100)                                                                                                     |
--                                       Buffers: shared hit=3                                                                                                            |
--                           ->  Sort  (cost=1.27..1.29 rows=10 width=520) (actual time=0.036..0.050 rows=10 loops=1)                                                     |
--                                 Sort Key: h.id                                                                                                                         |
--                                 Sort Method: quicksort  Memory: 25kB                                                                                                   |
--                                 Buffers: shared hit=1                                                                                                                  |
--                                 ->  Seq Scan on halls h  (cost=0.00..1.10 rows=10 width=520) (actual time=0.005..0.020 rows=10 loops=1)                                |
--                                       Buffers: shared hit=1                                                                                                            |
--                     ->  Materialize  (cost=0.29..8.31 rows=1 width=25) (actual time=0.002..0.004 rows=1 loops=10)                                                      |
--                           Buffers: shared hit=3                                                                                                                        |
--                           ->  Index Scan using movies_pk on movies m  (cost=0.29..8.30 rows=1 width=25) (actual time=0.006..0.009 rows=1 loops=1)                      |
--                                 Index Cond: (id = 100)                                                                                                                 |
--                                 Buffers: shared hit=3                                                                                                                  |
--               ->  Index Scan using idx_tickets_session_id on tickets t  (cost=0.43..15.71 rows=187 width=9) (actual time=0.009..0.157 rows=100 loops=10)               |
--                     Index Cond: (session_id = s.id)                                                                                                                    |
--                     Buffers: shared hit=49                                                                                                                             |
-- Planning Time: 0.376 ms                                                                                                                                                |
-- Execution Time: 6.349 ms                                                                                                                                               |

-- скорость очень очень сильно возрасла!

-- 6) вывести все атрибуты c длиной текстового значения меньше 10.
explain (ANALYZE,BUFFERS) SELECT m."name" as movie_id, ma.name as movie_attr_name, mav.value_date from public.movies_attr_value mav
inner join public.movies m on m.id = mav.movie_id
inner join public.movies_attr ma on ma.id  = mav.movie_attr_id
where length(mav.value_string) < 10
order by m.name;

-- QUERY PLAN                                                                                                                                                       |
-- -----------------------------------------------------------------------------------------------------------------------------------------------------------------|
-- Gather Merge  (cost=339669.06..663765.79 rows=2777778 width=32) (actual time=3049.365..4942.379 rows=822802 loops=1)                                             |
--   Workers Planned: 2                                                                                                                                             |
--   Workers Launched: 2                                                                                                                                            |
--   Buffers: shared hit=13861 read=46878, temp read=4143 written=4162                                                                                              |
--   ->  Sort  (cost=338669.04..342141.26 rows=1388889 width=32) (actual time=3044.869..3441.960 rows=274267 loops=3)                                               |
--         Sort Key: m.name                                                                                                                                         |
--         Sort Method: external merge  Disk: 11176kB                                                                                                               |
--         Worker 0:  Sort Method: external merge  Disk: 10984kB                                                                                                    |
--         Worker 1:  Sort Method: external merge  Disk: 10984kB                                                                                                    |
--         Buffers: shared hit=13861 read=46878, temp read=4143 written=4162                                                                                        |
--         ->  Hash Join  (cost=325.50..130499.17 rows=1388889 width=32) (actual time=35.738..2354.187 rows=274267 loops=3)                                         |
--               Hash Cond: (mav.movie_attr_id = ma.id)                                                                                                             |
--               Buffers: shared hit=13805 read=46878                                                                                                               |
--               ->  Hash Join  (cost=296.00..126808.38 rows=1388889 width=25) (actual time=32.256..1503.175 rows=274267 loops=3)                                   |
--                     Hash Cond: (mav.movie_id = m.id)                                                                                                             |
--                     Buffers: shared hit=13700 read=46878                                                                                                         |
--                     ->  Parallel Seq Scan on movies_attr_value mav  (cost=0.00..122865.00 rows=1388889 width=18) (actual time=0.015..626.652 rows=274267 loops=3)|
--                           Filter: (length((value_string)::text) < 10)                                                                                            |
--                           Rows Removed by Filter: 3059066                                                                                                        |
--                           Buffers: shared hit=13487 read=46878                                                                                                   |
--                     ->  Hash  (cost=171.00..171.00 rows=10000 width=15) (actual time=32.203..32.204 rows=10000 loops=3)                                          |
--                           Buckets: 16384  Batches: 1  Memory Usage: 602kB                                                                                        |
--                           Buffers: shared hit=213                                                                                                                |
--                           ->  Seq Scan on movies m  (cost=0.00..171.00 rows=10000 width=15) (actual time=0.011..16.133 rows=10000 loops=3)                       |
--                                 Buffers: shared hit=213                                                                                                          |
--               ->  Hash  (cost=17.00..17.00 rows=1000 width=15) (actual time=3.419..3.421 rows=1000 loops=3)                                                      |
--                     Buckets: 1024  Batches: 1  Memory Usage: 56kB                                                                                                |
--                     Buffers: shared hit=21                                                                                                                       |
--                     ->  Seq Scan on movies_attr ma  (cost=0.00..17.00 rows=1000 width=15) (actual time=0.015..1.706 rows=1000 loops=3)                           |
--                           Buffers: shared hit=21                                                                                                                 |
-- Planning Time: 0.405 ms                                                                                                                                          |
-- Execution Time: 6010.166 ms                                                                                                                                      |

-- добавила индекс по длине строчный строчных значений при условии что оно задано
create index idx_movies_attr_value_name_value_string on movies_attr_value(length(value_string)) where value_string notnull ;

-- QUERY PLAN                                                                                                                                                                             |
-- ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
-- Gather Merge  (cost=335784.15..659880.88 rows=2777778 width=32) (actual time=2944.151..4833.406 rows=822802 loops=1)                                                                   |
--   Workers Planned: 2                                                                                                                                                                   |
--   Workers Launched: 2                                                                                                                                                                  |
--   Buffers: shared hit=13693 read=2251, temp read=4145 written=4165                                                                                                                     |
--   ->  Sort  (cost=334784.13..338256.35 rows=1388889 width=32) (actual time=2933.865..3334.617 rows=274267 loops=3)                                                                     |
--         Sort Key: m.name                                                                                                                                                               |
--         Sort Method: external merge  Disk: 10976kB                                                                                                                                     |
--         Worker 0:  Sort Method: external merge  Disk: 11088kB                                                                                                                          |
--         Worker 1:  Sort Method: external merge  Disk: 11096kB                                                                                                                          |
--         Buffers: shared hit=13693 read=2251, temp read=4145 written=4165                                                                                                               |
--         ->  Hash Join  (cost=38107.26..126614.26 rows=1388889 width=32) (actual time=62.858..2218.885 rows=274267 loops=3)                                                             |
--               Hash Cond: (mav.movie_attr_id = ma.id)                                                                                                                                   |
--               Buffers: shared hit=13677 read=2251                                                                                                                                      |
--               ->  Hash Join  (cost=38077.76..122923.47 rows=1388889 width=25) (actual time=59.306..1360.784 rows=274267 loops=3)                                                       |
--                     Hash Cond: (mav.movie_id = m.id)                                                                                                                                   |
--                     Buffers: shared hit=13572 read=2251                                                                                                                                |
--                     ->  Parallel Bitmap Heap Scan on movies_attr_value mav  (cost=37781.76..118980.09 rows=1388889 width=18) (actual time=27.267..470.092 rows=274267 loops=3)         |
--                           Recheck Cond: (length((value_string)::text) < 10)                                                                                                            |
--                           Heap Blocks: exact=4437                                                                                                                                      |
--                           Buffers: shared hit=13359 read=2251                                                                                                                          |
--                           ->  Bitmap Index Scan on idx_movies_attr_value_name_value_string  (cost=0.00..36948.43 rows=3333333 width=0) (actual time=27.680..27.681 rows=822802 loops=1)|
--                                 Index Cond: (length((value_string)::text) < 10)                                                                                                        |
--                                 Buffers: shared read=2251                                                                                                                              |
--                     ->  Hash  (cost=171.00..171.00 rows=10000 width=15) (actual time=31.989..31.991 rows=10000 loops=3)                                                                |
--                           Buckets: 16384  Batches: 1  Memory Usage: 602kB                                                                                                              |
--                           Buffers: shared hit=213                                                                                                                                      |
--                           ->  Seq Scan on movies m  (cost=0.00..171.00 rows=10000 width=15) (actual time=0.014..16.009 rows=10000 loops=3)                                             |
--                                 Buffers: shared hit=213                                                                                                                                |
--               ->  Hash  (cost=17.00..17.00 rows=1000 width=15) (actual time=3.488..3.489 rows=1000 loops=3)                                                                            |
--                     Buckets: 1024  Batches: 1  Memory Usage: 56kB                                                                                                                      |
--                     Buffers: shared hit=21                                                                                                                                             |
--                     ->  Seq Scan on movies_attr ma  (cost=0.00..17.00 rows=1000 width=15) (actual time=0.015..1.728 rows=1000 loops=3)                                                 |
--                           Buffers: shared hit=21                                                                                                                                       |
-- Planning Time: 0.528 ms                                                                                                                                                                |
-- Execution Time: 5896.443 ms                                                                                                                                                            |

-- выигрыш по времени небольшой получился

-- пробовала добавлять покрывающие индексы по именам фильмов и именам атрибутов, но планировщик все равно использует полный перебор тк значений отновительно очень мало
create index idx_movies_name on movies (id, name);
create index idx_movies_attr_name on movies_attr (id, name);
drop index idx_movies_name;
drop index idx_movies_attr_name;

