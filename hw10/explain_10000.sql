---------------------------------------------------------------------
-- 1. Все сеансы за определенный день
---------------------------------------------------------------------

    explain (analyze) 
    select s.hall_id, s.movie_id, s.date from sessions s 
    where s.date BETWEEN '2020-01-05 00:00:00' and '2020-01-05 23:59:59';

    -- Seq Scan on sessions s  (cost=0.00..7.50 rows=2 width=16) (actual time=0.143..0.143 rows=0 loops=1)
    --   Filter: ((date >= '2020-01-05 00:00:00'::timestamp without time zone) AND (date <= '2020-01-05 23:59:59'::timestamp without time zone))
    --   Rows Removed by Filter: 300
    -- Planning Time: 0.168 ms
    -- Execution Time: 0.161 ms


---------------------------------------------------------------------
-- 2. Топ 100 фильмов по рейтингу
---------------------------------------------------------------------

    explain analyze
    select movies.name, float_value from movie_property_values mpv 
        left join movies on movies.id = mpv.movie
    where property = 12
    order by float_value desc 
    limit 100;

    -- Limit  (cost=0.56..49.82 rows=100 width=18) (actual time=3.303..4.088 rows=100 loops=1)
    --   ->  Nested Loop Left Join  (cost=0.56..990.68 rows=2010 width=18) (actual time=3.301..4.056 rows=100 loops=1)
    --         ->  Index Scan Backward using idx_movie_prop_values_float on movie_property_values mpv  (cost=0.28..321.78 rows=2010 width=11) (actual time=3.282..3.436 rows=100 loops=1)
    --               Filter: (property = 12)
    --               Rows Removed by Filter: 4020
    --         ->  Index Scan using movies_pkey on movies  (cost=0.28..0.33 rows=1 width=15) (actual time=0.004..0.004 rows=1 loops=100)
    --               Index Cond: (id = mpv.movie)
    -- Planning Time: 1.279 ms
    -- Execution Time: 4.145 ms


---------------------------------------------------------------------
-- 3. Все фильмы, у которых есть оскар
---------------------------------------------------------------------

    explain analyze 
    select movies.id, movies.name from movie_property_values mpv 
        left join movies on movies.id = mpv.movie
    where mpv.property = 1 and mpv.boolean_value = true;

    -- Hash Right Join  (cost=110.46..146.85 rows=7 width=15) (actual time=2.709..4.271 rows=20 loops=1)
    --   Hash Cond: (movies.id = mpv.movie)
    --   ->  Seq Scan on movies  (cost=0.00..31.10 rows=2010 width=15) (actual time=0.024..0.719 rows=2010 loops=1)
    --   ->  Hash  (cost=110.38..110.38 rows=7 width=4) (actual time=2.670..2.670 rows=20 loops=1)
    --         Buckets: 1024  Batches: 1  Memory Usage: 9kB
    --         ->  Seq Scan on movie_property_values mpv  (cost=0.00..110.38 rows=7 width=4) (actual time=0.868..2.653 rows=20 loops=1)
    --               Filter: (boolean_value AND (property = 1))
    --               Rows Removed by Filter: 6010
    -- Planning Time: 0.614 ms
    -- Execution Time: 4.319 ms


---------------------------------------------------------------------
-- 4. Схема зрительного зала на конкретный сеанс, с выводом свободных и занятых мест
---------------------------------------------------------------------

    explain (analyze) 
    select halls.name, seats.row, seats.seat, basket.id::boolean as buyed from sessions
        left join halls on sessions.hall_id = halls.id
        left join seats on halls.id = seats.hall_id 
        left join basket on basket.seat_id = seats.id and basket.session_id = 157849
    where sessions.id=157849;

    -- Nested Loop Left Join  (cost=3.54..155.63 rows=33 width=223) (actual time=0.172..0.173 rows=0 loops=1)
    --   Join Filter: (halls.id = seats.hall_id)
    --   ->  Nested Loop Left Join  (cost=0.00..7.82 rows=1 width=222) (actual time=0.172..0.172 rows=0 loops=1)
    --         Join Filter: (sessions.hall_id = halls.id)
    --         ->  Seq Scan on sessions  (cost=0.00..6.75 rows=1 width=4) (actual time=0.170..0.170 rows=0 loops=1)
    --               Filter: (id = 157849)
    --               Rows Removed by Filter: 300
    --         ->  Seq Scan on halls  (cost=0.00..1.03 rows=3 width=222) (never executed)
    --   ->  Hash Right Join  (cost=3.54..146.48 rows=100 width=12) (never executed)
    --         Hash Cond: (basket.seat_id = seats.id)
    --         ->  Index Scan using basket_unique on basket  (cost=0.29..142.97 rows=96 width=8) (never executed)
    --               Index Cond: (session_id = 157849)
    --         ->  Hash  (cost=2.00..2.00 rows=100 width=12) (never executed)
    --               ->  Seq Scan on seats  (cost=0.00..2.00 rows=100 width=12) (never executed)
    -- Planning Time: 2.033 ms
    -- Execution Time: 0.303 ms


---------------------------------------------------------------------
-- 5. В каком месяце люди чаще всего ходят в кино
---------------------------------------------------------------------

    explain analyze
    select count(*) as count, date_part('month', S.date) as month_number from basket B
        left join sessions S on S.id = B.session_id 
    group by month_number
    order by count desc limit 1;

    -- Limit  (cost=791.70..791.71 rows=1 width=16) (actual time=163.467..163.468 rows=1 loops=1)
    --   ->  Sort  (cost=791.70..792.45 rows=300 width=16) (actual time=163.466..163.466 rows=1 loops=1)
    --         Sort Key: (count(*)) DESC
    --         Sort Method: top-N heapsort  Memory: 25kB
    --         ->  HashAggregate  (cost=786.45..790.20 rows=300 width=16) (actual time=163.440..163.451 rows=12 loops=1)
    --               Group Key: date_part('month'::text, s.date)
    --               ->  Hash Left Join  (cost=9.75..641.45 rows=29000 width=8) (actual time=0.458..113.201 rows=29000 loops=1)
    --                     Hash Cond: (b.session_id = s.id)
    --                     ->  Seq Scan on basket b  (cost=0.00..482.00 rows=29000 width=4) (actual time=0.011..29.959 rows=29000 loops=1)
    --                     ->  Hash  (cost=6.00..6.00 rows=300 width=12) (actual time=0.433..0.433 rows=300 loops=1)
    --                           Buckets: 1024  Batches: 1  Memory Usage: 21kB
    --                           ->  Seq Scan on sessions s  (cost=0.00..6.00 rows=300 width=12) (actual time=0.017..0.235 rows=300 loops=1)
    -- Planning Time: 0.518 ms
    -- Execution Time: 163.536 ms


---------------------------------------------------------------------
-- 6. Самый прибыльный сеанс
---------------------------------------------------------------------

    explain analyze
    select sum(price) as total, session_id from basket 
    group by session_id 
    order by total desc 
    limit 1;

    -- Limit  (cost=632.25..632.25 rows=1 width=36) (actual time=89.596..89.597 rows=1 loops=1)
    --   ->  Sort  (cost=632.25..633.00 rows=300 width=36) (actual time=89.594..89.595 rows=1 loops=1)
    --         Sort Key: (sum(price)) DESC
    --         Sort Method: top-N heapsort  Memory: 25kB
    --         ->  HashAggregate  (cost=627.00..630.75 rows=300 width=36) (actual time=88.961..89.322 rows=300 loops=1)
    --               Group Key: session_id
    --               ->  Seq Scan on basket  (cost=0.00..482.00 rows=29000 width=9) (actual time=0.010..8.816 rows=29000 loops=1)
    -- Planning Time: 0.146 ms
    -- Execution Time: 89.644 ms