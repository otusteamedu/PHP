-- блокировка мест
-- в этом варианте пусть будут ненумерованные места
-- нам нужны 2 любых свободных места на по цене 100 на сеанс id=2
update show_seats
set lock_id = '9af851a8-7570-4a19-9d59-96d977ce268b'
where id in (
    select id
    from show_seats
    where show_id = 1
      and lock_id is null
      and ticket_id is null
      and cost = 200
    limit 2
    for update skip locked
);

-- 10 тыс мест
call seed_show_seats(200, 1);

-- Update on show_seats  (cost=0.38..5.51 rows=2 width=353) (actual time=0.087..0.087 rows=0 loops=1)
--   ->  Nested Loop  (cost=0.38..5.51 rows=2 width=353) (actual time=0.026..0.030 rows=2 loops=1)
--         ->  Unique  (cost=0.09..0.10 rows=2 width=40) (actual time=0.021..0.022 rows=2 loops=1)
--               ->  Sort  (cost=0.09..0.10 rows=2 width=40) (actual time=0.021..0.021 rows=2 loops=1)
--                     Sort Key: "ANY_subquery".id
--                     Sort Method: quicksort  Memory: 25kB
--                     ->  Subquery Scan on "ANY_subquery"  (cost=0.00..0.08 rows=2 width=40) (actual time=0.015..0.017 rows=2 loops=1)
--                           ->  Limit  (cost=0.00..0.06 rows=2 width=14) (actual time=0.012..0.013 rows=2 loops=1)
--                                 ->  LockRows  (cost=0.00..323.98 rows=9998 width=14) (actual time=0.011..0.012 rows=2 loops=1)
--                                       ->  Seq Scan on show_seats show_seats_1  (cost=0.00..224.00 rows=9998 width=14) (actual time=0.006..0.007 rows=2 loops=1)
--                                             Filter: ((lock_id IS NULL) AND (ticket_id IS NULL) AND (show_id = 1) AND (cost = '200'::numeric))
--         ->  Index Scan using show_seats_pkey on show_seats  (cost=0.29..2.70 rows=1 width=47) (actual time=0.002..0.002 rows=1 loops=2)
--               Index Cond: (id = "ANY_subquery".id)
-- Planning Time: 0.612 ms
-- Execution Time: 0.116 ms

-- 10 млн мест
call seed_show_seats(200, int4range(2, 200));
call seed_show_seats(400, int4range(201, 400));
call seed_show_seats(600, int4range(401, 600));
call seed_show_seats(800, int4range(601, 800));
call seed_show_seats(1000, int4range(801, 1000));

-- Update on show_seats  (cost=6.28..11.56 rows=2 width=353) (actual time=0.641..0.641 rows=0 loops=1)
--   ->  Nested Loop  (cost=6.28..11.56 rows=2 width=353) (actual time=0.058..0.063 rows=2 loops=1)
--         ->  Unique  (cost=5.84..5.85 rows=2 width=40) (actual time=0.052..0.054 rows=2 loops=1)
--               ->  Sort  (cost=5.84..5.85 rows=2 width=40) (actual time=0.052..0.052 rows=2 loops=1)
--                     Sort Key: "ANY_subquery".id
--                     Sort Method: quicksort  Memory: 25kB
--                     ->  Subquery Scan on "ANY_subquery"  (cost=0.43..5.83 rows=2 width=40) (actual time=0.045..0.048 rows=2 loops=1)
--                           ->  Limit  (cost=0.43..5.81 rows=2 width=14) (actual time=0.042..0.044 rows=2 loops=1)
--                                 ->  LockRows  (cost=0.43..5219.55 rows=1941 width=14) (actual time=0.042..0.043 rows=2 loops=1)
--                                       ->  Index Scan using show_seats_unique on show_seats show_seats_1  (cost=0.43..5200.14 rows=1941 width=14) (actual time=0.037..0.037 rows=2 loops=1)
--                                             Index Cond: (show_id = 1)
--                                             Filter: ((lock_id IS NULL) AND (ticket_id IS NULL) AND (cost = '200'::numeric))
--                                             Rows Removed by Filter: 3
--         ->  Index Scan using show_seats_pkey on show_seats  (cost=0.43..2.85 rows=1 width=47) (actual time=0.003..0.003 rows=1 loops=2)
--               Index Cond: (id = "ANY_subquery".id)
-- Planning Time: 0.168 ms
-- Execution Time: 0.674 ms

-- добавим индекс (хотя здесь в принципе можно и не добавлять)
create index show_seats_show_cost_idx on show_seats (show_id, cost);

-- Update on show_seats  (cost=2.16..7.44 rows=2 width=353) (actual time=0.121..0.121 rows=0 loops=1)
--   ->  Nested Loop  (cost=2.16..7.44 rows=2 width=353) (actual time=0.056..0.060 rows=2 loops=1)
--         ->  Unique  (cost=1.72..1.73 rows=2 width=40) (actual time=0.051..0.052 rows=2 loops=1)
--               ->  Sort  (cost=1.72..1.73 rows=2 width=40) (actual time=0.050..0.051 rows=2 loops=1)
--                     Sort Key: "ANY_subquery".id
--                     Sort Method: quicksort  Memory: 25kB
--                     ->  Subquery Scan on "ANY_subquery"  (cost=0.56..1.71 rows=2 width=40) (actual time=0.044..0.046 rows=2 loops=1)
--                           ->  Limit  (cost=0.56..1.69 rows=2 width=14) (actual time=0.041..0.043 rows=2 loops=1)
--                                 ->  LockRows  (cost=0.56..1098.68 rows=1940 width=14) (actual time=0.041..0.042 rows=2 loops=1)
--                                       ->  Index Scan using show_seats_show_cost_idx on show_seats show_seats_1  (cost=0.56..1079.28 rows=1940 width=14) (actual time=0.035..0.036 rows=2 loops=1)
--                                             Index Cond: ((show_id = 1) AND (cost = '200'::numeric))
--                                             Filter: ((lock_id IS NULL) AND (ticket_id IS NULL))
--                                             Rows Removed by Filter: 2
--         ->  Index Scan using show_seats_pkey on show_seats  (cost=0.43..2.85 rows=1 width=47) (actual time=0.003..0.003 rows=1 loops=2)
--               Index Cond: (id = "ANY_subquery".id)
-- Planning Time: 0.185 ms
-- Execution Time: 0.157 ms

select get_table_size('show_seats');
-- total_size: 2224 MB, table_size: 612 MB, index_size: 1613 MB

select get_index_size('show_seats_show_cost_idx');
-- 301 MB
