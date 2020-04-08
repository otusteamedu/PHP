-- здесь проверим 2 вьюхи по eav для movies

select * from tasks;
select * from marketing where movie_id = 1;

-- 10 тыс записей
call seed_movies_eav(6, 10000);

-- select * from tasks;
-- GroupAggregate  (cost=923.03..924.08 rows=20 width=196) (actual time=3.489..3.577 rows=57 loops=1)
--   Group Key: m.name
--   ->  Sort  (cost=923.03..923.08 rows=20 width=284) (actual time=3.479..3.482 rows=59 loops=1)
--         Sort Key: m.name
--         Sort Method: quicksort  Memory: 40kB
--         ->  Nested Loop  (cost=0.58..922.60 rows=20 width=284) (actual time=0.017..3.421 rows=59 loops=1)
--               ->  Nested Loop  (cost=0.43..904.89 rows=20 width=144) (actual time=0.014..3.353 rows=59 loops=1)
--                     ->  Seq Scan on movie_values mav  (cost=0.00..847.84 rows=20 width=16) (actual time=0.009..3.192 rows=59 loops=1)
--                           Filter: ((date IS NOT NULL) AND (date >= CURRENT_DATE) AND (date <= (CURRENT_DATE + '20 days'::interval)))
--                           Rows Removed by Filter: 29934
--                     ->  Index Scan using movies_pkey on movies m  (cost=0.43..2.85 rows=1 width=136) (actual time=0.002..0.002 rows=1 loops=59)
--                           Index Cond: (id = mav.movie_id)
--               ->  Index Scan using movie_attrs_pkey on movie_attrs ma  (cost=0.15..0.89 rows=1 width=148) (actual time=0.001..0.001 rows=1 loops=59)
--                     Index Cond: (id = mav.attr_id)
-- Planning Time: 0.322 ms
-- Execution Time: 3.611 ms

-- select * from marketing where movie_id = 1;
-- Nested Loop  (cost=0.87..15.16 rows=4 width=312) (actual time=0.019..0.029 rows=4 loops=1)
--   ->  Index Scan using movies_pkey on movies m  (cost=0.43..2.85 rows=1 width=136) (actual time=0.008..0.008 rows=1 loops=1)
--         Index Cond: (id = 1)
--   ->  Nested Loop  (cost=0.43..12.20 rows=4 width=178) (actual time=0.009..0.014 rows=4 loops=1)
--         ->  Index Scan using movie_values_unique on movie_values mav  (cost=0.29..4.33 rows=4 width=38) (actual time=0.004..0.005 rows=4 loops=1)
--               Index Cond: (movie_id = 1)
--         ->  Index Scan using movie_attrs_pkey on movie_attrs ma  (cost=0.15..1.96 rows=1 width=148) (actual time=0.001..0.001 rows=1 loops=4)
--               Index Cond: (id = mav.attr_id)
-- Planning Time: 0.185 ms
-- Execution Time: 0.050 ms

-- 10 млн записей
call seed_movies_eav(10001, 10000000);

-- select * from tasks;
-- GroupAggregate  (cost=478616.63..479658.54 rows=19846 width=196) (actual time=7218.195..7292.223 rows=53916 loops=1)
--   Group Key: m.name
--   ->  Sort  (cost=478616.63..478666.24 rows=19846 width=284) (actual time=7218.171..7231.682 rows=53918 loops=1)
--         Sort Key: m.name
--         Sort Method: external merge  Disk: 8816kB
--         ->  Gather  (cost=1020.56..477199.97 rows=19846 width=284) (actual time=11.067..7079.920 rows=53918 loops=1)
--               Workers Planned: 2
--               Workers Launched: 2
--               ->  Hash Join  (cost=20.56..474215.37 rows=8269 width=284) (actual time=10.486..7079.930 rows=17973 loops=3)
--                     Hash Cond: (mav.attr_id = ma.id)
--                     ->  Nested Loop  (cost=0.43..474173.33 rows=8269 width=144) (actual time=9.272..7061.077 rows=17973 loops=3)
--                           ->  Parallel Seq Scan on movie_values mav  (cost=0.00..453664.45 rows=8269 width=16) (actual time=8.933..2372.742 rows=17973 loops=3)
--                                 Filter: ((date IS NOT NULL) AND (date >= CURRENT_DATE) AND (date <= (CURRENT_DATE + '20 days'::interval)))
--                                 Rows Removed by Filter: 9982025
--                           ->  Index Scan using movies_pkey on movies m  (cost=0.43..2.48 rows=1 width=136) (actual time=0.259..0.259 rows=1 loops=53918)
--                                 Index Cond: (id = mav.movie_id)
--                     ->  Hash  (cost=14.50..14.50 rows=450 width=148) (actual time=0.141..0.141 rows=8 loops=3)
--                           Buckets: 1024  Batches: 1  Memory Usage: 9kB
--                           ->  Seq Scan on movie_attrs ma  (cost=0.00..14.50 rows=450 width=148) (actual time=0.134..0.135 rows=8 loops=3)
-- Planning Time: 4.181 ms
-- JIT:
--   Functions: 53
--   Options: Inlining false, Optimization false, Expressions true, Deforming true
--   Timing: Generation 7.582 ms, Inlining 0.000 ms, Optimization 1.109 ms, Emission 24.802 ms, Total 33.493 ms
-- Execution Time: 7297.331 ms

-- select * from marketing where movie_id = 1;
-- Nested Loop  (cost=1.02..25.99 rows=12 width=312) (actual time=0.026..0.036 rows=4 loops=1)
--   ->  Index Scan using movies_pkey on movies m  (cost=0.43..2.85 rows=1 width=136) (actual time=0.012..0.012 rows=1 loops=1)
--         Index Cond: (id = 1)
--   ->  Nested Loop  (cost=0.58..22.81 rows=12 width=178) (actual time=0.012..0.017 rows=4 loops=1)
--         ->  Index Scan using movie_values_unique on movie_values mav  (cost=0.44..8.82 rows=12 width=38) (actual time=0.007..0.008 rows=4 loops=1)
--               Index Cond: (movie_id = 1)
--         ->  Index Scan using movie_attrs_pkey on movie_attrs ma  (cost=0.15..1.16 rows=1 width=148) (actual time=0.001..0.001 rows=1 loops=4)
--               Index Cond: (id = mav.attr_id)
-- Planning Time: 0.154 ms
-- Execution Time: 0.058 ms

-- создадим индекс по датам для tasks
create index view_tasks_idx on movie_values (date desc) where date is not null;

-- GroupAggregate  (cost=81853.73..82895.65 rows=19846 width=196) (actual time=475.272..558.094 rows=53916 loops=1)
--   Group Key: m.name
--   ->  Sort  (cost=81853.73..81903.35 rows=19846 width=284) (actual time=475.257..488.829 rows=53918 loops=1)
--         Sort Key: m.name
--         Sort Method: external merge  Disk: 8816kB
--         ->  Gather  (cost=1819.81..80437.07 rows=19846 width=284) (actual time=27.520..369.482 rows=53918 loops=1)
--               Workers Planned: 2
--               Workers Launched: 2
--               ->  Hash Join  (cost=819.81..77452.47 rows=8269 width=284) (actual time=9.240..335.611 rows=17973 loops=3)
--                     Hash Cond: (mav.attr_id = ma.id)
--                     ->  Nested Loop  (cost=799.69..77410.44 rows=8269 width=144) (actual time=9.138..328.795 rows=17973 loops=3)
--                           ->  Parallel Bitmap Heap Scan on movie_values mav  (cost=799.25..56901.55 rows=8269 width=16) (actual time=9.107..91.295 rows=17973 loops=3)
--                                 Recheck Cond: ((date >= CURRENT_DATE) AND (date <= (CURRENT_DATE + '20 days'::interval)))
--                                 Heap Blocks: exact=17980
--                                 ->  Bitmap Index Scan on view_tasks_idx  (cost=0.00..794.29 rows=59705 width=0) (actual time=14.561..14.561 rows=53918 loops=1)
--                                       Index Cond: ((date >= CURRENT_DATE) AND (date <= (CURRENT_DATE + '20 days'::interval)))
--                           ->  Index Scan using movies_pkey on movies m  (cost=0.43..2.48 rows=1 width=136) (actual time=0.013..0.013 rows=1 loops=53918)
--                                 Index Cond: (id = mav.movie_id)
--                     ->  Hash  (cost=14.50..14.50 rows=450 width=148) (actual time=0.015..0.015 rows=8 loops=3)
--                           Buckets: 1024  Batches: 1  Memory Usage: 9kB
--                           ->  Seq Scan on movie_attrs ma  (cost=0.00..14.50 rows=450 width=148) (actual time=0.009..0.010 rows=8 loops=3)
-- Planning Time: 0.375 ms
-- Execution Time: 563.103 ms

-- при желании можно еще материализовать
create materialized view tasks_materialized as
select * from tasks;

-- обновлять по крону
refresh materialized view tasks_materialized;

select * from tasks_materialized;
-- Seq Scan on tasks_materialized  (cost=0.00..1726.56 rows=52756 width=157) (actual time=0.007..5.179 rows=53916 loops=1)
-- Planning Time: 0.025 ms
-- Execution Time: 6.908 ms

select get_table_size('movie_values');
-- total_size: 2204 MB, table_size: 1347 MB, index_size: 857 MB

select get_index_size('view_tasks_idx');
-- 214 MB
