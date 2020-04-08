-- поиск фильма по названию
select id, name
from movies
where actual = true
  and to_tsvector('russian', name) @@ to_tsquery('russian', 'бэтмен:*')
;

-- 10 тыс записей
copy movies (name) from program 'cat /dev/urandom | tr -dc "a-zA-Z0-9 " | fold -w 128 | head -n 10000';

-- Seq Scan on movies  (cost=0.00..995.77 rows=30 width=520) (actual time=0.012..126.761 rows=5 loops=1)
--   Filter: (actual AND (to_tsvector('russian'::regconfig, (name)::text) @@ '''бэтм'':*'::tsquery))
--   Rows Removed by Filter: 10000
-- Planning Time: 0.067 ms
-- Execution Time: 126.772 ms


-- 10 млн записей
copy movies (name) from program 'cat /dev/urandom | tr -dc "a-zA-Z0-9 " | fold -w 128 | head -n 9990000';

-- Gather  (cost=1000.00..542542.64 rows=29787 width=520) (actual time=157.724..79190.700 rows=5 loops=1)
--   Workers Planned: 2
--   Workers Launched: 2
--   ->  Parallel Seq Scan on movies  (cost=0.00..538563.94 rows=12411 width=520) (actual time=52772.793..79113.408 rows=2 loops=3)
--         Filter: (actual AND (to_tsvector('russian'::regconfig, (name)::text) @@ '''бэтм'':*'::tsquery))
--         Rows Removed by Filter: 3333333
-- Planning Time: 2.166 ms
-- JIT:
--   Functions: 12
--   Options: Inlining true, Optimization true, Expressions true, Deforming true
--   Timing: Generation 10.763 ms, Inlining 153.184 ms, Optimization 74.269 ms, Emission 81.734 ms, Total 319.950 ms
-- Execution Time: 79194.132 ms

-- добавляем индекс
create index movies_name_search on movies using gin (to_tsvector('russian', name)) where actual = true;

-- Gather  (cost=2650.80..741596.51 rows=200000 width=136) (actual time=33.403..50.836 rows=5 loops=1)
--   Workers Planned: 2
--   Workers Launched: 2
--   ->  Parallel Bitmap Heap Scan on movies  (cost=1650.80..720596.51 rows=83333 width=136) (actual time=11.084..11.085 rows=2 loops=3)
--         Recheck Cond: ((to_tsvector('russian'::regconfig, (name)::text) @@ '''бэтм'':*'::tsquery) AND actual)
--         Heap Blocks: exact=1
--         ->  Bitmap Index Scan on movies_name_search  (cost=0.00..1600.80 rows=200000 width=0) (actual time=0.013..0.013 rows=5 loops=1)
--               Index Cond: (to_tsvector('russian'::regconfig, (name)::text) @@ '''бэтм'':*'::tsquery)
-- Planning Time: 0.087 ms
-- JIT:
--   Functions: 12
--   Options: Inlining true, Optimization true, Expressions true, Deforming true
--   Timing: Generation 1.094 ms, Inlining 2.623 ms, Optimization 19.643 ms, Emission 10.686 ms, Total 34.046 ms
-- Execution Time: 51.306 ms

select get_table_size('movies');
-- total_size: 4943 MB, table_size: 1663 MB, index_size: 3281 MB

select get_index_size('movies_name_search');
-- 2742 MB
