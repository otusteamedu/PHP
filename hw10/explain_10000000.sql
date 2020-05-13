---------------------------------------------------------------------
-- 1. Все сеансы за определенный день
---------------------------------------------------------------------

    explain (analyze) 
    select s.hall_id, s.movie_id, s.date from sessions s 
    where s.date BETWEEN '2020-01-05 00:00:00' and '2020-01-05 23:59:59';

    -- Seq Scan on sessions s  (cost=0.00..1342.00 rows=85 width=16) (actual time=0.356..79.101 rows=99 loops=1)
    --   Filter: ((date >= '2020-01-05 00:00:00'::timestamp without time zone) AND (date <= '2020-01-05 23:59:59'::timestamp without time zone))
    --   Rows Removed by Filter: 59901
    -- Planning Time: 0.223 ms
    -- Execution Time: 79.154 ms

    -- Добавим индекс по дате.
    create index idx_session_date on sessions (date);

    -- Bitmap Heap Scan on sessions s  (cost=5.16..220.14 rows=85 width=16) (actual time=0.083..0.354 rows=99 loops=1)
    --   Recheck Cond: ((date >= '2020-01-05 00:00:00'::timestamp without time zone) AND (date <= '2020-01-05 23:59:59'::timestamp without time zone))
    --   Heap Blocks: exact=91
    --   ->  Bitmap Index Scan on idx_session_date  (cost=0.00..5.14 rows=85 width=0) (actual time=0.051..0.051 rows=99 loops=1)
    --         Index Cond: ((date >= '2020-01-05 00:00:00'::timestamp without time zone) AND (date <= '2020-01-05 23:59:59'::timestamp without time zone))
    -- Planning Time: 0.320 ms
    -- Execution Time: 0.403 ms

    -- Используется индекс, время выполнения снизилось, cost снизился.


---------------------------------------------------------------------
-- 2. Топ 100 фильмов по рейтингу
---------------------------------------------------------------------

    explain analyze
    select movies.name, float_value from movie_property_values mpv 
        left join movies on movies.id = mpv.movie
    where property = 12
    order by float_value desc 
    limit 100;

    -- Limit  (cost=0.85..94.23 rows=100 width=17) (actual time=5106.493..5108.750 rows=100 loops=1)
    --   ->  Nested Loop Left Join  (cost=0.85..283795.40 rows=303910 width=17) (actual time=5106.492..5108.717 rows=100 loops=1)
    --         ->  Index Scan Backward using idx_movie_prop_values_float on movie_property_values mpv  (cost=0.43..140251.05 rows=303910 width=10) (actual time=5106.433..5107.101 rows=100 loops=1)
    --               Filter: (property = 12)
    --               Rows Removed by Filter: 2682020
    --         ->  Index Scan using movies_pkey on movies  (cost=0.42..0.47 rows=1 width=15) (actual time=0.014..0.014 rows=1 loops=100)
    --               Index Cond: (id = mpv.movie)
    -- Planning Time: 1.092 ms
    -- Execution Time: 5108.879 ms

    -- Планировщик уже использует индексы, добавленные при создании таблиц.
    -- Однако для индекса idx_movie_prop_values_float применяется фильтрация по свойству. Добавим ID свойства в индекс.
    drop index idx_movie_prop_values_float;
    create index idx_movie_prop_values_float on movie_property_values (property, float_value);

    -- Limit  (cost=0.85..78.40 rows=100 width=17) (actual time=0.048..1.072 rows=100 loops=1)
    --   ->  Nested Loop Left Join  (cost=0.85..235677.35 rows=303910 width=17) (actual time=0.047..1.032 rows=100 loops=1)
    --         ->  Index Scan Backward using idx_movie_prop_values_float on movie_property_values mpv  (cost=0.43..92133.00 rows=303910 width=10) (actual time=0.031..0.218 rows=100 loops=1)
    --               Index Cond: (property = 12)
    --         ->  Index Scan using movies_pkey on movies  (cost=0.42..0.47 rows=1 width=15) (actual time=0.006..0.006 rows=1 loops=100)
    --               Index Cond: (id = mpv.movie)
    -- Planning Time: 0.727 ms
    -- Execution Time: 1.151 ms

    -- Время выполнения снизилось.


---------------------------------------------------------------------
-- 3. Все фильмы, у которых есть оскар
---------------------------------------------------------------------

    explain analyze 
    select movies.id, movies.name from movie_property_values mpv 
        left join movies on movies.id = mpv.movie
    where mpv.property = 1 and mpv.boolean_value = true;

    -- Gather  (cost=8009.02..30976.47 rows=204 width=15) (actual time=545.903..669.343 rows=2000 loops=1)
    --   Workers Planned: 2
    --   Workers Launched: 2
    --   ->  Nested Loop Left Join  (cost=7009.02..29956.07 rows=85 width=15) (actual time=509.716..593.819 rows=667 loops=3)
    --         ->  Parallel Bitmap Heap Scan on movie_property_values mpv  (cost=7008.59..29295.34 rows=85 width=4) (actual time=509.609..510.117 rows=667 loops=3)
    --               Recheck Cond: (property = 1)
    --               Filter: boolean_value
    --               Rows Removed by Filter: 99667
    --               Heap Blocks: exact=538
    --               ->  Bitmap Index Scan on idx_movie_prop_values_float  (cost=0.00..7008.54 rows=305615 width=0) (actual time=171.541..171.541 rows=301000 loops=1)
    --                     Index Cond: (property = 1)
    --         ->  Index Scan using movies_pkey on movies  (cost=0.42..7.77 rows=1 width=15) (actual time=0.124..0.124 rows=1 loops=2000)
    --               Index Cond: (id = mpv.movie)
    -- Planning Time: 10.832 ms
    -- Execution Time: 669.917 ms

    -- Добавим индекс.
    create index idx_boolean_prop on movie_property_values (property, boolean_value);

    -- Nested Loop Left Join  (cost=6.94..2346.52 rows=204 width=15) (actual time=0.423..36.278 rows=2000 loops=1)
    --   ->  Bitmap Heap Scan on movie_property_values mpv  (cost=6.52..760.75 rows=204 width=4) (actual time=0.410..5.694 rows=2000 loops=1)
    --         Recheck Cond: (property = 1)
    --         Filter: boolean_value
    --         Heap Blocks: exact=11
    --         ->  Bitmap Index Scan on idx_boolean_prop  (cost=0.00..6.47 rows=204 width=0) (actual time=0.375..0.376 rows=2000 loops=1)
    --               Index Cond: ((property = 1) AND (boolean_value = true))
    --   ->  Index Scan using movies_pkey on movies  (cost=0.42..7.77 rows=1 width=15) (actual time=0.010..0.010 rows=1 loops=2000)
    --         Index Cond: (id = mpv.movie)
    -- Planning Time: 0.497 ms
    -- Execution Time: 36.676 ms


---------------------------------------------------------------------
-- 4. Схема зрительного зала на конкретный сеанс, с выводом свободных и занятых мест
---------------------------------------------------------------------

    explain (analyze) 
    select halls.name, seats.row, seats.seat, basket.id::boolean as buyed from sessions
        left join halls on sessions.hall_id = halls.id
        left join seats on halls.id = seats.hall_id 
        left join basket on basket.seat_id = seats.id and basket.session_id = 196549
    where sessions.id=196549;

    -- Nested Loop Left Join  (cost=3.97..231.55 rows=39 width=223) (actual time=0.215..0.506 rows=90 loops=1)
    --   Join Filter: (halls.id = seats.hall_id)
    --   Rows Removed by Join Filter: 10
    --   ->  Nested Loop Left Join  (cost=0.29..9.37 rows=1 width=222) (actual time=0.043..0.045 rows=1 loops=1)
    --         Join Filter: (sessions.hall_id = halls.id)
    --         ->  Index Scan using sessions_pkey on sessions  (cost=0.29..8.31 rows=1 width=4) (actual time=0.016..0.017 rows=1 loops=1)
    --               Index Cond: (id = 196549)
    --         ->  Seq Scan on halls  (cost=0.00..1.03 rows=3 width=222) (actual time=0.020..0.020 rows=1 loops=1)
    --   ->  Hash Right Join  (cost=3.68..220.59 rows=119 width=12) (actual time=0.169..0.401 rows=100 loops=1)
    --         Hash Cond: (basket.seat_id = seats.id)
    --         ->  Index Scan using basket_unique on basket  (cost=0.43..217.02 rows=119 width=8) (actual time=0.020..0.132 rows=99 loops=1)
    --               Index Cond: (session_id = 196549)
    --         ->  Hash  (cost=2.00..2.00 rows=100 width=12) (actual time=0.136..0.136 rows=100 loops=1)
    --               Buckets: 1024  Batches: 1  Memory Usage: 13kB
    --               ->  Seq Scan on seats  (cost=0.00..2.00 rows=100 width=12) (actual time=0.015..0.067 rows=100 loops=1)
    -- Planning Time: 0.892 ms
    -- Execution Time: 0.603 ms

    -- Запрос уже использует индексы, добавленные при создании таблиц. 
    -- Не очень хорошо что используется несколько вложенных циклов. Попробуем переписать запрос, например с использованием подзапроса.

    explain (analyze)
    select halls.name, seats.row, seats.seat, basket.id::boolean as buyed from seats 
        left join halls on seats.hall_id = halls.id
        left join basket on basket.seat_id = seats.id and basket.session_id = 196549
    where halls.id = (select sessions.hall_id from sessions where id=196549);

    -- Nested Loop  (cost=11.61..230.31 rows=60 width=223) (actual time=0.182..0.384 rows=90 loops=1)
    --   InitPlan 1 (returns $0)
    --     ->  Index Scan using sessions_pkey on sessions  (cost=0.29..8.31 rows=1 width=4) (actual time=0.010..0.011 rows=1 loops=1)
    --           Index Cond: (id = 196549)
    --   ->  Seq Scan on halls  (cost=0.00..1.04 rows=1 width=222) (actual time=0.023..0.024 rows=1 loops=1)
    --         Filter: (id = $0)
    --         Rows Removed by Filter: 2
    --   ->  Hash Right Join  (cost=3.31..220.21 rows=60 width=12) (actual time=0.156..0.316 rows=90 loops=1)
    --         Hash Cond: (basket.seat_id = seats.id)
    --         ->  Index Scan using basket_unique on basket  (cost=0.43..217.02 rows=119 width=8) (actual time=0.016..0.071 rows=99 loops=1)
    --               Index Cond: (session_id = 196549)
    --         ->  Hash  (cost=2.25..2.25 rows=50 width=12) (actual time=0.132..0.132 rows=90 loops=1)
    --               Buckets: 1024  Batches: 1  Memory Usage: 12kB
    --               ->  Seq Scan on seats  (cost=0.00..2.25 rows=50 width=12) (actual time=0.013..0.074 rows=90 loops=1)
    --                     Filter: (hall_id = $0)
    --                     Rows Removed by Filter: 10
    -- Planning Time: 0.598 ms
    -- Execution Time: 0.455 ms

    -- Время выполнения незначительно уменьшилось, cost остался прежним.

---------------------------------------------------------------------
-- 5. В каком месяце люди чаще всего ходят в кино
---------------------------------------------------------------------

    explain analyze
    select count(*) as count, date_part('month', S.date) as month_number from basket B
        left join sessions S on S.id = B.session_id 
    group by month_number
    order by count desc limit 1;

    -- Limit  (cost=112484.61..112484.61 rows=1 width=16) (actual time=28939.240..28939.241 rows=1 loops=1)
    --   ->  Sort  (cost=112484.61..112634.61 rows=60000 width=16) (actual time=28867.496..28867.496 rows=1 loops=1)
    --         Sort Key: (count(*)) DESC
    --         Sort Method: top-N heapsort  Memory: 25kB
    --         ->  Finalize GroupAggregate  (cost=96833.63..112184.61 rows=60000 width=16) (actual time=28867.433..28867.472 rows=12 loops=1)
    --               Group Key: (date_part('month'::text, s.date))
    --               ->  Gather Merge  (cost=96833.63..110834.61 rows=120000 width=16) (actual time=28867.400..28905.955 rows=36 loops=1)
    --                     Workers Planned: 2
    --                     Workers Launched: 2
    --                     ->  Sort  (cost=95833.61..95983.61 rows=60000 width=16) (actual time=28446.454..28446.458 rows=12 loops=3)
    --                           Sort Key: (date_part('month'::text, s.date))
    --                           Sort Method: quicksort  Memory: 25kB
    --                           Worker 0:  Sort Method: quicksort  Memory: 25kB
    --                           Worker 1:  Sort Method: quicksort  Memory: 25kB
    --                           ->  Partial HashAggregate  (cost=90321.81..91071.81 rows=60000 width=16) (actual time=28444.019..28446.404 rows=12 loops=3)
    --                                 Group Key: date_part('month'::text, s.date)
    --                                 ->  Hash Left Join  (cost=1792.00..77821.85 rows=2499992 width=8) (actual time=581.475..20977.320 rows=1983333 loops=3)
    --                                       Hash Cond: (b.session_id = s.id)
    --                                       ->  Parallel Seq Scan on basket b  (cost=0.00..63216.92 rows=2499992 width=4) (actual time=0.060..5385.339 rows=1983333 loops=3)
    --                                       ->  Hash  (cost=1042.00..1042.00 rows=60000 width=12) (actual time=573.111..573.111 rows=60000 loops=3)
    --                                             Buckets: 65536  Batches: 1  Memory Usage: 3091kB
    --                                             ->  Seq Scan on sessions s  (cost=0.00..1042.00 rows=60000 width=12) (actual time=123.033..297.076 rows=60000 loops=3)
    -- Planning Time: 0.539 ms
    -- JIT:
    --   Functions: 49
    --   Options: Inlining false, Optimization false, Expressions true, Deforming true
    --   Timing: Generation 89.913 ms, Inlining 0.000 ms, Optimization 13.451 ms, Emission 425.911 ms, Total 529.274 ms
    -- Execution Time: 28988.772 ms

    -- Попробуем добавить функциональный индекс, заранее рассчитав месяц в дате
    create index idx_session_month on sessions(date_part('month', sessions.date));

    -- План запроса вообще никак не изменился, индекс не используется.
    -- Данный индекс был бы полезен при условии where по месяцу, а здесь планировщик предпочитает обходить таблицу целиком.
    -- Удалим индекс.
    drop index idx_session_month;

    -- Попробуем поменять настройки, увеличив количество воркеров (max_parallel_workers_per_gather)

    -- Limit  (cost=107694.85..107694.86 rows=1 width=16) (actual time=30445.316..30445.317 rows=1 loops=1)
    --   ->  Sort  (cost=107694.85..107844.85 rows=60000 width=16) (actual time=30378.808..30378.808 rows=1 loops=1)
    --         Sort Key: (count(*)) DESC
    --         Sort Method: top-N heapsort  Memory: 25kB
    --         ->  Finalize GroupAggregate  (cost=76708.54..107394.85 rows=60000 width=16) (actual time=30378.381..30378.782 rows=12 loops=1)
    --               Group Key: (date_part('month'::text, s.date))
    --               ->  Gather Merge  (cost=76708.54..105444.85 rows=240000 width=16) (actual time=30370.466..30409.234 rows=60 loops=1)
    --                     Workers Planned: 4
    --                     Workers Launched: 4
    --                     ->  Sort  (cost=75708.48..75858.48 rows=60000 width=16) (actual time=29483.248..29483.253 rows=12 loops=5)
    --                           Sort Key: (date_part('month'::text, s.date))
    --                           Sort Method: quicksort  Memory: 25kB
    --                           Worker 0:  Sort Method: quicksort  Memory: 25kB
    --                           Worker 1:  Sort Method: quicksort  Memory: 25kB
    --                           Worker 2:  Sort Method: quicksort  Memory: 25kB
    --                           Worker 3:  Sort Method: quicksort  Memory: 25kB
    --                           ->  Partial HashAggregate  (cost=70196.68..70946.68 rows=60000 width=16) (actual time=29479.605..29483.185 rows=12 loops=5)
    --                                 Group Key: date_part('month'::text, s.date)
    --                                 ->  Hash Left Join  (cost=1792.00..62696.71 rows=1499995 width=8) (actual time=1036.587..21744.116 rows=1190000 loops=5)
    --                                       Hash Cond: (b.session_id = s.id)
    --                                       ->  Parallel Seq Scan on basket b  (cost=0.00..53216.95 rows=1499995 width=4) (actual time=6.593..5811.511 rows=1190000 loops=5)
    --                                       ->  Hash  (cost=1042.00..1042.00 rows=60000 width=12) (actual time=1029.636..1029.637 rows=60000 loops=5)
    --                                             Buckets: 65536  Batches: 1  Memory Usage: 3091kB
    --                                             ->  Seq Scan on sessions s  (cost=0.00..1042.00 rows=60000 width=12) (actual time=253.331..629.227 rows=60000 loops=5)
    -- Planning Time: 0.470 ms
    -- JIT:
    --   Functions: 79
    --   Options: Inlining false, Optimization false, Expressions true, Deforming true
    --   Timing: Generation 321.886 ms, Inlining 0.000 ms, Optimization 37.613 ms, Emission 1290.092 ms, Total 1649.591 ms
    -- Execution Time: 30486.850 ms

    -- Время выполнения даже увеличилось, вернем настройки на место.
    -- В целом запрос крайне тяжелый, планировщик даже задействовал JIT-компиляцию.
    -- Выполнять такое на работающей oltp-таблице неразумно.
    -- Если уж нужна такая аналитика, можно создать отдельную olap-таблицу для хранения статистики по месяцам, 
    -- и обновлять её по завершении месяца например, в моменты наименьшей нагрузки.


---------------------------------------------------------------------
-- 6. Самый прибыльный сеанс
---------------------------------------------------------------------

    explain analyze
    select sum(price) as total, session_id from basket 
    group by session_id 
    order by total desc 
    limit 1;

    -- Limit  (cost=236423.91..236423.91 rows=1 width=36) (actual time=24193.433..24193.433 rows=1 loops=1)
    --   ->  Sort  (cost=236423.91..236549.46 rows=50220 width=36) (actual time=24157.943..24157.944 rows=1 loops=1)
    --         Sort Key: (sum(price)) DESC
    --         Sort Method: top-N heapsort  Memory: 25kB
    --         ->  Finalize GroupAggregate  (cost=1000.46..236172.81 rows=50220 width=36) (actual time=485.859..24079.194 rows=60000 loops=1)
    --               Group Key: session_id
    --               ->  Gather Merge  (cost=1000.46..234791.76 rows=100440 width=36) (actual time=485.701..23751.336 rows=67615 loops=1)
    --                     Workers Planned: 2
    --                     Workers Launched: 2
    --                     ->  Partial GroupAggregate  (cost=0.43..222198.47 rows=50220 width=36) (actual time=45.743..7441.044 rows=22538 loops=3)
    --                           Group Key: session_id
    --                           ->  Parallel Index Scan using basket_unique on basket  (cost=0.43..209070.76 rows=2499992 width=9) (actual time=6.703..3542.657 rows=1983333 loops=3)
    -- Planning Time: 0.139 ms
    -- JIT:
    --   Functions: 19
    --   Options: Inlining false, Optimization false, Expressions true, Deforming true
    --   Timing: Generation 43.600 ms, Inlining 0.000 ms, Optimization 2.154 ms, Emission 146.622 ms, Total 192.376 ms
    -- Execution Time: 24265.135 ms

    -- Попробовал создать разные индексы и поэкспериментировать с настройками, но они не изменили план выполнения.

    -- create index idx_basket_price on basket (price);
    -- create index idx_basket_session on basket (session_id);
    -- create index idx_basket_session_price on basket (session_id, price);

    -- В целом, как и в предыдущем пункте, здесь лучше агрегировать нужные данные в аналитических таблицах, и строить отчеты по ним.


---------------------------------------------------------------------
-- 7. 15 самых больших объектов БД
---------------------------------------------------------------------

    select relname as entity, pg_size_pretty(pg_relation_size(c.oid)) as size from pg_class c
        left join pg_namespace n on (n.oid = c.relnamespace)
    where nspname not in ('pg_catalog', 'information_schema')
    order by pg_relation_size(c.oid) desc
    limit 15;

    -- entity                       |size   |
    -- -----------------------------|-------|
    -- basket                       |299 MB |
    -- movie_property_values        |162 MB |
    -- basket_pkey                  |129 MB |
    -- basket_unique                |128 MB |
    -- idx_movie_prop_values_float  |91 MB  |
    -- idx_movie_prop_values        |90 MB  |
    -- movie_property_unique        |90 MB  |
    -- idx_boolean_prop             |88 MB  |
    -- idx_movie_prop_values_integer|69 MB  |
    -- idx_movie_prop_values_dates  |65 MB  |
    -- movie_property_values_pkey   |64 MB  |
    -- movies                       |13 MB  |
    -- idx_movie_name               |9280 kB|
    -- movies_pkey                  |6624 kB|
    -- sessions                     |3536 kB|


---------------------------------------------------------------------
-- 8. Самые часто используемые индексы
---------------------------------------------------------------------

    select
        idstat.relname as table_name,                                   -- имя таблицы
        indexrelname as index_name,                                     -- индекс
        idstat.idx_scan as index_scans_count,                           -- число сканирований по этому индексу
        pg_size_pretty(pg_relation_size(indexrelid)) as index_size,     -- размер индекса
        tabstat.idx_scan as table_reads_index_count,                    -- индексных чтений по таблице
        tabstat.seq_scan as table_reads_seq_count,                      -- последовательных чтений по таблице
        tabstat.seq_scan + tabstat.idx_scan as table_reads_count,       -- чтений по таблице
        n_tup_upd + n_tup_ins + n_tup_del as table_writes_count,        -- операций записи
        pg_size_pretty(pg_relation_size(idstat.relid)) as table_size    -- размер таблицы
    from
        pg_stat_user_indexes as idstat
    join
        pg_indexes
        on
        indexrelname = indexname
        and
        idstat.schemaname = pg_indexes.schemaname
    join
        pg_stat_user_tables as tabstat
        on
        idstat.relid = tabstat.relid
    where
        indexdef !~* 'unique'
    order by
        idstat.idx_scan desc,
        pg_relation_size(indexrelid) desc;

    -- table_name           |index_name                   |index_scans_count|index_size|table_reads_index_count|table_reads_seq_count|table_reads_count|table_writes_count|table_size|
    -- ---------------------|-----------------------------|-----------------|----------|-----------------------|---------------------|-----------------|------------------|----------|
    -- sessions             |idx_session_movie_id         |                8|1352 kB   |                     12|                    0|               12|                 0|3536 kB   |
    -- movies               |idx_movie_name               |                4|9280 kB   |                      8|                    0|                8|                 0|13 MB     |
    -- movie_property_values|idx_movie_prop_values_float  |                0|91 MB     |                      0|                    0|                0|                 0|162 MB    |
    -- movie_property_values|idx_movie_prop_values        |                0|90 MB     |                      0|                    0|                0|                 0|162 MB    |
    -- movie_property_values|idx_boolean_prop             |                0|88 MB     |                      0|                    0|                0|                 0|162 MB    |
    -- movie_property_values|idx_movie_prop_values_integer|                0|69 MB     |                      0|                    0|                0|                 0|162 MB    |
    -- movie_property_values|idx_movie_prop_values_dates  |                0|65 MB     |                      0|                    0|                0|                 0|162 MB    |
    -- sessions             |idx_session_date             |                0|1328 kB   |                     12|                    0|               12|                 0|3536 kB   |
    -- property_types       |idx_prop_type_code           |                0|16 kB     |                      0|                    0|                0|                 0|8192 bytes|
    -- movie_properties     |idx_movie_prop_type          |                0|16 kB     |                      0|                    0|                0|                 0|8192 bytes|