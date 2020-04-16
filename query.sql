Create or replace function random_string(length integer) returns text as
$$
declare
    chars text[] := '{0,1,2,3,4,5,6,7,8,9,A,B,C,D,E,F,G,H,I,J,K,L,M,N,O,P,Q,R,S,T,U,V,W,X,Y,Z,a,b,c,d,e,f,g,h,i,j,k,l,m,n,o,p,q,r,s,t,u,v,w,x,y,z}';
    result text := '';
    i integer := 0;
begin
    if length < 0 then
        raise exception 'Given length cannot be less than 0';
    end if;
    for i in 1..length loop
            result := result || chars[1+random()*(array_length(chars, 1)-1)];
        end loop;
    return result;
end;
$$ language plpgsql;

CREATE OR REPLACE FUNCTION random_between(low INT ,high INT)
    RETURNS INT AS
$$
BEGIN
    RETURN floor(random()* (high-low + 1) + low);
END;
$$ language plpgsql;

create or replace function random_date_time() returns timestamp as
$$
begin
    return (now() + (random() * (interval '90 days')));
end;
$$ language plpgsql;

INSERT INTO cinema (title) VALUES (random_string(16));
INSERT INTO movie (title) SELECT random_string(16) FROM generate_series(1, 100);
INSERT INTO hall (cinema_id, title, row_count, place_count) SELECT 1, random_string(16), 25, 40 FROM generate_series(1, 10);
INSERT INTO showtime (hall_id, movie_id, date_start, date_end) SELECT random_between(1, 10), random_between(1, 100), random_date_time(), random_date_time() FROM generate_series(1, 10000);
INSERT INTO ticket (showtime_id, price, hall_row, hall_place, available, sold) SELECT random_between(1, 10000), random_between(100, 500), random_between(1, 25), random_between(1, 40), TRUE, random() > 0.2 FROM generate_series(1, 10000) on conflict do nothing;

INSERT INTO showtime (hall_id, movie_id, date_start, date_end) SELECT random_between(1, 10), random_between(1, 100), random_date_time(), random_date_time() FROM generate_series(1, 10000000);
INSERT INTO ticket (showtime_id, price, hall_row, hall_place, available, sold) SELECT random_between(1, 10000000), random_between(100, 500), random_between(1, 25), random_between(1, 40), TRUE, random() > 0.2 FROM generate_series(1, 10000000) on conflict do nothing;

-----------------------------------------------------------------------------------------------------------------------
-- 3 простых запроса
-- 1) Сумма всех проданных билетов
EXPLAIN ANALYSE SELECT SUM(price) FROM ticket WHERE sold = TRUE;
SELECT SUM(price) FROM ticket WHERE sold = TRUE;
select count(*) from ticket;
select count(*) from showtime;
-- 10000 строк
-- Aggregate  (cost=184.00..184.01 rows=1 width=8) (actual time=1.203..1.203 rows=1 loops=1)
--   ->  Seq Scan on ticket  (cost=0.00..164.03 rows=7987 width=4) (actual time=0.007..0.815 rows=7987 loops=1)
--         Filter: sold
--         Rows Removed by Filter: 2016
-- Planning time: 0.035 ms
-- Execution time: 1.217 ms

-- 10000000 строк
-- Finalize Aggregate  (cost=163494.51..163494.52 rows=1 width=8) (actual time=540.993..540.993 rows=1 loops=1)
--   ->  Gather  (cost=163494.29..163494.50 rows=2 width=8) (actual time=540.956..542.810 rows=3 loops=1)
--         Workers Planned: 2
--         Workers Launched: 2
--         ->  Partial Aggregate  (cost=162494.29..162494.30 rows=1 width=8) (actual time=538.163..538.163 rows=1 loops=3)
--               ->  Parallel Seq Scan on ticket  (cost=0.00..154182.66 rows=3324654 width=4) (actual time=48.818..406.565 rows=2666055 loops=3)
--                     Filter: sold
--                     Rows Removed by Filter: 665614
-- Planning time: 0.046 ms
-- Execution time: 542.832 ms

-- Можно добавить индекс
CREATE INDEX ticket_sold_true_idx ON ticket(sold) WHERE sold = true;
DROP INDEX ticket_sold_true_idx;
-- Изменим random_page_cost, так как на SSD.
set random_page_cost = 1.1;
show random_page_cost;

-- Finalize Aggregate  (cost=163672.40..163672.41 rows=1 width=8) (actual time=510.660..510.660 rows=1 loops=1)
--   ->  Gather  (cost=163672.19..163672.40 rows=2 width=8) (actual time=510.630..512.918 rows=3 loops=1)
--         Workers Planned: 2
--         Workers Launched: 2
--         ->  Partial Aggregate  (cost=162672.19..162672.20 rows=1 width=8) (actual time=508.251..508.251 rows=1 loops=3)
--               ->  Parallel Seq Scan on ticket  (cost=0.00..154330.87 rows=3336528 width=4) (actual time=41.978..383.222 rows=2666055 loops=3)
--                     Filter: sold
--                     Rows Removed by Filter: 665614
-- Planning time: 0.075 ms
-- Execution time: 512.947 ms

-- Добавление индекса ни к чему не привело, так как ticket.sold = true в 80% случаев.

-----------------------------------------------------------------------------------------------------------------------
-- 2) В какой день было больше всего сеансов
EXPLAIN ANALYSE SELECT date_start::date, count(*) FROM showtime GROUP BY date_start::date ORDER BY count(*) DESC LIMIT 1;

-- 10000 строк
-- Limit  (cost=424.12..424.13 rows=1 width=12) (actual time=3.320..3.321 rows=1 loops=1)
--   ->  Sort  (cost=424.12..449.13 rows=10003 width=12) (actual time=3.320..3.320 rows=1 loops=1)
--         Sort Key: (count(*)) DESC
--         Sort Method: top-N heapsort  Memory: 25kB
--         ->  HashAggregate  (cost=249.07..374.11 rows=10003 width=12) (actual time=3.262..3.306 rows=93 loops=1)
--               Group Key: (date_start)::date
--               ->  Seq Scan on showtime  (cost=0.00..199.05 rows=10004 width=4) (actual time=0.011..1.871 rows=10004 loops=1)
-- Planning time: 0.054 ms
-- Execution time: 3.363 ms

-- 10000000 строк
-- Limit  (cost=1886601.36..1886601.36 rows=1 width=12) (actual time=5240.526..5240.527 rows=1 loops=1)
--   ->  Sort  (cost=1886601.36..1911626.35 rows=10009998 width=12) (actual time=5240.525..5240.525 rows=1 loops=1)
--         Sort Key: (count(*)) DESC
--         Sort Method: top-N heapsort  Memory: 25kB
--         ->  GroupAggregate  (cost=1636351.41..1836551.37 rows=10009998 width=12) (actual time=3857.967..5240.452 rows=97 loops=1)
--               Group Key: ((date_start)::date)
--               ->  Sort  (cost=1636351.41..1661376.40 rows=10009998 width=4) (actual time=3857.962..4569.272 rows=10010004 loops=1)
--                     Sort Key: ((date_start)::date)
--                     Sort Method: external merge  Disk: 137144kB
--                     ->  Seq Scan on showtime  (cost=0.00..198727.97 rows=10009998 width=4) (actual time=0.011..1489.563 rows=10010004 loops=1)
-- Planning time: 0.044 ms
-- Execution time: 5257.221 ms

-- Индекс просто по полю date_start ничего не дает.
-- CREATE INDEX showtime_date_start_idx ON showtime(date_start);
-- Попробуем сделать индекс по date_start::date
-- Добавляем функцию, индекс, перестраиваем запрос.
CREATE OR REPLACE FUNCTION get_date(datetime TIMESTAMP WITH TIME ZONE) RETURNS date AS
    'SELECT datetime::date;'
language sql immutable returns null on null input;
CREATE INDEX showtime_date_start_date_idx ON showtime(get_date(date_start));
EXPLAIN ANALYSE SELECT get_date(date_start), count(*) FROM showtime GROUP BY get_date(date_start) ORDER BY count(*) DESC LIMIT 1;
-- С таким индексом стало еще хуже.
-- Limit  (cost=5466509.77..5466509.78 rows=1 width=12) (actual time=24935.602..24935.603 rows=1 loops=1)
--   ->  Sort  (cost=5466509.77..5491534.78 rows=10010004 width=12) (actual time=24935.601..24935.601 rows=1 loops=1)
--         Sort Key: (count(*)) DESC
--         Sort Method: top-N heapsort  Memory: 25kB
--         ->  GroupAggregate  (cost=0.43..5416459.75 rows=10010004 width=12) (actual time=0.141..24935.477 rows=97 loops=1)
--               Group Key: get_date(date_start)
--               ->  Index Scan using showtime_date_start_date_idx on showtime  (cost=0.43..2763808.69 rows=10010004 width=4) (actual time=0.136..24115.927 rows=10010004 loops=1)
-- Planning time: 0.060 ms
-- Execution time: 24935.622 ms
DROP INDEX showtime_date_start_date_idx;

-----------------------------------------------------------------------------------------------------------------------
-- 3) Цена самого дорогого билета
EXPLAIN ANALYSE SELECT MAX(price) FROM ticket;

-- 10000 строк
-- Aggregate  (cost=189.04..189.05 rows=1 width=4) (actual time=1.185..1.185 rows=1 loops=1)
--   ->  Seq Scan on ticket  (cost=0.00..164.03 rows=10003 width=4) (actual time=0.006..0.546 rows=10003 loops=1)
-- Planning time: 0.050 ms
-- Execution time: 1.200 ms

-- 10000000 строк
-- Finalize Aggregate  (cost=165557.29..165557.30 rows=1 width=4) (actual time=535.722..535.722 rows=1 loops=1)
--   ->  Gather  (cost=165557.07..165557.28 rows=2 width=4) (actual time=535.694..537.696 rows=3 loops=1)
--         Workers Planned: 2
--         Workers Launched: 2
--         ->  Partial Aggregate  (cost=164557.07..164557.08 rows=1 width=4) (actual time=533.640..533.640 rows=1 loops=3)
--               ->  Parallel Seq Scan on ticket  (cost=0.00..154182.66 rows=4149766 width=4) (actual time=50.922..361.758 rows=3331669 loops=3)
-- Planning time: 0.068 ms
-- Execution time: 537.720 ms

-- Совершенно бессмысленный в плане логики запрос, но можно сделать индекс по цене и скорость возрастет в разы.
CREATE INDEX ticket_price_idx ON ticket(price);
DROP INDEX ticket_price_idx;
-- Result  (cost=0.46..0.47 rows=1 width=4) (actual time=0.016..0.017 rows=1 loops=1)
--   InitPlan 1 (returns $0)
--     ->  Limit  (cost=0.43..0.46 rows=1 width=4) (actual time=0.015..0.015 rows=1 loops=1)
--           ->  Index Only Scan Backward using ticket_price_idx on ticket  (cost=0.43..275091.16 rows=9995008 width=4) (actual time=0.015..0.015 rows=1 loops=1)
--                 Index Cond: (price IS NOT NULL)
--                 Heap Fetches: 1
-- Planning time: 0.078 ms
-- Execution time: 0.028 ms


-- 3 сложных запроса
-----------------------------------------------------------------------------------------------------------------------
-- 1) Самый прибыльный фильм

EXPLAIN ANALYSE SELECT SUM(t.price), m.title FROM ticket t
    LEFT JOIN showtime st ON st.id = t.showtime_id
    LEFT JOIN movie m ON m.id = st.movie_id
WHERE t.sold = true
GROUP BY m.id, m.title
ORDER BY sum(t.price) DESC LIMIT 1;

-- 10000 строк
-- Limit  (cost=688.97..688.97 rows=1 width=28) (actual time=6.654..6.654 rows=1 loops=1)
--   ->  Sort  (cost=688.97..708.93 rows=7987 width=28) (actual time=6.653..6.653 rows=1 loops=1)
--         Sort Key: (sum(t.price)) DESC
--         Sort Method: top-N heapsort  Memory: 25kB
--         ->  HashAggregate  (cost=569.16..649.03 rows=7987 width=28) (actual time=6.596..6.639 rows=100 loops=1)
-- "              Group Key: st.movie_id, m.title"
--               ->  Hash Left Join  (cost=302.43..509.26 rows=7987 width=24) (actual time=1.984..5.324 rows=7987 loops=1)
--                     Hash Cond: (st.movie_id = m.id)
--                     ->  Hash Left Join  (cost=299.09..484.10 rows=7987 width=8) (actual time=1.948..4.284 rows=7987 loops=1)
--                           Hash Cond: (t.showtime_id = st.id)
--                           ->  Seq Scan on ticket t  (cost=0.00..164.03 rows=7987 width=8) (actual time=0.005..0.934 rows=7987 loops=1)
--                                 Filter: sold
--                                 Rows Removed by Filter: 2016
--                           ->  Hash  (cost=174.04..174.04 rows=10004 width=8) (actual time=1.934..1.935 rows=10004 loops=1)
--                                 Buckets: 16384  Batches: 1  Memory Usage: 519kB
--                                 ->  Seq Scan on showtime st  (cost=0.00..174.04 rows=10004 width=8) (actual time=0.003..0.956 rows=10004 loops=1)
--                     ->  Hash  (cost=2.04..2.04 rows=104 width=20) (actual time=0.028..0.028 rows=104 loops=1)
--                           Buckets: 1024  Batches: 1  Memory Usage: 14kB
--                           ->  Seq Scan on movie m  (cost=0.00..2.04 rows=104 width=20) (actual time=0.007..0.016 rows=104 loops=1)
-- Planning time: 0.187 ms
-- Execution time: 6.698 ms

-- 10000000 строк
-- Limit  (cost=565114.15..565114.15 rows=1 width=28) (actual time=10329.754..10329.754 rows=1 loops=1)
--   ->  Sort  (cost=565114.15..565140.15 rows=10400 width=28) (actual time=10329.753..10329.753 rows=1 loops=1)
--         Sort Key: (sum(t.price)) DESC
--         Sort Method: top-N heapsort  Memory: 25kB
--         ->  Finalize GroupAggregate  (cost=564542.15..565062.15 rows=10400 width=28) (actual time=10329.669..10329.740 rows=100 loops=1)
-- "              Group Key: st.movie_id, m.title"
--               ->  Sort  (cost=564542.15..564646.15 rows=41600 width=28) (actual time=10329.665..10329.680 rows=500 loops=1)
-- "                    Sort Key: st.movie_id, m.title"
--                     Sort Method: quicksort  Memory: 64kB
--                     ->  Gather  (cost=557086.54..561350.54 rows=41600 width=28) (actual time=9970.396..10333.764 rows=500 loops=1)
--                           Workers Planned: 4
--                           Workers Launched: 4
--                           ->  Partial HashAggregate  (cost=556086.54..556190.54 rows=10400 width=28) (actual time=10085.431..10085.480 rows=100 loops=5)
-- "                                Group Key: st.movie_id, m.title"
--                                 ->  Hash Left Join  (cost=337933.43..541072.16 rows=2001917 width=24) (actual time=7037.633..9762.721 rows=1599633 loops=5)
--                                       Hash Cond: (st.movie_id = m.id)
--                                       ->  Hash Left Join  (cost=337930.09..535599.64 rows=2001917 width=8) (actual time=7037.572..9514.933 rows=1599633 loops=5)
--                                             Hash Cond: (t.showtime_id = st.id)
--                                             ->  Parallel Seq Scan on ticket t  (cost=0.00..137672.52 rows=2001917 width=8) (actual time=277.423..1024.389 rows=1599633 loops=5)
--                                                   Filter: sold
--                                                   Rows Removed by Filter: 399368
--                                             ->  Hash  (cost=173703.04..173703.04 rows=10010004 width=8) (actual time=6757.332..6757.333 rows=10010004 loops=5)
--                                                   Buckets: 131072  Batches: 256  Memory Usage: 2554kB
--                                                   ->  Seq Scan on showtime st  (cost=0.00..173703.04 rows=10010004 width=8) (actual time=0.021..4458.266 rows=10010004 loops=5)
--                                       ->  Hash  (cost=2.04..2.04 rows=104 width=20) (actual time=0.039..0.039 rows=104 loops=5)
--                                             Buckets: 1024  Batches: 1  Memory Usage: 14kB
--                                             ->  Seq Scan on movie m  (cost=0.00..2.04 rows=104 width=20) (actual time=0.016..0.024 rows=104 loops=5)
-- Planning time: 0.195 ms
-- Execution time: 10334.018 ms

CREATE INDEX ticket_showtime_id_idx ON ticket(showtime_id);
DROP INDEX ticket_showtime_id_idx;
CREATE INDEX showtime_movie_id_idx ON showtime(movie_id);
DROP INDEX showtime_movie_id_idx;
-- Индексы по FK не дают прироста скорости.

-- Limit  (cost=562266.46..562266.46 rows=1 width=28) (actual time=9445.735..9445.735 rows=1 loops=1)
--   ->  Sort  (cost=562266.46..562292.46 rows=10400 width=28) (actual time=9445.734..9445.734 rows=1 loops=1)
--         Sort Key: (sum(t.price)) DESC
--         Sort Method: top-N heapsort  Memory: 25kB
--         ->  Finalize GroupAggregate  (cost=561694.46..562214.46 rows=10400 width=28) (actual time=9445.620..9445.717 rows=100 loops=1)
-- "              Group Key: st.movie_id, m.title"
--               ->  Sort  (cost=561694.46..561798.46 rows=41600 width=28) (actual time=9445.615..9445.636 rows=500 loops=1)
-- "                    Sort Key: st.movie_id, m.title"
--                     Sort Method: quicksort  Memory: 64kB
--                     ->  Gather  (cost=554238.85..558502.85 rows=41600 width=28) (actual time=9445.205..9451.488 rows=500 loops=1)
--                           Workers Planned: 4
--                           Workers Launched: 4
--                           ->  Partial HashAggregate  (cost=553238.85..553342.85 rows=10400 width=28) (actual time=9436.360..9436.425 rows=100 loops=5)
-- "                                Group Key: st.movie_id, m.title"
--                                 ->  Hash Left Join  (cost=4.21..538224.47 rows=2001917 width=24) (actual time=0.679..9008.601 rows=1599633 loops=5)
--                                       Hash Cond: (st.movie_id = m.id)
--                                       ->  Merge Left Join  (cost=0.87..532751.95 rows=2001917 width=8) (actual time=0.512..8695.504 rows=1599633 loops=5)
--                                             Merge Cond: (t.showtime_id = st.id)
--                                             ->  Parallel Index Scan using ticket_showtime_id_idx on ticket t  (cost=0.43..229065.29 rows=2001917 width=8) (actual time=0.026..6575.943 rows=1599633 loops=5)
--                                                   Filter: sold
--                                                   Rows Removed by Filter: 399368
--                                             ->  Index Scan using showtime_pkey on showtime st  (cost=0.43..253946.40 rows=10010004 width=8) (actual time=0.016..1252.007 rows=9999346 loops=5)
--                                       ->  Hash  (cost=2.04..2.04 rows=104 width=20) (actual time=0.036..0.037 rows=104 loops=5)
--                                             Buckets: 1024  Batches: 1  Memory Usage: 14kB
--                                             ->  Seq Scan on movie m  (cost=0.00..2.04 rows=104 width=20) (actual time=0.010..0.019 rows=104 loops=5)
-- Planning time: 2.386 ms
-- Execution time: 9451.851 ms


set max_parallel_workers_per_gather = 4;
show max_parallel_workers_per_gather;

-----------------------------------------------------------------------------------------------------------------------
-- 2) В какой день было продано больше всего билетов
EXPLAIN ANALYSE SELECT date_start::date, count(*) FROM ticket t
    JOIN showtime s ON t.showtime_id = s.id
WHERE t.sold = true
GROUP BY date_start::date
ORDER BY count(*) DESC
LIMIT 1;

-- 10000 строк
-- Limit  (cost=683.77..683.77 rows=1 width=12) (actual time=6.265..6.265 rows=1 loops=1)
--   ->  Sort  (cost=683.77..703.74 rows=7987 width=12) (actual time=6.263..6.263 rows=1 loops=1)
--         Sort Key: (count(*)) DESC
--         Sort Method: top-N heapsort  Memory: 25kB
--         ->  HashAggregate  (cost=544.00..643.84 rows=7987 width=12) (actual time=6.184..6.246 rows=93 loops=1)
--               Group Key: (s.date_start)::date
--               ->  Hash Join  (cost=299.09..504.06 rows=7987 width=4) (actual time=1.982..5.177 rows=7987 loops=1)
--                     Hash Cond: (t.showtime_id = s.id)
--                     ->  Seq Scan on ticket t  (cost=0.00..164.03 rows=7987 width=4) (actual time=0.008..0.953 rows=7987 loops=1)
--                           Filter: sold
--                           Rows Removed by Filter: 2016
--                     ->  Hash  (cost=174.04..174.04 rows=10004 width=12) (actual time=1.962..1.962 rows=10004 loops=1)
--                           Buckets: 16384  Batches: 1  Memory Usage: 558kB
--                           ->  Seq Scan on showtime s  (cost=0.00..174.04 rows=10004 width=12) (actual time=0.004..0.950 rows=10004 loops=1)
-- Planning time: 0.161 ms
-- Execution time: 6.308 ms

-- 10000000 строк
-- Limit  (cost=2044479.20..2044479.20 rows=1 width=12) (actual time=9041.712..9041.712 rows=1 loops=1)
--   ->  Sort  (cost=2044479.20..2064427.13 rows=7979170 width=12) (actual time=9041.711..9041.711 rows=1 loops=1)
--         Sort Key: (count(*)) DESC
--         Sort Method: top-N heapsort  Memory: 25kfB
--         ->  GroupAggregate  (cost=1844999.95..2004583.35 rows=7979170 width=12) (actual time=7910.132..9041.643 rows=95 loops=1)
--               Group Key: ((s.date_start)::date)
--               ->  Sort  (cost=1844999.95..1864947.88 rows=7979170 width=4) (actual time=7910.126..8489.965 rows=7998166 loops=1)
--                     Sort Key: ((s.date_start)::date)
--                     Sort Method: external merge  Disk: 109600kB
--                     ->  Hash Join  (cost=347704.95..712092.59 rows=7979170 width=4) (actual time=2133.945..6070.637 rows=7998166 loops=1)
--                           Hash Cond: (t.showtime_id = s.id)
--                           ->  Seq Scan on ticket t  (cost=0.00..212279.38 rows=7979170 width=4) (actual time=92.833..1073.037 rows=7998166 loops=1)
--                                 Filter: sold
--                                 Rows Removed by Filter: 1996842
--                           ->  Hash  (cost=173702.98..173702.98 rows=10009998 width=12) (actual time=2039.432..2039.432 rows=10010004 loops=1)
--                                 Buckets: 131072  Batches: 256  Memory Usage: 2707kB
--                                 ->  Seq Scan on showtime s  (cost=0.00..173702.98 rows=10009998 width=12) (actual time=0.006..920.857 rows=10010004 loops=1)
-- Planning time: 0.170 ms
-- Execution time: 9055.938 ms


-----------------------------------------------------------------------------------------------------------------------
-- 3) Какой день самый прибыльный

EXPLAIN ANALYSE SELECT date_start::date, sum(t.price) FROM ticket t
    JOIN showtime s ON t.showtime_id = s.id
WHERE t.sold = TRUE
GROUP BY date_start::date
ORDER BY sum(t.price) DESC
LIMIT 1;

-- 10000 строк
-- Limit  (cost=683.77..683.77 rows=1 width=12) (actual time=5.341..5.341 rows=1 loops=1)
--   ->  Sort  (cost=683.77..703.74 rows=7987 width=12) (actual time=5.340..5.340 rows=1 loops=1)
--         Sort Key: (sum(t.price)) DESC
--         Sort Method: top-N heapsort  Memory: 25kB
--         ->  HashAggregate  (cost=544.00..643.84 rows=7987 width=12) (actual time=5.279..5.328 rows=93 loops=1)
--               Group Key: (s.date_start)::date
--               ->  Hash Join  (cost=299.09..504.06 rows=7987 width=8) (actual time=1.877..4.412 rows=7987 loops=1)
--                     Hash Cond: (t.showtime_id = s.id)
--                     ->  Seq Scan on ticket t  (cost=0.00..164.03 rows=7987 width=8) (actual time=0.005..0.833 rows=7987 loops=1)
--                           Filter: sold
--                           Rows Removed by Filter: 2016
--                     ->  Hash  (cost=174.04..174.04 rows=10004 width=12) (actual time=1.864..1.864 rows=10004 loops=1)
--                           Buckets: 16384  Batches: 1  Memory Usage: 558kB
--                           ->  Seq Scan on showtime s  (cost=0.00..174.04 rows=10004 width=12) (actual time=0.003..0.954 rows=10004 loops=1)
-- Planning time: 0.130 ms
-- Execution time: 5.378 ms

-- 10000000 строк
-- Limit  (cost=2044479.20..2044479.20 rows=1 width=12) (actual time=10003.877..10003.877 rows=1 loops=1)
--   ->  Sort  (cost=2044479.20..2064427.13 rows=7979170 width=12) (actual time=10003.876..10003.876 rows=1 loops=1)
--         Sort Key: (sum(t.price)) DESC
--         Sort Method: top-N heapsort  Memory: 25kB
--         ->  GroupAggregate  (cost=1844999.95..2004583.35 rows=7979170 width=12) (actual time=8807.958..10003.803 rows=95 loops=1)
--               Group Key: ((s.date_start)::date)
--               ->  Sort  (cost=1844999.95..1864947.88 rows=7979170 width=8) (actual time=8807.952..9385.947 rows=7998166 loops=1)
--                     Sort Key: ((s.date_start)::date)
--                     Sort Method: external merge  Disk: 140920kB
--                     ->  Hash Join  (cost=347704.95..712092.59 rows=7979170 width=8) (actual time=2144.785..6866.991 rows=7998166 loops=1)
--                           Hash Cond: (t.showtime_id = s.id)
--                           ->  Seq Scan on ticket t  (cost=0.00..212279.38 rows=7979170 width=8) (actual time=88.340..1095.177 rows=7998166 loops=1)
--                                 Filter: sold
--                                 Rows Removed by Filter: 1996842
--                           ->  Hash  (cost=173702.98..173702.98 rows=10009998 width=12) (actual time=2054.770..2054.770 rows=10010004 loops=1)
--                                 Buckets: 131072  Batches: 256  Memory Usage: 2707kB
--                                 ->  Seq Scan on showtime s  (cost=0.00..173702.98 rows=10009998 width=12) (actual time=0.006..923.993 rows=10010004 loops=1)
-- Planning time: 0.179 ms
-- Execution time: 10022.078 ms

-- В последних 2х запросах добавление индекса CREATE INDEX ticket_showtime_id_idx ON ticket(showtime_id); или get_date(date_start) только ухудшают ситуацию.

-- Limit  (cost=1949442.39..1949442.39 rows=1 width=12) (actual time=29592.636..29592.636 rows=1 loops=1)
--   ->  Sort  (cost=1949442.39..1969461.55 rows=8007667 width=12) (actual time=29592.635..29592.635 rows=1 loops=1)
--         Sort Key: (sum(t.price)) DESC
--         Sort Method: top-N heapsort  Memory: 25kB
--         ->  GroupAggregate  (cost=1749250.71..1909404.05 rows=8007667 width=12) (actual time=28418.984..29592.574 rows=95 loops=1)
--               Group Key: ((s.date_start)::date)
--               ->  Sort  (cost=1749250.71..1769269.88 rows=8007667 width=8) (actual time=28418.978..28980.218 rows=7998166 loops=1)
--                     Sort Key: ((s.date_start)::date)
--                     Sort Method: external merge  Disk: 140928kB
--                     ->  Merge Join  (cost=27.50..702805.55 rows=8007667 width=8) (actual time=0.012..26394.857 rows=7998166 loops=1)
--                           Merge Cond: (t.showtime_id = s.id)
--                           ->  Index Scan using ticket_showtime_id_idx on ticket t  (cost=0.43..304027.85 rows=8007667 width=8) (actual time=0.006..22996.690 rows=7998166 loops=1)
--                                 Filter: sold
--                                 Rows Removed by Filter: 1996842
--                           ->  Index Scan using showtime_pkey on showtime s  (cost=0.43..253946.40 rows=10010004 width=12) (actual time=0.003..1162.422 rows=10000000 loops=1)
-- Planning time: 0.358 ms
-- Execution time: 29608.024 ms

-- Там как в последних сложных запросах используются почти полные данные таблиц, и нет каких то сложных условий,
-- нет возможности значительно ускорить обработку с помощью индеков.


-- отсортированный список (15 значений) самых больших по размеру объектов БД (таблицы, включая индексы, сами индексы)
select relname, relpages from pg_class order by relpages desc  limit 15;
-- ticket,112685
-- ticket_place_uq,88657
-- showtime,73603
-- showtime_movie_id_idx,27449
-- showtime_date_start_date_idx,27449
-- showtime_pkey,27448
-- ticket_showtime_id_idx,27408
-- ticket_price_idx,27408
-- ticket_pkey,23830
-- pg_proc,74
-- pg_depend,56
-- pg_toast_2618,51
-- pg_attribute,50
-- pg_depend_reference_index,49
-- pg_depend_depender_index,41

-- отсортированные списки (по 5 значений) самых часто и редко используемых индексов
select indexrelname from pg_stat_user_indexes order by idx_scan desc limit 5;
-- ticket_place_uq
-- ticket_pkey
-- showtime_pkey
-- hall_pkey
-- movie_pkey


select indexrelname from pg_stat_user_indexes order by idx_scan asc limit 5;
-- movie_attr_value_movie_id
-- movie_attr_value_attr_id
-- movie_attr_type_id
-- movie_attr_name_unique
-- showtime_movie_id_idx
