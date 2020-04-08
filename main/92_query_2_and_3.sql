-- расписание для фильма
select id, start_at
from shows
where status = 'actual'
  and movie_id = 1
  and start_at > now()
order by start_at
;

-- расписание на сегодня
select m.id as movie_id, s.id as show_id, s.start_at
from shows s
inner join movies m on s.movie_id = m.id
where m.actual
  and s.status = 'actual'
  and start_at between now() and current_date + interval '1 day'
order by start_at
;

-- 10 тыс записей (примерно, с учетом ограничения по уникальности на дату/время)
call seed_shows(10000, 100, 4);

-- расписание для фильма
-- Sort  (cost=41.68..41.69 rows=1 width=12) (actual time=1.037..1.038 rows=14 loops=1)
--   Sort Key: start_at
--   Sort Method: quicksort  Memory: 25kB
--   ->  Bitmap Heap Scan on shows  (cost=1.60..41.67 rows=1 width=12) (actual time=0.307..1.029 rows=14 loops=1)
--         Recheck Cond: (status = 'actual'::shows_status)
--         Filter: ((movie_id = 1) AND (start_at > now()))
--         Rows Removed by Filter: 9713
--         Heap Blocks: exact=72
--         ->  Bitmap Index Scan on shows_unique_timerange  (cost=0.00..1.59 rows=49 width=0) (actual time=0.292..0.292 rows=9727 loops=1)
-- Planning Time: 0.091 ms
-- Execution Time: 1.059 ms

-- расписание на сегодня
-- Sort  (cost=320.89..320.90 rows=2 width=16) (actual time=1.646..1.647 rows=3 loops=1)
--   Sort Key: s.start_at
--   Sort Method: quicksort  Memory: 25kB
--   ->  Nested Loop  (cost=0.43..320.88 rows=2 width=16) (actual time=0.320..1.641 rows=3 loops=1)
--         ->  Seq Scan on shows s  (cost=0.00..315.18 rows=2 width=16) (actual time=0.313..1.625 rows=3 loops=1)
--               Filter: ((status = 'actual'::shows_status) AND (start_at >= now()) AND (start_at <= (CURRENT_DATE + '1 day'::interval)))
--               Rows Removed by Filter: 9724
--         ->  Index Scan using movies_pkey on movies m  (cost=0.43..2.85 rows=1 width=4) (actual time=0.004..0.004 rows=1 loops=3)
--               Index Cond: (id = s.movie_id)
--               Filter: actual
-- Planning Time: 0.176 ms
-- Execution Time: 1.672 ms

-- 8760 часовых показов в одном зале за год максимум
-- 10 залов и 10 лет = 876_000
-- этот запрос сгенерит нам меньше записей (~600 тыс) - для тестовых целей хватит
call seed_shows(1000000, 10000, 10);

-- расписание для фильма
-- Gather Merge  (cost=9259.22..9312.42 rows=456 width=12) (actual time=55.378..58.185 rows=20 loops=1)
--   Workers Planned: 2
--   Workers Launched: 2
--   ->  Sort  (cost=8259.20..8259.77 rows=228 width=12) (actual time=21.783..21.784 rows=7 loops=3)
--         Sort Key: start_at
--         Sort Method: quicksort  Memory: 25kB
--         Worker 0:  Sort Method: quicksort  Memory: 25kB
--         Worker 1:  Sort Method: quicksort  Memory: 25kB
--         ->  Parallel Seq Scan on shows  (cost=0.00..8250.27 rows=228 width=12) (actual time=4.314..21.712 rows=7 loops=3)
--               Filter: ((status = 'actual'::shows_status) AND (movie_id = 1) AND (start_at > now()))
--               Rows Removed by Filter: 175928
-- Planning Time: 0.093 ms
-- Execution Time: 58.205 ms

-- расписание на сегодня
-- Gather Merge  (cost=10485.49..10494.12 rows=74 width=16) (actual time=70.887..75.833 rows=79 loops=1)
--   Workers Planned: 2
--   Workers Launched: 2
--   ->  Sort  (cost=9485.46..9485.56 rows=37 width=16) (actual time=45.305..45.309 rows=26 loops=3)
--         Sort Key: s.start_at
--         Sort Method: quicksort  Memory: 26kB
--         Worker 0:  Sort Method: quicksort  Memory: 25kB
--         Worker 1:  Sort Method: quicksort  Memory: 26kB
--         ->  Nested Loop  (cost=0.43..9484.50 rows=37 width=16) (actual time=1.416..45.271 rows=26 loops=3)
--               ->  Parallel Seq Scan on shows s  (cost=0.00..9378.96 rows=37 width=16) (actual time=1.398..45.065 rows=26 loops=3)
--                     Filter: ((status = 'actual'::shows_status) AND (start_at >= now()) AND (start_at <= (CURRENT_DATE + '1 day'::interval)))
--                     Rows Removed by Filter: 175908
--               ->  Index Scan using movies_pkey on movies m  (cost=0.43..2.85 rows=1 width=4) (actual time=0.006..0.006 rows=1 loops=79)
--                     Index Cond: (id = s.movie_id)
--                     Filter: actual
-- Planning Time: 0.171 ms
-- Execution Time: 75.863 ms

-- добавляем индекс по id фильма
create index shows_movie_idx on shows (movie_id);

-- добавляем индекс по start_at
create index shows_start_idx on shows (start_at desc) where status = 'actual';

-- расписание для фильма
-- Sort  (cost=207.14..207.18 rows=18 width=12) (actual time=0.199..0.200 rows=20 loops=1)
--   Sort Key: start_at
--   Sort Method: quicksort  Memory: 25kB
--   ->  Bitmap Heap Scan on shows  (cost=2.95..206.76 rows=18 width=12) (actual time=0.032..0.190 rows=20 loops=1)
--         Recheck Cond: (movie_id = 1)
--         Filter: ((status = 'actual'::shows_status) AND (start_at > now()))
--         Rows Removed by Filter: 132
--         Heap Blocks: exact=107
--         ->  Bitmap Index Scan on shows_movie_idx  (cost=0.00..2.94 rows=176 width=0) (actual time=0.019..0.019 rows=152 loops=1)
--               Index Cond: (movie_id = 1)
-- Planning Time: 0.107 ms
-- Execution Time: 0.220 ms

-- расписание на сегодня
-- Nested Loop  (cost=0.87..355.94 rows=87 width=16) (actual time=0.022..0.271 rows=78 loops=1)
--   ->  Index Scan Backward using shows_start_idx on shows s  (cost=0.43..107.77 rows=87 width=16) (actual time=0.015..0.085 rows=78 loops=1)
--         Index Cond: ((start_at >= now()) AND (start_at <= (CURRENT_DATE + '1 day'::interval)))
--   ->  Index Scan using movies_pkey on movies m  (cost=0.43..2.85 rows=1 width=4) (actual time=0.002..0.002 rows=1 loops=78)
--         Index Cond: (id = s.movie_id)
--         Filter: actual
-- Planning Time: 0.220 ms
-- Execution Time: 0.289 ms

select get_table_size('shows');
-- total_size: 107 MB, table_size: 30 MB, index_size: 77 MB

select get_index_size('shows_movie_idx');
--  11 MB

select get_index_size('shows_start_idx');
-- 11 MB
