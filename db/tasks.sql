-------- 3 простых запроса

---- 1) сумма проданных билетов
select sum(price) from bookings where status_id = 3;
-- Результат на ~10,000 строк
-- sum
-- ------------
--  $16,876.49
-- (1 row)

-- План на ~10,000 строк
-- postgres=# explain select sum(price) from bookings where status_id = 3;
-- QUERY PLAN
-- -------------------------------------------------------------------
--  Aggregate  (cost=196.81..196.82 rows=1 width=8)
--    ->  Seq Scan on bookings  (cost=0.00..188.45 rows=3346 width=8)
--          Filter: (status_id = 3)
-- (3 rows)

-- Результат на ~10,000,000 строк
-- sum
-- ----------------
--  $16,611,284.66
-- (1 row)

-- План на ~10,000,000 строк
-- QUERY PLAN
-- ----------------------------------------------------------------------------------------------
--  Finalize Aggregate  (cost=119761.89..119761.90 rows=1 width=8)
--    ->  Gather  (cost=119761.67..119761.88 rows=2 width=8)
--          Workers Planned: 2
--          ->  Partial Aggregate  (cost=118761.67..118761.68 rows=1 width=8)
--                ->  Parallel Seq Scan on bookings  (cost=0.00..115315.42 rows=1378503 width=8)
--                      Filter: (status_id = 3)
--  JIT:
--    Functions: 7
--    Options: Inlining false, Optimization false, Expressions true, Deforming true
-- (9 rows)
-- Данных настолько много, что планировщик предлагает нам параллельные выборки

-- Создадим частичный индекс
create index bookings_paid on bookings (status_id) where status_id = 3;
-- Ввиду (неожиданно) низкой селективности индекса пришлось сделать
set random_page_cost = 1;

-- План на ~10,000,000 строк после индекса
-- QUERY PLAN
-- -------------------------------------------------------------------------------------------------------------------
--  Finalize Aggregate  (cost=104226.43..104226.44 rows=1 width=8)
--    ->  Gather  (cost=104226.22..104226.43 rows=2 width=8)
--          Workers Planned: 2
--          ->  Partial Aggregate  (cost=103226.22..103226.23 rows=1 width=8)
--                ->  Parallel Index Scan using bookings_paid on bookings  (cost=0.43..99780.01 rows=1378482 width=8)
--  JIT:
--    Functions: 5
--    Options: Inlining false, Optimization false, Expressions true, Deforming true
-- (8 rows)


---- 2) сколько фильмов демонстрируется в 3D формате
select count(*) from showtimes where format = '3D';
-- Результат на ~10,000 строк
-- count
-- -------
--   5012
-- (1 row)

-- План на ~10,000 строк
-- postgres=# explain select count(*) from showtimes where format = '3D';
-- QUERY PLAN
-- --------------------------------------------------------------------
--  Aggregate  (cost=285.53..285.54 rows=1 width=8)
--    ->  Seq Scan on showtimes  (cost=0.00..273.00 rows=5012 width=0)
--          Filter: ((format)::text = '3D'::text)
-- (3 rows)

-- Результат на ~10,000,000 строк
-- count
-- ---------
--  5006719
-- (1 row)

-- План на ~10,000,000 строк
-- QUERY PLAN
-- -----------------------------------------------------------------------------------------------
--  Finalize Aggregate  (cost=131934.74..131934.75 rows=1 width=8)
--    ->  Gather  (cost=131934.53..131934.74 rows=2 width=8)
--          Workers Planned: 2
--          ->  Partial Aggregate  (cost=130934.53..130934.54 rows=1 width=8)
--                ->  Parallel Seq Scan on showtimes  (cost=0.00..125738.37 rows=2078463 width=0)
--                      Filter: ((format)::text = '3D'::text)
--  JIT:
--    Functions: 6
--    Options: Inlining false, Optimization false, Expressions true, Deforming true
-- (9 rows)

-- Тут нет особого смысла строить индекс и собирать статистику в отдельной таблице. Но есть ещё один способ ускорить запрос
-- Увеличим количество воркеров на узел
set max_parallel_workers_per_gather = 4;
-- postgres=# set max_parallel_workers_per_gather = 4;
-- SET
-- postgres=# explain select count(*) from showtimes where format = '3D';
-- QUERY PLAN
-- -----------------------------------------------------------------------------------------------
--  Finalize Aggregate  (cost=109002.37..109002.38 rows=1 width=8)
--    ->  Gather  (cost=109001.95..109002.36 rows=4 width=8)
--          Workers Planned: 4
--          ->  Partial Aggregate  (cost=108001.95..108001.96 rows=1 width=8)
--                ->  Parallel Seq Scan on showtimes  (cost=0.00..104884.25 rows=1247079 width=0)
--                      Filter: ((format)::text = '3D'::text)
--  JIT:
--    Functions: 6
--    Options: Inlining false, Optimization false, Expressions true, Deforming true
-- (9 rows)


---- 3) в какой день было больше всего сеансов (макс 1)
select date_time::date, count(*) from showtimes group by date_time::date order by count(*) desc limit 1;
-- Результат на ~10,000 строк
-- date_time  | count
-- ------------+-------
--  2020-01-11 |   366
-- (1 row)

-- План на ~10,000 строк
-- postgres=# explain select date_time::date, count(*) from showtimes group by date_time::date order by count(*) desc limit 1;
-- QUERY PLAN
-- ---------------------------------------------------------------------------------
--  Limit  (cost=323.54..323.54 rows=1 width=12)
--    ->  Sort  (cost=323.54..323.62 rows=31 width=12)
--          Sort Key: (count(*)) DESC
--          ->  HashAggregate  (cost=323.00..323.39 rows=31 width=12)
--                Group Key: (date_time)::date
--                ->  Seq Scan on showtimes  (cost=0.00..273.00 rows=10000 width=4)
-- (6 rows)

-- Результат на ~10,000,000 строк
-- date_time  | count
-- ------------+--------
--  2020-01-05 | 334639
-- (1 row)

-- План на ~10,000,000 строк
-- QUERY PLAN
-- -----------------------------------------------------------------------------------------------------------------
--  Limit  (cost=1305238.52..1305238.52 rows=1 width=12)
--    ->  Sort  (cost=1305238.52..1310541.70 rows=2121271 width=12)
--          Sort Key: (count(*)) DESC
--          ->  Finalize GroupAggregate  (cost=699411.84..1294632.17 rows=2121271 width=12)
--                Group Key: ((date_time)::date)
--                ->  Gather Merge  (cost=699411.84..1246903.57 rows=4242542 width=12)
--                      Workers Planned: 2
--                      ->  Partial GroupAggregate  (cost=698411.82..756208.93 rows=2121271 width=12)
--                            Group Key: ((date_time)::date)
--                            ->  Sort  (cost=698411.82..708838.89 rows=4170830 width=4)
--                                  Sort Key: ((date_time)::date)
--                                  ->  Parallel Seq Scan on showtimes  (cost=0.00..125738.37 rows=4170830 width=4)
--  JIT:
--    Functions: 10
--    Options: Inlining true, Optimization true, Expressions true, Deforming true
-- (15 rows)
create or replace function get_date(datetime timestamp with time zone) returns date as
'select datetime::date;'
    language sql immutable returns null on null input;

create index showtimes_days on showtimes (get_date(date_time));
-- Немного изменим запрос
select get_date(date_time), count(*) from showtimes group by get_date(date_time) order by count(*) desc limit 1;

-- Выполним
set max_parallel_workers_per_gather = 4;

-- Посомтрим теперь на план первого и второго запросов

-- postgres=# explain analyze select get_date(date_time), count(*) from showtimes group by get_date(date_time) order by count(*) desc limit 1;
-- QUERY PLAN
-- --------------------------------------------------------------------------------------------------------------------------------------------------------------------
--  Limit  (cost=3365927.78..3365927.78 rows=1 width=12) (actual time=29899.387..29899.388 rows=1 loops=1)
--    ->  Sort  (cost=3365927.78..3371230.96 rows=2121273 width=12) (actual time=29307.335..29307.335 rows=1 loops=1)
--          Sort Key: (count(*)) DESC
--          Sort Method: top-N heapsort  Memory: 25kB
--          ->  GroupAggregate  (cost=0.43..3355321.42 rows=2121273 width=12) (actual time=672.434..29307.146 rows=31 loops=1)
--                Group Key: get_date(date_time)
--                ->  Index Scan using showtimes_days on showtimes  (cost=0.43..2753740.44 rows=10010000 width=4) (actual time=0.402..28375.719 rows=10010000 loops=1)
--  Planning Time: 0.180 ms
--  JIT:
--    Functions: 6
--    Options: Inlining true, Optimization true, Expressions true, Deforming true
--    Timing: Generation 0.744 ms, Inlining 285.777 ms, Optimization 236.416 ms, Emission 69.583 ms, Total 592.520 ms
--  Execution Time: 29900.371 ms
-- (13 rows)
--
-- postgres=# explain analyze select date_time::date, count(*) from showtimes group by date_time::date order by count(*) desc limit 1;
-- QUERY PLAN
-- ----------------------------------------------------------------------------------------------------------------------------------------------------------------------
--  Limit  (cost=1546429.39..1546429.39 rows=1 width=12) (actual time=9048.120..9090.165 rows=1 loops=1)
--    ->  Sort  (cost=1546429.39..1551732.57 rows=2121273 width=12) (actual time=8945.601..8945.601 rows=1 loops=1)
--          Sort Key: (count(*)) DESC
--          Sort Method: top-N heapsort  Memory: 25kB
--          ->  Finalize GroupAggregate  (cost=410940.73..1535823.02 rows=2121273 width=12) (actual time=7180.953..8945.503 rows=31 loops=1)
--                Group Key: ((date_time)::date)
--                ->  Gather Merge  (cost=410940.73..1466881.65 rows=8485092 width=12) (actual time=7101.872..8987.360 rows=155 loops=1)
--                      Workers Planned: 4
--                      Workers Launched: 4
--                      ->  Partial GroupAggregate  (cost=409940.67..455225.33 rows=2121273 width=12) (actual time=6887.857..8746.492 rows=31 loops=5)
--                            Group Key: ((date_time)::date)
--                            ->  Sort  (cost=409940.67..416196.92 rows=2502500 width=4) (actual time=6867.663..8095.652 rows=2002000 loops=5)
--                                  Sort Key: ((date_time)::date)
--                                  Sort Method: external merge  Disk: 30552kB
--                                  Worker 0:  Sort Method: external merge  Disk: 26752kB
--                                  Worker 1:  Sort Method: external merge  Disk: 26728kB
--                                  Worker 2:  Sort Method: external merge  Disk: 26792kB
--                                  Worker 3:  Sort Method: external merge  Disk: 26752kB
--                                  ->  Parallel Seq Scan on showtimes  (cost=0.00..104884.25 rows=2502500 width=4) (actual time=499.628..2821.193 rows=2002000 loops=5)
--  Planning Time: 0.116 ms
--  JIT:
--    Functions: 34
--    Options: Inlining true, Optimization true, Expressions true, Deforming true
--    Timing: Generation 21.040 ms, Inlining 1340.773 ms, Optimization 665.327 ms, Emission 576.742 ms, Total 2603.882 ms
--  Execution Time: 9097.148 ms
-- (25 rows)

-- Как мы видим, во втором случае планировщиком был выбран параллеьный метод сканирования, и он оказался быстрее, чем использование индексного сканирования
-- Значит для таких запросов нет никакой необходимости в этом индексе


-------- 3 запроса посложнее

---- 4) в какой день было больше всего продано билетов (макс 1)
select s.date_time::date as date, sum(b.price) as paid
from showtimes s
         inner join bookings b on s.id = b.showtime_id
where b.status_id = 3
group by date_time::date
order by count(*) desc
limit 1;
-- Результат на ~10,000 строк
-- date    |  paid
-- ------------+---------
--  2020-01-16 | $647.84
-- (1 row)

-- План на ~10,000 строк
-- postgres=# explain select s.date_time::date as date, sum(b.price) as paid
-- postgres-# from showtimes s
-- postgres-#     inner join bookings b on s.id = b.showtime_id
-- postgres-# where b.status_id = 3
-- postgres-# group by date_time::date
-- postgres-# order by count(*) desc
-- postgres-# limit 1;
-- QUERY PLAN
-- ------------------------------------------------------------------------------------------------
--  Limit  (cost=604.31..604.32 rows=1 width=24)
--    ->  Sort  (cost=604.31..604.39 rows=31 width=24)
--          Sort Key: (count(*)) DESC
--          ->  HashAggregate  (cost=603.69..604.16 rows=31 width=24)
--                Group Key: (s.date_time)::date
--                ->  Hash Join  (cost=373.00..578.60 rows=3346 width=20)
--                      Hash Cond: (b.showtime_id = s.id)
--                      ->  Seq Scan on bookings b  (cost=0.00..188.45 rows=3346 width=12)
--                            Filter: (status_id = 3)
--                      ->  Hash  (cost=248.00..248.00 rows=10000 width=12)
--                            ->  Seq Scan on showtimes s  (cost=0.00..248.00 rows=10000 width=12)
-- (11 rows)

-- Результат на ~10,000,000 строк
-- date    |    paid
-- ------------+-------------
--  2020-01-05 | $556,047.62
-- (1 row)

-- План на ~10,000,000 строк
-- QUERY PLAN
-- -------------------------------------------------------------------------------------------------------------------------------
--  Limit  (cost=937345.41..937345.42 rows=1 width=24)
--    ->  Sort  (cost=937345.41..942648.59 rows=2121271 width=24)
--          Sort Key: (count(*)) DESC
--          ->  Finalize GroupAggregate  (cost=524999.23..926739.06 rows=2121271 width=24)
--                Group Key: ((s.date_time)::date)
--                ->  Gather Merge  (cost=524999.23..874242.45 rows=2757006 width=28)
--                      Workers Planned: 2
--                      ->  Partial GroupAggregate  (cost=523999.21..555015.52 rows=1378503 width=28)
--                            Group Key: ((s.date_time)::date)
--                            ->  Sort  (cost=523999.21..527445.46 rows=1378503 width=20)
--                                  Sort Key: ((s.date_time)::date)
--                                  ->  Parallel Hash Join  (cost=139277.70..326882.63 rows=1378503 width=20)
--                                        Hash Cond: (s.id = b.showtime_id)
--                                        ->  Parallel Seq Scan on showtimes s  (cost=0.00..115311.30 rows=4170830 width=12)
--                                        ->  Parallel Hash  (cost=115315.42..115315.42 rows=1378503 width=12)
--                                              ->  Parallel Seq Scan on bookings b  (cost=0.00..115315.42 rows=1378503 width=12)
--                                                    Filter: (status_id = 3)
--  JIT:
--    Functions: 21
--    Options: Inlining true, Optimization true, Expressions true, Deforming true
-- (20 rows)

-- Создадим частичный индекс...
create index bookings_paid on bookings (status_id) where status_id = 3;

-- План на ~10,000,000 строк после индекса
-- (пришлось сделать SET random_page_cost = 1;)
-- QUERY PLAN
-- ----------------------------------------------------------------------------------------------------------------------------------------------------
--  Limit  (cost=897567.69..897567.69 rows=1 width=24)
--    ->  Sort  (cost=897567.69..902870.86 rows=2121271 width=24)
--          Sort Key: (count(*)) DESC
--          ->  Finalize GroupAggregate  (cost=485227.14..886961.33 rows=2121271 width=24)
--                Group Key: ((s.date_time)::date)
--                ->  Gather Merge  (cost=485227.14..834465.04 rows=2756964 width=28)
--                      Workers Planned: 2
--                      ->  Partial GroupAggregate  (cost=484227.11..515242.96 rows=1378482 width=28)
--                            Group Key: ((s.date_time)::date)
--                            ->  Sort  (cost=484227.11..487673.32 rows=1378482 width=20)
--                                  Sort Key: ((s.date_time)::date)
--                                  ->  Parallel Hash Join  (cost=123742.04..311346.83 rows=1378482 width=20)
--                                        Hash Cond: (s.id = b.showtime_id)
--                                        ->  Parallel Seq Scan on showtimes s  (cost=0.00..115311.30 rows=4170830 width=12)
--                                        ->  Parallel Hash  (cost=99780.01..99780.01 rows=1378482 width=12)
--                                              ->  Parallel Index Scan using bookings_paid on bookings b  (cost=0.43..99780.01 rows=1378482 width=12)
--  JIT:
--    Functions: 19
--    Options: Inlining true, Optimization true, Expressions true, Deforming true
-- (19 rows)

-- ...и увеличим количество воркеров
set max_parallel_workers_per_gather = 4;

-- План на ~10,000,000 строк после индекса и увеличения воркеров
-- QUERY PLAN
-- ---------------------------------------------------------------------------------------------------------------------------------------------------
--  Limit  (cost=821162.57..821162.57 rows=1 width=24)
--    ->  Sort  (cost=821162.57..826465.75 rows=2121273 width=24)
--          Sort Key: (count(*)) DESC
--          ->  Finalize GroupAggregate  (cost=341257.84..810556.20 rows=2121273 width=24)
--                Group Key: ((s.date_time)::date)
--                ->  Gather Merge  (cost=341257.84..753924.44 rows=3308356 width=28)
--                      Workers Planned: 4
--                      ->  Partial GroupAggregate  (cost=340257.78..358867.29 rows=827089 width=28)
--                            Group Key: ((s.date_time)::date)
--                            ->  Sort  (cost=340257.78..342325.51 rows=827089 width=20)
--                                  Sort Key: ((s.date_time)::date)
--                                  ->  Parallel Hash Join  (cost=108643.70..249270.52 rows=827089 width=20)
--                                        Hash Cond: (s.id = b.showtime_id)
--                                        ->  Parallel Seq Scan on showtimes s  (cost=0.00..98628.00 rows=2502500 width=12)
--                                        ->  Parallel Hash  (cost=94266.09..94266.09 rows=827089 width=12)
--                                              ->  Parallel Index Scan using bookings_paid on bookings b  (cost=0.43..94266.09 rows=827089 width=12)
--  JIT:
--    Functions: 19
--    Options: Inlining true, Optimization true, Expressions true, Deforming true
-- (19 rows)


---- 5) самый популярный фильм на вечерних сеансах (после 20-00)
select s.movie_id as movie, count(b.id) as visited
from showtimes s
         inner join bookings b on s.id = b.showtime_id
where b.status_id = 3 and s.date_time::time between '20:00:00' and '23:59:59'
group by s.movie_id
order by visited desc
limit 1;
-- Результат на ~10,000 строк
-- movie | visited
-- -------+---------
--     12 |      12
-- (1 row)
--
-- План на ~10,000 строк
-- postgres=# explain select s.movie_id as movie, count(b.id) as visited
-- postgres-# from showtimes s
-- postgres-#     inner join bookings b on s.id = b.showtime_id
-- postgres-# where b.status_id = 3 and s.date_time::time between '20:00:00' and '23:59:59'
-- postgres-# group by s.movie_id
-- postgres-# order by visited desc
-- postgres-# limit 1;
-- QUERY PLAN
-- -------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
--  Limit  (cost=546.59..546.59 rows=1 width=12)
--    ->  Sort  (cost=546.59..546.63 rows=17 width=12)
--          Sort Key: (count(b.id)) DESC
--          ->  GroupAggregate  (cost=546.21..546.50 rows=17 width=12)
--                Group Key: s.movie_id
--                ->  Sort  (cost=546.21..546.25 rows=17 width=8)
--                      Sort Key: s.movie_id
--                      ->  Hash Join  (cost=348.62..545.86 rows=17 width=8)
--                            Hash Cond: (b.showtime_id = s.id)
--                            ->  Seq Scan on bookings b  (cost=0.00..188.45 rows=3346 width=8)
--                                  Filter: (status_id = 3)
--                            ->  Hash  (cost=348.00..348.00 rows=50 width=8)
--                                  ->  Seq Scan on showtimes s  (cost=0.00..348.00 rows=50 width=8)
--                                        Filter: (((date_time)::time without time zone >= '20:00:00'::time without time zone) AND ((date_time)::time without time zone <= '23:59:59'::time without time zone))
-- (14 rows)

-- Результат на ~10,000,000 строк
-- movie | visited
-- -------+---------
--     52 |    5768
-- (1 row)

-- План на ~10,000,000 строк
-- QUERY PLAN
-- -------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
--  Limit  (cost=277731.94..277731.94 rows=1 width=12)
--    ->  Sort  (cost=277731.94..277732.19 rows=100 width=12)
--          Sort Key: (count(b.id)) DESC
--          ->  Finalize GroupAggregate  (cost=277653.67..277731.44 rows=100 width=12)
--                Group Key: s.movie_id
--                ->  Gather Merge  (cost=277653.67..277729.44 rows=200 width=12)
--                      Workers Planned: 2
--                      ->  Partial GroupAggregate  (cost=276653.64..276706.33 rows=100 width=12)
--                            Group Key: s.movie_id
--                            ->  Sort  (cost=276653.64..276670.87 rows=6892 width=8)
--                                  Sort Key: s.movie_id
--                                  ->  Parallel Hash Join  (cost=157280.27..276214.25 rows=6892 width=8)
--                                        Hash Cond: (b.showtime_id = s.id)
--                                        ->  Parallel Seq Scan on bookings b  (cost=0.00..115315.42 rows=1378503 width=8)
--                                              Filter: (status_id = 3)
--                                        ->  Parallel Hash  (cost=157019.59..157019.59 rows=20854 width=8)
--                                              ->  Parallel Seq Scan on showtimes s  (cost=0.00..157019.59 rows=20854 width=8)
--                                                    Filter: (((date_time)::time without time zone >= '20:00:00'::time without time zone) AND ((date_time)::time without time zone <= '23:59:59'::time without time zone))
--  JIT:
--    Functions: 24
--    Options: Inlining false, Optimization false, Expressions true, Deforming true
-- (21 rows)

create or replace function get_time(datetime timestamp with time zone) returns time without time zone as
'select datetime::time;'
    language sql immutable returns null on null input;

create index showtimes_evening on showtimes (date_time) where get_time(date_time) between '20:00:00' and '23:59:59';
-- Немного изменим запрос
select s.movie_id as movie, count(b.id) as visited
from showtimes s
         inner join bookings b on s.id = b.showtime_id
where b.status_id = 3 and (get_time(s.date_time) >= '20:00:00') and (get_time(s.date_time) <= '23:59:59')
group by s.movie_id
order by visited desc
limit 1;
-- План на ~10,000,000 строк после двух индексов
-- QUERY PLAN
-- ---------------------------------------------------------------------------------------------------------------------------------
--  Limit  (cost=167913.44..167913.44 rows=1 width=12)
--    ->  Sort  (cost=167913.44..167913.69 rows=100 width=12)
--          Sort Key: (count(b.id)) DESC
--          ->  GroupAggregate  (cost=167787.87..167912.94 rows=100 width=12)
--                Group Key: s.movie_id
--                ->  Sort  (cost=167787.87..167829.23 rows=16542 width=8)
--                      Sort Key: s.movie_id
--                      ->  Hash Join  (cost=38866.02..166628.79 rows=16542 width=8)
--                            Hash Cond: (b.showtime_id = s.id)
--                            ->  Index Scan using bookings_paid on bookings b  (cost=0.43..119078.76 rows=3308356 width=8)
--                            ->  Hash  (cost=38239.97..38239.97 rows=50050 width=8)
--                                  ->  Index Scan using showtimes_evening on showtimes s  (cost=0.43..38239.97 rows=50050 width=8)
--  JIT:
--    Functions: 17
--    Options: Inlining false, Optimization false, Expressions true, Deforming true
-- (15 rows)


---- 6) самый прибыльный фильм (макс 1)
select st.movie_id as movie, sum(b.price) as profit
from showtimes st
         inner join bookings b on st.id = b.showtime_id
where b.status_id = 3
group by st.movie_id
order by profit desc
limit 1;
-- Результат на ~10,000 строк
-- movie | profit
-- -------+---------
--     93 | $286.90
-- (1 row)
--
-- План на ~10,000 строк
-- postgres=# explain select st.movie_id as movie, sum(b.price) as profit
--                    from showtimes st
--                             inner join bookings b on st.id = b.showtime_id
--                    where b.status_id = 3
--                    group by st.movie_id
--                    order by profit desc
--                    limit 1;
-- QUERY PLAN
-- ------------------------------------------------------------------------------------------------
--  Limit  (cost=588.46..588.47 rows=1 width=12)
--    ->  Sort  (cost=588.46..588.71 rows=100 width=12)
--          Sort Key: (sum(b.price)) DESC
--          ->  HashAggregate  (cost=586.96..587.96 rows=100 width=12)
--                Group Key: st.movie_id
--                ->  Hash Join  (cost=373.00..570.23 rows=3346 width=12)
--                      Hash Cond: (b.showtime_id = st.id)
--                      ->  Seq Scan on bookings b  (cost=0.00..188.45 rows=3346 width=12)
--                            Filter: (status_id = 3)
--                      ->  Hash  (cost=248.00..248.00 rows=10000 width=8)
--                            ->  Seq Scan on showtimes st  (cost=0.00..248.00 rows=10000 width=8)
-- (11 rows)

-- Результат на ~10,000,000 строк
-- movie |   profit
-- -------+-------------
--     30 | $170,347.82
-- (1 row)

-- План на ~10,000,000 строк
-- QUERY PLAN
-- -------------------------------------------------------------------------------------------------------------------------------
--  Limit  (cost=323213.07..323213.07 rows=1 width=12)
--    ->  Sort  (cost=323213.07..323213.32 rows=100 width=12)
--          Sort Key: (sum(b.price)) DESC
--          ->  Finalize GroupAggregate  (cost=323187.23..323212.57 rows=100 width=12)
--                Group Key: st.movie_id
--                ->  Gather Merge  (cost=323187.23..323210.57 rows=200 width=12)
--                      Workers Planned: 2
--                      ->  Sort  (cost=322187.21..322187.46 rows=100 width=12)
--                            Sort Key: st.movie_id
--                            ->  Partial HashAggregate  (cost=322182.89..322183.89 rows=100 width=12)
--                                  Group Key: st.movie_id
--                                  ->  Parallel Hash Join  (cost=139277.70..315290.37 rows=1378503 width=12)
--                                        Hash Cond: (st.id = b.showtime_id)
--                                        ->  Parallel Seq Scan on showtimes st  (cost=0.00..115311.30 rows=4170830 width=8)
--                                        ->  Parallel Hash  (cost=115315.42..115315.42 rows=1378503 width=12)
--                                              ->  Parallel Seq Scan on bookings b  (cost=0.00..115315.42 rows=1378503 width=12)
--                                                    Filter: (status_id = 3)
--  JIT:
--    Functions: 21
--    Options: Inlining false, Optimization false, Expressions true, Deforming true
-- (20 rows)

-- Создадим частичный индекс...
create index bookings_paid on bookings (status_id) where status_id = 3;
-- ...и увеличим количество воркеров
set max_parallel_workers_per_gather = 4;
-- QUERY PLAN
-- ---------------------------------------------------------------------------------------------------------------------------------------------------
--  Limit  (cost=247506.01..247506.02 rows=1 width=12)
--    ->  Sort  (cost=247506.01..247506.26 rows=100 width=12)
--          Sort Key: (sum(b.price)) DESC
--          ->  Finalize GroupAggregate  (cost=247454.62..247505.51 rows=100 width=12)
--                Group Key: st.movie_id
--                ->  Gather Merge  (cost=247454.62..247502.51 rows=400 width=12)
--                      Workers Planned: 4
--                      ->  Sort  (cost=246454.56..246454.81 rows=100 width=12)
--                            Sort Key: st.movie_id
--                            ->  Partial HashAggregate  (cost=246450.24..246451.24 rows=100 width=12)
--                                  Group Key: st.movie_id
--                                  ->  Parallel Hash Join  (cost=108643.70..242314.79 rows=827089 width=12)
--                                        Hash Cond: (st.id = b.showtime_id)
--                                        ->  Parallel Seq Scan on showtimes st  (cost=0.00..98628.00 rows=2502500 width=8)
--                                        ->  Parallel Hash  (cost=94266.09..94266.09 rows=827089 width=12)
--                                              ->  Parallel Index Scan using bookings_paid on bookings b  (cost=0.43..94266.09 rows=827089 width=12)
--  JIT:
--    Functions: 19
--    Options: Inlining false, Optimization false, Expressions true, Deforming true
-- (19 rows)

-- Ещё из доступный улучшений можно использовать таблицы со сбором статистики, например по посещаемости фильмов.
-- Наполнять такие таблицы можно триггерами или фоновыми задачами (крон).

-- 15 самых больших по размеру объектов БД
select relname from pg_class order by relpages desc  limit 15;
-- postgres=# select relname from pg_class order by relpages desc  limit 15;
-- relname
-- ---------------------------
--  showtimes
--  bookings
--  unique_seat_showtime
--  showtimes_pkey
--  showtimes_days
--  bookings_pkey
--  bookings_paid
--  showtimes_evening
--  pg_proc
--  pg_toast_2618
--  pg_depend
--  pg_attribute
--  pg_depend_reference_index
--  pg_description
--  pg_depend_depender_index
-- (15 rows)

-- 5 самых часто используемых индексов
select indexrelname from pg_stat_user_indexes order by idx_scan desc limit 5;
-- postgres=# select indexrelname from pg_stat_user_indexes order by idx_scan desc limit 5;
-- indexrelname
-- -----------------------
--  unique_seat_showtime
--  halls_pkey
--  bookings_pkey
--  showtimes_pkey
--  booking_statuses_pkey
-- (5 rows)

-- 5 самых редко используемых индексов
select indexrelname from pg_stat_user_indexes order by idx_scan asc limit 5;
-- postgres=# select indexrelname from pg_stat_user_indexes order by idx_scan asc limit 5;
-- indexrelname
-- ------------------------------------
--  movie_attribute_types_pkey
--  booking_status_titles_unique
--  hall_titles_unique
--  cinema_titles_unique
--  movie_attribute_type_titles_unique
-- (5 rows)