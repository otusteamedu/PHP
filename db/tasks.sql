-------- 3 простых запроса

---- 1) сумма проданных билетов
select sum(price) from bookings where status_id = 3;
-- Результат на ~10,000 строк
-- sum
-- ------------
--  $16,876.49
-- (1 row)

-- План на ~10,000 строк
-- postgres=# explain analyze select sum(price) from bookings where status_id = 3;
-- QUERY PLAN
-- --------------------------------------------------------------------------------------------------------------
--  Aggregate  (cost=189.73..189.74 rows=1 width=8) (actual time=1.718..1.719 rows=1 loops=1)
--    ->  Seq Scan on bookings  (cost=0.00..189.60 rows=50 width=8) (actual time=0.020..1.429 rows=3254 loops=1)
--          Filter: (status_id = 3)
--          Rows Removed by Filter: 6700
--  Planning Time: 0.095 ms
--  Execution Time: 1.760 ms
-- (6 rows)

-- План на ~10,000,000 строк
-- postgres=# explain analyze select sum(price) from bookings where status_id = 3;
-- QUERY PLAN
-- --------------------------------------------------------------------------------------------------------------------------------------------------
--  Finalize Aggregate  (cost=119778.40..119778.41 rows=1 width=8) (actual time=1790.995..1790.996 rows=1 loops=1)
--    ->  Gather  (cost=119778.19..119778.40 rows=2 width=8) (actual time=1790.107..1806.335 rows=3 loops=1)
--          Workers Planned: 2
--          Workers Launched: 2
--          ->  Partial Aggregate  (cost=118778.19..118778.20 rows=1 width=8) (actual time=1721.234..1721.234 rows=1 loops=3)
--                ->  Parallel Seq Scan on bookings  (cost=0.00..115309.96 rows=1387290 width=8) (actual time=16.554..1557.077 rows=1106271 loops=3)
--                      Filter: (status_id = 3)
--                      Rows Removed by Filter: 2213594
--  Planning Time: 0.244 ms
--  JIT:
--    Functions: 17
--    Options: Inlining false, Optimization false, Expressions true, Deforming true
--    Timing: Generation 8.759 ms, Inlining 0.000 ms, Optimization 5.790 ms, Emission 42.930 ms, Total 57.479 ms
--  Execution Time: 1807.864 ms
-- (14 rows)

-- Данных настолько много, что планировщик предлагает нам параллельные выборки
-- Создадим частичный индекс
create index bookings_paid on bookings (status_id) where status_id = 3;
-- Ввиду (неожиданно) низкой селективности индекса пришлось сделать
set random_page_cost = 1;

-- План на ~10,000,000 строк после индекса
-- postgres=# explain analyze select sum(price) from bookings where status_id = 3;
-- QUERY PLAN
-- --------------------------------------------------------------------------------------------------------------------------------------------------------------------
--  Finalize Aggregate  (cost=97159.23..97159.24 rows=1 width=8) (actual time=1491.486..1491.487 rows=1 loops=1)
--    ->  Gather  (cost=97158.81..97159.22 rows=4 width=8) (actual time=1479.772..1501.101 rows=5 loops=1)
--          Workers Planned: 4
--          Workers Launched: 4
--          ->  Partial Aggregate  (cost=96158.81..96158.82 rows=1 width=8) (actual time=1400.672..1400.673 rows=1 loops=5)
--                ->  Parallel Index Scan using bookings_paid on bookings  (cost=0.43..94077.88 rows=832373 width=8) (actual time=3.267..1179.942 rows=663763 loops=5)
--  Planning Time: 0.301 ms
--  Execution Time: 1501.170 ms
-- (8 rows)

-- Время выполнения первого запроса 1807 мсек, второго - 1501 мсек, то есть запрос ускорился на 20%

---- 2) сколько фильмов демонстрируется в 3D формате
select count(*) from showtimes where format = '3D';
-- Результат на ~10,000 строк
-- count
-- -------
--   5012
-- (1 row)

-- postgres=# explain analyze select count(*) from showtimes where format = '3D';
-- QUERY PLAN
-- -----------------------------------------------------------------------------------------------------------------
--  Aggregate  (cost=211.64..211.65 rows=1 width=8) (actual time=1.683..1.683 rows=1 loops=1)
--    ->  Seq Scan on showtimes  (cost=0.00..199.00 rows=5055 width=0) (actual time=0.014..1.356 rows=5055 loops=1)
--          Filter: ((format)::text = '3D'::text)
--          Rows Removed by Filter: 4945
--  Planning Time: 0.171 ms
--  Execution Time: 1.732 ms
-- (6 rows)

-- План на ~10,000,000 строк
-- postgres=# explain analyze select count(*) from showtimes where format = '3D';
-- QUERY PLAN
-- ---------------------------------------------------------------------------------------------------------------------------------------------------
--  Finalize Aggregate  (cost=132010.26..132010.27 rows=1 width=8) (actual time=2299.950..2299.950 rows=1 loops=1)
--    ->  Gather  (cost=132010.05..132010.26 rows=2 width=8) (actual time=2299.936..2302.081 rows=3 loops=1)
--          Workers Planned: 2
--          Workers Launched: 2
--          ->  Partial Aggregate  (cost=131010.05..131010.06 rows=1 width=8) (actual time=2242.339..2242.340 rows=1 loops=3)
--                ->  Parallel Seq Scan on showtimes  (cost=0.00..125738.46 rows=2108636 width=0) (actual time=14.049..1947.083 rows=1667341 loops=3)
--                      Filter: ((format)::text = '3D'::text)
--                      Rows Removed by Filter: 1669325
--  Planning Time: 1.760 ms
--  JIT:
--    Functions: 14
--    Options: Inlining false, Optimization false, Expressions true, Deforming true
--    Timing: Generation 11.879 ms, Inlining 0.000 ms, Optimization 1.050 ms, Emission 40.290 ms, Total 53.219 ms
--  Execution Time: 2303.394 ms
-- (14 rows)

-- Тут нет особого смысла строить индекс и собирать статистику в отдельной таблице. Но есть ещё один способ ускорить запрос
-- Увеличим количество воркеров на узел
set max_parallel_workers_per_gather = 4;

-- План на ~10,000,000 строк после увеличения количества вркеров
-- postgres=# explain analyze select count(*) from showtimes where format = '3D';
-- QUERY PLAN
-- ---------------------------------------------------------------------------------------------------------------------------------------------------
--  Finalize Aggregate  (cost=109047.65..109047.66 rows=1 width=8) (actual time=1921.395..1921.395 rows=1 loops=1)
--    ->  Gather  (cost=109047.23..109047.64 rows=4 width=8) (actual time=1918.889..1924.426 rows=5 loops=1)
--          Workers Planned: 4
--          Workers Launched: 4
--          ->  Partial Aggregate  (cost=108047.23..108047.24 rows=1 width=8) (actual time=1823.589..1823.590 rows=1 loops=5)
--                ->  Parallel Seq Scan on showtimes  (cost=0.00..104884.27 rows=1265182 width=0) (actual time=31.397..1534.582 rows=1000405 loops=5)
--                      Filter: ((format)::text = '3D'::text)
--                      Rows Removed by Filter: 1001595
--  Planning Time: 0.111 ms
--  JIT:
--    Functions: 22
--    Options: Inlining false, Optimization false, Expressions true, Deforming true
--    Timing: Generation 3.197 ms, Inlining 0.000 ms, Optimization 1.590 ms, Emission 136.279 ms, Total 141.066 ms
--  Execution Time: 1925.454 ms
-- (14 rows)

-- Время выполнения первого запроса 2303 мсек, второго - 1925 мсек, то есть запрос ускорился на 20%


---- 3) в какой день было больше всего сеансов (макс 1)
select date_time::date, count(*) from showtimes group by date_time::date order by count(*) desc limit 1;

-- План на ~10,000 строк
-- postgres=# explain analyze select date_time::date, count(*) from showtimes group by date_time::date order by count(*) desc limit 1;
-- QUERY PLAN
-- -------------------------------------------------------------------------------------------------------------------------------
--  Limit  (cost=423.84..423.85 rows=1 width=12) (actual time=3.831..3.833 rows=1 loops=1)
--    ->  Sort  (cost=423.84..448.82 rows=9991 width=12) (actual time=3.829..3.829 rows=1 loops=1)
--          Sort Key: (count(*)) DESC
--          Sort Method: top-N heapsort  Memory: 25kB
--          ->  HashAggregate  (cost=249.00..373.89 rows=9991 width=12) (actual time=3.734..3.807 rows=31 loops=1)
--                Group Key: (date_time)::date
--                ->  Seq Scan on showtimes  (cost=0.00..199.00 rows=10000 width=4) (actual time=0.014..2.263 rows=10000 loops=1)
--  Planning Time: 0.152 ms
--  Execution Time: 4.008 ms
-- (9 rows)

-- План на ~10,000,000 строк
-- postgres=# explain analyze select date_time::date, count(*) from showtimes group by date_time::date order by count(*) desc limit 1;
-- QUERY PLAN
-- ----------------------------------------------------------------------------------------------------------------------------------------------------------------------
--  Limit  (cost=1302517.98..1302517.99 rows=1 width=12) (actual time=9111.300..9111.409 rows=1 loops=1)
--    ->  Sort  (cost=1302517.98..1307796.04 rows=2111223 width=12) (actual time=9015.765..9015.765 rows=1 loops=1)
--          Sort Key: (count(*)) DESC
--          Sort Method: top-N heapsort  Memory: 25kB
--          ->  Finalize GroupAggregate  (cost=699412.75..1291961.87 rows=2111223 width=12) (actual time=7185.396..9015.647 rows=31 loops=1)
--                Group Key: ((date_time)::date)
--                ->  Gather Merge  (cost=699412.75..1244459.35 rows=4222446 width=12) (actual time=7121.638..9015.561 rows=93 loops=1)
--                      Workers Planned: 2
--                      Workers Launched: 2
--                      ->  Partial GroupAggregate  (cost=698412.72..756084.29 rows=2111223 width=12) (actual time=7008.985..8892.899 rows=31 loops=3)
--                            Group Key: ((date_time)::date)
--                            ->  Sort  (cost=698412.72..708839.82 rows=4170837 width=4) (actual time=6994.229..8202.342 rows=3336667 loops=3)
--                                  Sort Key: ((date_time)::date)
--                                  Sort Method: external merge  Disk: 47952kB
--                                  Worker 0:  Sort Method: external merge  Disk: 44424kB
--                                  Worker 1:  Sort Method: external merge  Disk: 45000kB
--                                  ->  Parallel Seq Scan on showtimes  (cost=0.00..125738.46 rows=4170837 width=4) (actual time=243.083..2582.092 rows=3336667 loops=3)
--  Planning Time: 0.257 ms
--  JIT:
--    Functions: 22
--    Options: Inlining true, Optimization true, Expressions true, Deforming true
--    Timing: Generation 6.861 ms, Inlining 407.101 ms, Optimization 231.522 ms, Emission 185.108 ms, Total 830.591 ms
--  Execution Time: 9122.711 ms
-- (23 rows)

create or replace function get_date(datetime timestamp with time zone) returns date as
'select datetime::date;'
language sql immutable returns null on null input;

create index showtimes_days on showtimes (get_date(date_time));

-- Выполним
set max_parallel_workers_per_gather = 4;

-- Немного изменим запрос, чтобы использовать новый индекс
select get_date(date_time), count(*) from showtimes group by get_date(date_time) order by count(*) desc limit 1;

-- План на ~10,000,000 строк после увеличения количества воркеров и индекса
-- QUERY PLAN
-- --------------------------------------------------------------------------------------------------------------------------------------------------------------------
--  Limit  (cost=3363264.00..3363264.00 rows=1 width=12) (actual time=30031.945..30031.946 rows=1 loops=1)
--    ->  Sort  (cost=3363264.00..3368542.05 rows=2111221 width=12) (actual time=29981.415..29981.415 rows=1 loops=1)
--          Sort Key: (count(*)) DESC
--          Sort Method: top-N heapsort  Memory: 25kB
--          ->  GroupAggregate  (cost=0.43..3352707.90 rows=2111221 width=12) (actual time=363.471..29981.300 rows=31 loops=1)
--                Group Key: get_date(date_time)
--                ->  Index Scan using showtimes_days on showtimes  (cost=0.43..2753740.44 rows=10010000 width=4) (actual time=0.226..29195.706 rows=10010000 loops=1)
--  Planning Time: 0.343 ms
--  JIT:
--    Functions: 6
--    Options: Inlining true, Optimization true, Expressions true, Deforming true
--    Timing: Generation 0.912 ms, Inlining 4.452 ms, Optimization 23.655 ms, Emission 22.207 ms, Total 51.227 ms
--  Execution Time: 30032.961 ms
-- (13 rows)

-- Время выполнения первого запроса 9122 мсек, второго - 30032 мсек, то есть запрос замедлился примерно в 3 раза
-- Как мы видим, в первом случае планировщиком был выбран параллельный метод сканирования, и он оказался быстрее, чем использование индексного сканирования
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

-- План на ~10,000 строк
-- QUERY PLAN
-- ----------------------------------------------------------------------------------------------------------------------------------------------
--  Limit  (cost=593.59..593.59 rows=1 width=24) (actual time=6.961..6.966 rows=1 loops=1)
--    ->  Sort  (cost=593.59..601.72 rows=3254 width=24) (actual time=6.959..6.959 rows=1 loops=1)
--          Sort Key: (count(*)) DESC
--          Sort Method: top-N heapsort  Memory: 25kB
--          ->  HashAggregate  (cost=528.51..577.32 rows=3254 width=24) (actual time=6.915..6.939 rows=31 loops=1)
--                Group Key: (s.date_time)::date
--                ->  Hash Join  (cost=299.00..504.10 rows=3254 width=20) (actual time=3.378..6.301 rows=3254 loops=1)
--                      Hash Cond: (b.showtime_id = s.id)
--                      ->  Seq Scan on bookings b  (cost=0.00..188.43 rows=3254 width=12) (actual time=0.012..1.314 rows=3254 loops=1)
--                            Filter: (status_id = 3)
--                            Rows Removed by Filter: 6700
--                      ->  Hash  (cost=174.00..174.00 rows=10000 width=12) (actual time=3.302..3.302 rows=10000 loops=1)
--                            Buckets: 16384  Batches: 1  Memory Usage: 558kB
--                            ->  Seq Scan on showtimes s  (cost=0.00..174.00 rows=10000 width=12) (actual time=0.006..1.673 rows=10000 loops=1)
--  Planning Time: 0.454 ms
--  Execution Time: 7.064 ms
-- (16 rows)

-- План на ~10,000,000 строк
-- QUERY PLAN
-- ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
--  Limit  (cost=941068.14..941068.14 rows=1 width=24) (actual time=14898.888..15001.578 rows=1 loops=1)
--    ->  Sort  (cost=941068.14..946346.19 rows=2111223 width=24) (actual time=14675.041..14675.041 rows=1 loops=1)
--          Sort Key: (count(*)) DESC
--          Sort Method: top-N heapsort  Memory: 25kB
--          ->  Finalize GroupAggregate  (cost=526564.92..930512.02 rows=2111223 width=24) (actual time=13981.691..14674.889 rows=31 loops=1)
--                Group Key: ((s.date_time)::date)
--                ->  Gather Merge  (cost=526564.92..878034.33 rows=2774580 width=28) (actual time=13957.536..14777.255 rows=93 loops=1)
--                      Workers Planned: 2
--                      Workers Launched: 2
--                      ->  Partial GroupAggregate  (cost=525564.90..556778.93 rows=1387290 width=28) (actual time=13890.911..14571.483 rows=31 loops=3)
--                            Group Key: ((s.date_time)::date)
--                            ->  Sort  (cost=525564.90..529033.13 rows=1387290 width=20) (actual time=13886.762..14331.111 rows=1106271 loops=3)
--                                  Sort Key: ((s.date_time)::date)
--                                  Sort Method: external merge  Disk: 37072kB
--                                  Worker 0:  Sort Method: external merge  Disk: 36504kB
--                                  Worker 1:  Sort Method: external merge  Disk: 36920kB
--                                  ->  Parallel Hash Join  (cost=139425.09..327131.70 rows=1387290 width=20) (actual time=6707.954..12137.894 rows=1106271 loops=3)
--                                        Hash Cond: (s.id = b.showtime_id)
--                                        ->  Parallel Seq Scan on showtimes s  (cost=0.00..115311.37 rows=4170837 width=12) (actual time=0.072..1969.601 rows=3336667 loops=3)
--                                        ->  Parallel Hash  (cost=115309.96..115309.96 rows=1387290 width=12) (actual time=2504.784..2504.786 rows=1106271 loops=3)
--                                              Buckets: 131072  Batches: 64  Memory Usage: 3520kB
--                                              ->  Parallel Seq Scan on bookings b  (cost=0.00..115309.96 rows=1387290 width=12) (actual time=485.503..1795.149 rows=1106271 loops=3)
--                                                    Filter: (status_id = 3)
--                                                    Rows Removed by Filter: 2213594
--  Planning Time: 7.902 ms
--  JIT:
--    Functions: 55
--    Options: Inlining true, Optimization true, Expressions true, Deforming true
--    Timing: Generation 14.432 ms, Inlining 467.144 ms, Optimization 674.530 ms, Emission 537.239 ms, Total 1693.346 ms
--  Execution Time: 15011.305 ms
-- (30 rows)

-- Создадим частичный индекс...
create index bookings_paid on bookings (status_id) where status_id = 3;
-- (пришлось сделать SET random_page_cost = 1;)
-- ...и увеличим количество воркеров
set max_parallel_workers_per_gather = 4;

-- План на ~10,000,000 строк после индекса и увеличения воркеров
-- QUERY PLAN
-- -------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
--  Limit  (cost=824332.30..824332.30 rows=1 width=24) (actual time=15721.580..15857.090 rows=1 loops=1)
--    ->  Sort  (cost=824332.30..829610.35 rows=2111221 width=24) (actual time=15488.974..15488.974 rows=1 loops=1)
--          Sort Key: (count(*)) DESC
--          Sort Method: top-N heapsort  Memory: 25kB
--          ->  Finalize GroupAggregate  (cost=341833.70..813776.19 rows=2111221 width=24) (actual time=14796.452..15488.858 rows=31 loops=1)
--                Group Key: ((s.date_time)::date)
--                ->  Gather Merge  (cost=341833.70..757136.69 rows=3329492 width=28) (actual time=14779.223..15624.044 rows=155 loops=1)
--                      Workers Planned: 4
--                      Workers Launched: 4
--                      ->  Partial GroupAggregate  (cost=340833.64..359562.03 rows=832373 width=28) (actual time=14650.732..15267.671 rows=31 loops=5)
--                            Group Key: ((s.date_time)::date)
--                            ->  Sort  (cost=340833.64..342914.57 rows=832373 width=20) (actual time=14642.981..15041.041 rows=663763 loops=5)
--                                  Sort Key: ((s.date_time)::date)
--                                  Sort Method: external merge  Disk: 22352kB
--                                  Worker 0:  Sort Method: external merge  Disk: 21960kB
--                                  Worker 1:  Sort Method: external merge  Disk: 21960kB
--                                  Worker 2:  Sort Method: external merge  Disk: 21960kB
--                                  Worker 3:  Sort Method: external merge  Disk: 22272kB
--                                  ->  Parallel Hash Join  (cost=108547.54..249226.78 rows=832373 width=20) (actual time=7527.862..12824.899 rows=663763 loops=5)
--                                        Hash Cond: (s.id = b.showtime_id)
--                                        ->  Parallel Seq Scan on showtimes s  (cost=0.00..98628.00 rows=2502500 width=12) (actual time=0.086..2063.412 rows=2002000 loops=5)
--                                        ->  Parallel Hash  (cost=94077.88..94077.88 rows=832373 width=12) (actual time=3262.580..3262.581 rows=663763 loops=5)
--                                              Buckets: 131072  Batches: 64  Memory Usage: 3552kB
--                                              ->  Parallel Index Scan using bookings_paid on bookings b  (cost=0.43..94077.88 rows=832373 width=12) (actual time=993.418..2535.490 rows=663763 loops=5)
--  Planning Time: 0.505 ms
--  JIT:
--    Functions: 79
--    Options: Inlining true, Optimization true, Expressions true, Deforming true
--    Timing: Generation 9.618 ms, Inlining 1550.142 ms, Optimization 2051.717 ms, Emission 1584.574 ms, Total 5196.051 ms
--  Execution Time: 15863.908 ms
-- (30 rows)

-- Время выполнения первого запроса 15011 мсек, второго - 15863 мсек, то есть запрос незначительно замедлился
-- Попробуем вернуть SET random_page_cost = DEFAULT;
-- QUERY PLAN
-- ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
--  Limit  (cost=832132.15..832132.15 rows=1 width=24) (actual time=14869.594..14986.301 rows=1 loops=1)
--    ->  Sort  (cost=832132.15..837410.20 rows=2111221 width=24) (actual time=14654.238..14654.239 rows=1 loops=1)
--          Sort Key: (count(*)) DESC
--          Sort Method: top-N heapsort  Memory: 25kB
--          ->  Finalize GroupAggregate  (cost=349633.55..821576.04 rows=2111221 width=24) (actual time=13930.464..14654.123 rows=31 loops=1)
--                Group Key: ((s.date_time)::date)
--                ->  Gather Merge  (cost=349633.55..764936.54 rows=3329492 width=28) (actual time=13909.918..14769.931 rows=155 loops=1)
--                      Workers Planned: 4
--                      Workers Launched: 4
--                      ->  Partial GroupAggregate  (cost=348633.49..367361.88 rows=832373 width=28) (actual time=13799.098..14474.259 rows=31 loops=5)
--                            Group Key: ((s.date_time)::date)
--                            ->  Sort  (cost=348633.49..350714.42 rows=832373 width=20) (actual time=13796.593..14220.638 rows=663763 loops=5)
--                                  Sort Key: ((s.date_time)::date)
--                                  Sort Method: external merge  Disk: 22168kB
--                                  Worker 0:  Sort Method: external merge  Disk: 21760kB
--                                  Worker 1:  Sort Method: external merge  Disk: 22416kB
--                                  Worker 2:  Sort Method: external merge  Disk: 21920kB
--                                  Worker 3:  Sort Method: external merge  Disk: 22232kB
--                                  ->  Parallel Hash Join  (cost=109030.39..249709.63 rows=832373 width=20) (actual time=7216.424..12334.131 rows=663763 loops=5)
--                                        Hash Cond: (s.id = b.showtime_id)
--                                        ->  Parallel Seq Scan on showtimes s  (cost=0.00..98628.00 rows=2502500 width=12) (actual time=0.090..2057.581 rows=2002000 loops=5)
--                                        ->  Parallel Hash  (cost=94560.73..94560.73 rows=832373 width=12) (actual time=3009.094..3009.095 rows=663763 loops=5)
--                                              Buckets: 131072  Batches: 64  Memory Usage: 3520kB
--                                              ->  Parallel Seq Scan on bookings b  (cost=0.00..94560.73 rows=832373 width=12) (actual time=975.624..2283.570 rows=663763 loops=5)
--                                                    Filter: (status_id = 3)
--                                                    Rows Removed by Filter: 1328156
--  Planning Time: 0.543 ms
--  JIT:
--    Functions: 89
--    Options: Inlining true, Optimization true, Expressions true, Deforming true
--    Timing: Generation 25.815 ms, Inlining 1490.142 ms, Optimization 2030.703 ms, Emission 1570.180 ms, Total 5116.840 ms
--  Execution Time: 14993.178 ms
-- (32 rows)
-- Время выполнения первого запроса 15011 мсек, третьего - 14993 мсек, то есть запрос незначительно ускорился


---- 5) самый популярный фильм на вечерних сеансах (после 20-00)
select s.movie_id as movie, count(b.id) as visited
from showtimes s
         inner join bookings b on s.id = b.showtime_id
where b.status_id = 3 and s.date_time::time between '20:00:00' and '23:59:59'
group by s.movie_id
order by visited desc
limit 1;

-- План на ~10,000 строк
-- QUERY PLAN
-- -------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
--  Limit  (cost=472.27..472.27 rows=1 width=12) (actual time=4.510..4.515 rows=1 loops=1)
--    ->  Sort  (cost=472.27..472.31 rows=16 width=12) (actual time=4.508..4.508 rows=1 loops=1)
--          Sort Key: (count(b.id)) DESC
--          Sort Method: top-N heapsort  Memory: 25kB
--          ->  GroupAggregate  (cost=471.91..472.19 rows=16 width=12) (actual time=4.359..4.489 rows=99 loops=1)
--                Group Key: s.movie_id
--                ->  Sort  (cost=471.91..471.95 rows=16 width=8) (actual time=4.349..4.391 rows=571 loops=1)
--                      Sort Key: s.movie_id
--                      Sort Method: quicksort  Memory: 51kB
--                      ->  Hash Join  (cost=274.62..471.59 rows=16 width=8) (actual time=2.402..4.233 rows=571 loops=1)
--                            Hash Cond: (b.showtime_id = s.id)
--                            ->  Seq Scan on bookings b  (cost=0.00..188.43 rows=3254 width=8) (actual time=0.016..1.360 rows=3254 loops=1)
--                                  Filter: (status_id = 3)
--                                  Rows Removed by Filter: 6700
--                            ->  Hash  (cost=274.00..274.00 rows=50 width=8) (actual time=2.368..2.368 rows=1648 loops=1)
--                                  Buckets: 2048 (originally 1024)  Batches: 1 (originally 1)  Memory Usage: 81kB
--                                  ->  Seq Scan on showtimes s  (cost=0.00..274.00 rows=50 width=8) (actual time=0.009..2.120 rows=1648 loops=1)
--                                        Filter: (((date_time)::time without time zone >= '20:00:00'::time without time zone) AND ((date_time)::time without time zone <= '23:59:59'::time without time zone))
--                                        Rows Removed by Filter: 8352
--  Planning Time: 0.338 ms
--  Execution Time: 4.744 ms
-- (21 rows)

-- План на ~10,000,000 строк
-- QUERY PLAN
-- -------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
--  Limit  (cost=277753.15..277753.15 rows=1 width=12) (actual time=7424.365..7501.100 rows=1 loops=1)
--    ->  Sort  (cost=277753.15..277753.40 rows=100 width=12) (actual time=7403.151..7403.151 rows=1 loops=1)
--          Sort Key: (count(b.id)) DESC
--          Sort Method: top-N heapsort  Memory: 25kB
--          ->  Finalize GroupAggregate  (cost=277674.54..277752.65 rows=100 width=12) (actual time=7282.080..7403.068 rows=100 loops=1)
--                Group Key: s.movie_id
--                ->  Gather Merge  (cost=277674.54..277750.65 rows=200 width=12) (actual time=7281.651..7479.637 rows=300 loops=1)
--                      Workers Planned: 2
--                      Workers Launched: 2
--                      ->  Partial GroupAggregate  (cost=276674.52..276727.54 rows=100 width=12) (actual time=7215.392..7336.605 rows=100 loops=3)
--                            Group Key: s.movie_id
--                            ->  Sort  (cost=276674.52..276691.86 rows=6936 width=8) (actual time=7215.132..7279.419 rows=184111 loops=3)
--                                  Sort Key: s.movie_id
--                                  Sort Method: external merge  Disk: 3320kB
--                                  Worker 0:  Sort Method: external merge  Disk: 3200kB
--                                  Worker 1:  Sort Method: external merge  Disk: 3272kB
--                                  ->  Parallel Hash Join  (cost=157280.41..276232.01 rows=6936 width=8) (actual time=5500.346..6991.227 rows=184111 loops=3)
--                                        Hash Cond: (b.showtime_id = s.id)
--                                        ->  Parallel Seq Scan on bookings b  (cost=0.00..115309.96 rows=1387290 width=8) (actual time=1.956..1469.247 rows=1106271 loops=3)
--                                              Filter: (status_id = 3)
--                                              Rows Removed by Filter: 2213594
--                                        ->  Parallel Hash  (cost=157019.73..157019.73 rows=20854 width=8) (actual time=3176.698..3176.699 rows=555836 loops=3)
--                                              Buckets: 131072 (originally 65536)  Batches: 32 (originally 1)  Memory Usage: 3136kB
--                                              ->  Parallel Seq Scan on showtimes s  (cost=0.00..157019.73 rows=20854 width=8) (actual time=38.801..2376.598 rows=555836 loops=3)
--                                                    Filter: (((date_time)::time without time zone >= '20:00:00'::time without time zone) AND ((date_time)::time without time zone <= '23:59:59'::time without time zone))
--                                                    Rows Removed by Filter: 2780831
--  Planning Time: 1.707 ms
--  JIT:
--    Functions: 64
--    Options: Inlining false, Optimization false, Expressions true, Deforming true
--    Timing: Generation 26.842 ms, Inlining 0.000 ms, Optimization 11.135 ms, Emission 117.051 ms, Total 155.028 ms
--  Execution Time: 7505.990 ms
-- (32 rows)

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
-- ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
--  Limit  (cost=167947.51..167947.51 rows=1 width=12) (actual time=13632.384..13632.390 rows=1 loops=1)
--    ->  Sort  (cost=167947.51..167947.76 rows=100 width=12) (actual time=13618.146..13618.146 rows=1 loops=1)
--          Sort Key: (count(b.id)) DESC
--          Sort Method: top-N heapsort  Memory: 25kB
--          ->  GroupAggregate  (cost=167821.16..167947.01 rows=100 width=12) (actual time=13492.757..13617.980 rows=100 loops=1)
--                Group Key: s.movie_id
--                ->  Sort  (cost=167821.16..167862.77 rows=16647 width=8) (actual time=13492.096..13561.394 rows=552333 loops=1)
--                      Sort Key: s.movie_id
--                      Sort Method: external merge  Disk: 9784kB
--                      ->  Hash Join  (cost=38865.40..166653.95 rows=16647 width=8) (actual time=9869.930..13285.267 rows=552333 loops=1)
--                            Hash Cond: (b.showtime_id = s.id)
--                            ->  Index Scan using bookings_paid on bookings b  (cost=0.43..119049.07 rows=3329492 width=8) (actual time=0.073..1007.937 rows=3318813 loops=1)
--                            ->  Hash  (cost=38239.34..38239.34 rows=50050 width=8) (actual time=9869.349..9869.350 rows=1667507 loops=1)
--                                  Buckets: 131072 (originally 65536)  Batches: 32 (originally 1)  Memory Usage: 3073kB
--                                  ->  Index Scan using showtimes_evening on showtimes s  (cost=0.43..38239.34 rows=50050 width=8) (actual time=0.049..9281.008 rows=1667507 loops=1)
--  Planning Time: 0.796 ms
--  JIT:
--    Functions: 17
--    Options: Inlining false, Optimization false, Expressions true, Deforming true
--    Timing: Generation 2.073 ms, Inlining 0.000 ms, Optimization 0.875 ms, Emission 13.122 ms, Total 16.071 ms
--  Execution Time: 13637.043 ms
-- (21 rows)

-- Время выполнения первого запроса 7505 мсек, второго - 13637 мсек, то есть запрос замедлился в 2 раза


---- 6) самый прибыльный фильм (макс 1)
select st.movie_id as movie, sum(b.price) as profit
from showtimes st
         inner join bookings b on st.id = b.showtime_id
where b.status_id = 3
group by st.movie_id
order by profit desc
limit 1;

-- План на ~10,000 строк
-- QUERY PLAN
-- ----------------------------------------------------------------------------------------------------------------------------------------------
--  Limit  (cost=513.74..513.74 rows=1 width=12) (actual time=6.231..6.236 rows=1 loops=1)
--    ->  Sort  (cost=513.74..513.99 rows=100 width=12) (actual time=6.230..6.230 rows=1 loops=1)
--          Sort Key: (sum(b.price)) DESC
--          Sort Method: top-N heapsort  Memory: 25kB
--          ->  HashAggregate  (cost=512.24..513.24 rows=100 width=12) (actual time=6.169..6.183 rows=100 loops=1)
--                Group Key: st.movie_id
--                ->  Hash Join  (cost=299.00..495.97 rows=3254 width=12) (actual time=3.137..5.334 rows=3254 loops=1)
--                      Hash Cond: (b.showtime_id = st.id)
--                      ->  Seq Scan on bookings b  (cost=0.00..188.43 rows=3254 width=12) (actual time=0.012..1.189 rows=3254 loops=1)
--                            Filter: (status_id = 3)
--                            Rows Removed by Filter: 6700
--                      ->  Hash  (cost=174.00..174.00 rows=10000 width=8) (actual time=3.081..3.081 rows=10000 loops=1)
--                            Buckets: 16384  Batches: 1  Memory Usage: 519kB
--                            ->  Seq Scan on showtimes st  (cost=0.00..174.00 rows=10000 width=8) (actual time=0.006..1.700 rows=10000 loops=1)
--  Planning Time: 0.266 ms
--  Execution Time: 6.287 ms
-- (16 rows)

-- План на ~10,000,000 строк
-- QUERY PLAN
-- -----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
--  Limit  (cost=323484.10..323484.11 rows=1 width=12) (actual time=12222.662..13171.019 rows=1 loops=1)
--    ->  Sort  (cost=323484.10..323484.35 rows=100 width=12) (actual time=12208.414..12208.414 rows=1 loops=1)
--          Sort Key: (sum(b.price)) DESC
--          Sort Method: top-N heapsort  Memory: 25kB
--          ->  Finalize GroupAggregate  (cost=323458.27..323483.60 rows=100 width=12) (actual time=12206.884..12208.374 rows=100 loops=1)
--                Group Key: st.movie_id
--                ->  Gather Merge  (cost=323458.27..323481.60 rows=200 width=12) (actual time=12203.902..13155.926 rows=300 loops=1)
--                      Workers Planned: 2
--                      Workers Launched: 2
--                      ->  Sort  (cost=322458.25..322458.50 rows=100 width=12) (actual time=12147.248..12147.264 rows=100 loops=3)
--                            Sort Key: st.movie_id
--                            Sort Method: quicksort  Memory: 29kB
--                            Worker 0:  Sort Method: quicksort  Memory: 29kB
--                            Worker 1:  Sort Method: quicksort  Memory: 29kB
--                            ->  Partial HashAggregate  (cost=322453.92..322454.92 rows=100 width=12) (actual time=12147.177..12147.191 rows=100 loops=3)
--                                  Group Key: st.movie_id
--                                  ->  Parallel Hash Join  (cost=139425.09..315517.47 rows=1387290 width=12) (actual time=6678.370..11594.679 rows=1106271 loops=3)
--                                        Hash Cond: (st.id = b.showtime_id)
--                                        ->  Parallel Seq Scan on showtimes st  (cost=0.00..115311.37 rows=4170837 width=8) (actual time=0.071..2275.527 rows=3336667 loops=3)
--                                        ->  Parallel Hash  (cost=115309.96..115309.96 rows=1387290 width=12) (actual time=2340.494..2340.495 rows=1106271 loops=3)
--                                              Buckets: 131072  Batches: 64  Memory Usage: 3520kB
--                                              ->  Parallel Seq Scan on bookings b  (cost=0.00..115309.96 rows=1387290 width=12) (actual time=26.415..1554.920 rows=1106271 loops=3)
--                                                    Filter: (status_id = 3)
--                                                    Rows Removed by Filter: 2213594
--  Planning Time: 0.305 ms
--  JIT:
--    Functions: 55
--    Options: Inlining false, Optimization false, Expressions true, Deforming true
--    Timing: Generation 13.799 ms, Inlining 0.000 ms, Optimization 10.202 ms, Emission 82.137 ms, Total 106.137 ms
--  Execution Time: 13173.581 ms
-- (30 rows)

-- Создадим частичный индекс...
create index bookings_paid on bookings (status_id) where status_id = 3;
-- ...и увеличим количество воркеров
set max_parallel_workers_per_gather = 4;

-- План на ~10,000,000 строк после индекса и увеличения количества воркеров
-- QUERY PLAN
-- --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
--  Limit  (cost=247958.34..247958.34 rows=1 width=12) (actual time=12002.265..12390.169 rows=1 loops=1)
--    ->  Sort  (cost=247958.34..247958.59 rows=100 width=12) (actual time=11987.600..11987.601 rows=1 loops=1)
--          Sort Key: (sum(b.price)) DESC
--          Sort Method: top-N heapsort  Memory: 25kB
--          ->  Finalize GroupAggregate  (cost=247906.94..247957.84 rows=100 width=12) (actual time=11987.374..11987.567 rows=100 loops=1)
--                Group Key: st.movie_id
--                ->  Gather Merge  (cost=247906.94..247954.84 rows=400 width=12) (actual time=11987.344..12375.215 rows=500 loops=1)
--                      Workers Planned: 4
--                      Workers Launched: 4
--                      ->  Sort  (cost=246906.89..246907.14 rows=100 width=12) (actual time=11869.401..11869.411 rows=100 loops=5)
--                            Sort Key: st.movie_id
--                            Sort Method: quicksort  Memory: 29kB
--                            Worker 0:  Sort Method: quicksort  Memory: 29kB
--                            Worker 1:  Sort Method: quicksort  Memory: 29kB
--                            Worker 2:  Sort Method: quicksort  Memory: 29kB
--                            Worker 3:  Sort Method: quicksort  Memory: 29kB
--                            ->  Partial HashAggregate  (cost=246902.56..246903.56 rows=100 width=12) (actual time=11869.313..11869.328 rows=100 loops=5)
--                                  Group Key: st.movie_id
--                                  ->  Parallel Hash Join  (cost=109030.39..242740.70 rows=832373 width=12) (actual time=6578.141..11253.477 rows=663763 loops=5)
--                                        Hash Cond: (st.id = b.showtime_id)
--                                        ->  Parallel Seq Scan on showtimes st  (cost=0.00..98628.00 rows=2502500 width=8) (actual time=0.086..2342.483 rows=2002000 loops=5)
--                                        ->  Parallel Hash  (cost=94560.73..94560.73 rows=832373 width=12) (actual time=2338.147..2338.147 rows=663763 loops=5)
--                                              Buckets: 131072  Batches: 64  Memory Usage: 3552kB
--                                              ->  Parallel Seq Scan on bookings b  (cost=0.00..94560.73 rows=832373 width=12) (actual time=48.871..1566.612 rows=663763 loops=5)
--                                                    Filter: (status_id = 3)
--                                                    Rows Removed by Filter: 1328156
--  Planning Time: 0.340 ms
--  JIT:
--    Functions: 89
--    Options: Inlining false, Optimization false, Expressions true, Deforming true
--    Timing: Generation 26.508 ms, Inlining 0.000 ms, Optimization 3.569 ms, Emission 253.809 ms, Total 283.886 ms
--  Execution Time: 12393.197 ms
-- (32 rows)

-- Время выполнения первого запроса 13173 мсек, второго - 12393 мсек, то есть запрос незначительно ускорился

-- Выводы:
-- 1. Существует много способов ускорить запросы к БД, например оптимизация самого запроса, создание индексов (частичных
--     или функциональных), денормализация, создание аналитических таблиц и наполнение их триггерами например.
-- 2. Индексы не всегда приводят к ускорению запросов. Сильно зависит от селективности индекса. Если она низкая, то
--     не надо форсить такие индексы - запрос может замедлиться.
-- 3. Создавать специальные аналитические таблицы стоит только тогда, когда информация из них нужна часто. Иначе мы
--     неоправданно замедлим вставку в таблицы-источники данных
-- 4. Денормализацию нужно применять осторожно, чтобы ускорив одни запросы, не замедлить другие.

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