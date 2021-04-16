SELECT 'halls' AS table_name, COUNT(*) FROM halls
UNION
SELECT 'places' AS table_name, COUNT(*) FROM places
UNION
SELECT 'events' AS table_name, COUNT(*) FROM events
UNION
SELECT 'orders' AS table_name, COUNT(*) FROM orders
UNION
SELECT 'films' AS table_name, COUNT(*) FROM films
UNION
SELECT 'users' AS table_name, COUNT(*) FROM users
UNION
SELECT 'order_statuses' AS table_name, COUNT(*) FROM order_statuses
UNION
SELECT 'filmAttributeValues' AS table_name, COUNT(*) FROM "filmAttributeValues"
UNION
SELECT 'filmAttributes' AS table_name, COUNT(*) FROM "filmAttributes"
UNION
SELECT 'filmAttributeTypes' AS table_name, COUNT(*) FROM "filmAttributeTypes";
-- 10k
-- 1M
-- table_name           |  count
-- ---------------------+---------
--  filmAttributes      |      10
--  films               | 1000000
--  halls               |      30
--  users               |    1000
--  orders              |  996342
--  events              |  998734
--  order_statuses      |       3
--  filmAttributeValues | 1000000
--  filmAttributeTypes  |       5
--  places              |    6000



---------- 1 analysis: select * from events where datetime > '2020-01-01 00:00:00.000000';
--
drop index events_datetime_ind;
explain analyse select * from events where datetime > '2020-01-01 00:00:00.000000';
-- 10k
-- QUERY PLAN
-- -------------------------------------------------------------------------------------------------------
--  Seq Scan on events  (cost=0.00..199.00 rows=889 width=71) (actual time=0.011..1.363 rows=847 loops=1)
--    Filter: (datetime > '2020-01-01 00:00:00'::timestamp without time zone)
--    Rows Removed by Filter: 9153
--  Planning time: 0.182 ms
--  Execution time: 1.433 ms

-- 1M
-- QUERY PLAN
-- ---------------------------------------------------------------------------------------------------------------
--  Seq Scan on events  (cost=0.00..19828.18 rows=98812 width=71) (actual time=0.025..136.099 rows=90728 loops=1)
--    Filter: (datetime > '2020-01-01 00:00:00'::timestamp without time zone)
--    Rows Removed by Filter: 908006
--  Planning time: 0.254 ms
--  Execution time: 142.093 ms


create index events_datetime_ind on "events" using btree ("datetime");
explain analyse select * from events where datetime > '2020-01-01 00:00:00.000000';
-- 10k
-- QUERY PLAN
-- ---------------------------------------------------------------------------------------------------------------------------------
--  Bitmap Heap Scan on events  (cost=19.17..104.29 rows=889 width=71) (actual time=0.081..0.340 rows=847 loops=1)
--    Recheck Cond: (datetime > '2020-01-01 00:00:00'::timestamp without time zone)
--    Heap Blocks: exact=74
--    ->  Bitmap Index Scan on events_datetime_ind  (cost=0.00..18.95 rows=889 width=0) (actual time=0.067..0.067 rows=847 loops=1)
--          Index Cond: (datetime > '2020-01-01 00:00:00'::timestamp without time zone)
--  Planning time: 0.165 ms
--  Execution time: 0.421 ms

-- 1M
-- QUERY PLAN
-- -------------------------------------------------------------------------------------------
-- Bitmap Heap Scan on events  (cost=1854.22..10433.37 rows=98812 width=71) (actual time=9.467..57.230 rows=90728 loops=1)
--    Recheck Cond: (datetime > '2020-01-01 00:00:00'::timestamp without time zone)
--    Heap Blocks: exact=7344
--    ->  Bitmap Index Scan on events_datetime_ind  (cost=0.00..1829.51 rows=98812 width=0) (actual time=8.031..8.031 rows=90728 loops=1)
--          Index Cond: (datetime > '2020-01-01 00:00:00'::timestamp without time zone)
--  Planning time: 0.200 ms
--  Execution time: 63.116 ms

-- *
explain analyse select * from events where datetime > '2020-01-01 00:00:00.000000' limit 20;
-- QUERY PLAN
-- ----------------------------------------------------------------------------------------------------------------
-- 10k

-- 1M
--  Limit  (cost=0.00..4.01 rows=20 width=71) (actual time=0.030..0.117 rows=20 loops=1)
--    ->  Seq Scan on events  (cost=0.00..19828.18 rows=98812 width=71) (actual time=0.028..0.107 rows=20 loops=1)
--          Filter: (datetime > '2020-01-01 00:00:00'::timestamp without time zone)
--          Rows Removed by Filter: 217
--  Planning time: 0.209 ms
--  Execution time: 0.159 ms

----- CONCLUSION 1 -----
-- наличие индекса дает выигрыш в 2 раза
-- *но, если добавляем в запрос ограничение на лимит, и планировщику становится не выгодно использовать индекс



---------- 2 analysis: select * from events where comment = 'aaaa%';
--
drop index events_comment_ind;
explain analyse select * from events where comment = 'aaaa%';
-- 10k
-- QUERY PLAN
-- ---------------------------------------------------------------------------------------------------
--  Seq Scan on events  (cost=0.00..199.00 rows=1 width=71) (actual time=1.290..1.291 rows=0 loops=1)
--    Filter: ((comment)::text = 'aaaa%'::text)
--    Rows Removed by Filter: 10000
--  Planning time: 0.065 ms
--  Execution time: 1.307 ms

-- 1M
-- QUERY PLAN
-- ----------------------------------------------------------------------------------------------------------------------
--  Gather  (cost=1000.00..13545.84 rows=1 width=71) (actual time=46.780..52.315 rows=0 loops=1)
--    Workers Planned: 2
--    Workers Launched: 2
--    ->  Parallel Seq Scan on events  (cost=0.00..12545.74 rows=1 width=71) (actual time=42.757..42.757 rows=0 loops=3)
--          Filter: ((comment)::text = 'aaaa%'::text)
--          Rows Removed by Filter: 332911
--  Planning time: 0.229 ms
--  Execution time: 52.358 ms

create index events_comment_ind on "events" using btree ("comment");
explain analyse select * from events where comment = 'aaaa%';
-- 10k
-- QUERY PLAN
-- ----------------------------------------------------------------------------------------------------------------------------
--  Index Scan using events_comment_ind on events  (cost=0.29..8.30 rows=1 width=71) (actual time=0.014..0.014 rows=0 loops=1)
--    Index Cond: ((comment)::text = 'aaaa%'::text)
--  Planning time: 0.166 ms
--  Execution time: 0.032 ms

-- 1M
-- QUERY PLAN
-- ----------------------------------------------------------------------------------------------------------------------
-- Index Scan using events_comment_ind on events  (cost=0.42..8.44 rows=1 width=71) (actual time=0.017..0.017 rows=0 loops=1)
--    Index Cond: ((comment)::text = 'aaaa%'::text)
--  Planning time: 0.181 ms
--  Execution time: 0.035 ms

----- CONCLUSION 2 -----
-- индекс творит чудеса: 1000х прирост производительности



---------- 3 analysis: select * from events where price > 50 and price < 200;
--
drop index events_price_ind;
explain analyse select * from events where price > 50 and price < 200;
-- 10k
-- QUERY PLAN
-- ---------------------------------------------------------------------------------------------------
--  Seq Scan on events  (cost=0.00..224.00 rows=1 width=71) (actual time=3.133..3.134 rows=0 loops=1)
--    Filter: ((price > '50'::numeric) AND (price < '200'::numeric))
--    Rows Removed by Filter: 10000
--  Planning time: 0.086 ms
--  Execution time: 3.147 ms

-- 1M
-- QUERY PLAN
-- ----------------------------------------------------------------------------------------------------------------------
-- Gather  (cost=1000.00..14586.19 rows=1 width=71) (actual time=110.067..114.484 rows=0 loops=1)
--    Workers Planned: 2
--    Workers Launched: 2
--    ->  Parallel Seq Scan on events  (cost=0.00..13586.09 rows=1 width=71) (actual time=107.365..107.365 rows=0 loops=3)
--          Filter: ((price > '50'::numeric) AND (price < '200'::numeric))
--          Rows Removed by Filter: 332911
--  Planning time: 0.128 ms
--  Execution time: 114.505 ms


create index events_price_ind on "events" using btree ("price");
explain analyse select * from events where price > 50 and price < 200;
-- 10k
-- QUERY PLAN
-- --------------------------------------------------------------------------------------------------------------------------
--  Index Scan using events_price_ind on events  (cost=0.29..8.30 rows=1 width=71) (actual time=0.050..0.051 rows=0 loops=1)
--    Index Cond: ((price > '50'::numeric) AND (price < '200'::numeric))
--  Planning time: 0.765 ms
--  Execution time: 0.104 ms

-- 1M
-- QUERY PLAN
-- ----------------------------------------------------------------------------------------------------------------------
-- Index Scan using events_price_ind on events  (cost=0.42..8.45 rows=1 width=71) (actual time=0.076..0.076 rows=0 loops=1)
--    Index Cond: ((price > '50'::numeric) AND (price < '200'::numeric))
--  Planning time: 0.485 ms
--  Execution time: 0.115 ms


----- CONCLUSION 3 -----
-- индекс творит чудеса: 1000х прирост производительности




--- запросы посложнее



---------- 4 analysis:
-- select sum(e.price) as amount_money, f.title
-- from films f
--                  left join events e ON e.film_id = f.id
--                  left join orders o on e.id = o.event_id
--         WHERE o.order_status_id = 2
--         GROUP BY f.title
--         ORDER BY amount_money
--                         DESC
--                         LIMIT 1;
--
drop index orders_orderstatusid2_ind;
explain analyse select sum(e.price) as amount_money, f.title
                from films f
                         left join events e ON e.film_id = f.id
                         left join orders o on e.id = o.event_id
                WHERE o.order_status_id = 2
                GROUP BY f.title
                ORDER BY amount_money
                         DESC
                         LIMIT 1;
-- 10k
-- Limit  (cost=983.75..983.75 rows=1 width=42) (actual time=21.536..21.538 rows=1 loops=1)
--    ->  Sort  (cost=983.75..996.10 rows=4940 width=42) (actual time=21.534..21.536 rows=1 loops=1)
--          Sort Key: (sum(e.price)) DESC
--          Sort Method: top-N heapsort  Memory: 25kB
--          ->  HashAggregate  (cost=897.30..959.05 rows=4940 width=42) (actual time=19.227..20.663 rows=3260 loops=1)
--                Group Key: f.title
--                ->  Hash Join  (cost=648.00..872.60 rows=4940 width=15) (actual time=10.731..16.746 rows=4940 loops=1)
--                      Hash Cond: (e.film_id = f.id)
--                      ->  Hash Join  (cost=299.00..510.63 rows=4940 width=9) (actual time=4.345..8.254 rows=4940 loops=1)
--                            Hash Cond: (o.event_id = e.id)
--                            ->  Seq Scan on orders o  (cost=0.00..198.66 rows=4940 width=4) (actual time=0.007..1.883 rows=4940 loops=1)
--                                  Filter: (order_status_id = 2)
--                                  Rows Removed by Filter: 5033
--                            ->  Hash  (cost=174.00..174.00 rows=10000 width=13) (actual time=4.323..4.324 rows=10000 loops=1)
--                                  Buckets: 16384  Batches: 1  Memory Usage: 597kB
--                                  ->  Seq Scan on events e  (cost=0.00..174.00 rows=10000 width=13) (actual time=0.006..2.369 rows=10000 loops=1)
--                      ->  Hash  (cost=224.00..224.00 rows=10000 width=14) (actual time=6.354..6.355 rows=10000 loops=1)
--                            Buckets: 16384  Batches: 1  Memory Usage: 597kB
--                            ->  Seq Scan on films f  (cost=0.00..224.00 rows=10000 width=14) (actual time=0.017..3.019 rows=10000 loops=1)
--  Planning time: 1.431 ms
--  Execution time: 21.673 ms

-- 1M
-- QUERY PLAN
-- ----------------------------------------------------------------------------------------------------------------------
-- Limit  (cost=186262.22..186262.22 rows=1 width=44) (actual time=6545.712..6545.716 rows=1 loops=1)
--    ->  Sort  (cost=186262.22..187523.92 rows=504680 width=44) (actual time=6545.710..6545.713 rows=1 loops=1)
--          Sort Key: (sum(e.price)) DESC
--          Sort Method: top-N heapsort  Memory: 25kB
--          ->  GroupAggregate  (cost=173645.22..183738.82 rows=504680 width=44) (actual time=5130.780..6435.667 rows=324364 loops=1)
--                Group Key: f.title
--                ->  Sort  (cost=173645.22..174906.92 rows=504680 width=17) (actual time=5130.767..6117.538 rows=498489 loops=1)
--                      Sort Key: f.title
--                      Sort Method: external merge  Disk: 13664kB
--                      ->  Hash Join  (cost=74421.51..115486.38 rows=504680 width=17) (actual time=1044.130..2251.403 rows=498489 loops=1)
--                            Hash Cond: (e.film_id = f.id)
--                            ->  Hash Join  (cost=34692.51..64619.59 rows=504680 width=9) (actual time=490.993..1146.779 rows=498489 loops=1)
--                                  Hash Cond: (o.event_id = e.id)
--                                  ->  Seq Scan on orders o  (cost=0.00..19781.28 rows=504680 width=4) (actual time=0.012..202.460 rows=498489 loops=1)
--                                        Filter: (order_status_id = 2)
--                                        Rows Removed by Filter: 497853
--                                  ->  Hash  (cost=17331.34..17331.34 rows=998734 width=13) (actual time=490.389..490.390 rows=998734 loops=1)
--                                        Buckets: 131072  Batches: 16  Memory Usage: 3957kB
--                                        ->  Seq Scan on events e  (cost=0.00..17331.34 rows=998734 width=13) (actual time=0.007..237.088 rows=998734 loops=1)
--                            ->  Hash  (cost=22346.00..22346.00 rows=1000000 width=16) (actual time=546.499..546.500 rows=1000000 loops=1)
--                                  Buckets: 131072 (originally 131072)  Batches: 32 (originally 16)  Memory Usage: 3073kB
--                                  ->  Seq Scan on films f  (cost=0.00..22346.00 rows=1000000 width=16) (actual time=0.016..243.004 rows=1000000 loops=1)
--  Planning time: 10.540 ms
--  Execution time: 6548.427 ms



create index orders_orderstatusid2_ind on "orders" using btree ("order_status_id") where order_status_id = 2;
explain analyse select sum(e.price) as amount_money, f.title
                from films f
                         left join events e ON e.film_id = f.id
                         left join orders o on e.id = o.event_id
                WHERE o.order_status_id = 2
                GROUP BY f.title
                ORDER BY amount_money
                           DESC
                           LIMIT 1;
-- 10k
-- QUERY PLAN
-- -------------------------------------------------------------------------------------------------------------------------------------------------
--  Limit  (cost=983.75..983.75 rows=1 width=42) (actual time=21.408..21.410 rows=1 loops=1)
--    ->  Sort  (cost=983.75..996.10 rows=4940 width=42) (actual time=21.406..21.408 rows=1 loops=1)
--          Sort Key: (sum(e.price)) DESC
--          Sort Method: top-N heapsort  Memory: 25kB
--          ->  HashAggregate  (cost=897.30..959.05 rows=4940 width=42) (actual time=19.128..20.537 rows=3260 loops=1)
--                Group Key: f.title
--                ->  Hash Join  (cost=648.00..872.60 rows=4940 width=15) (actual time=10.905..16.780 rows=4940 loops=1)
--                      Hash Cond: (e.film_id = f.id)
--                      ->  Hash Join  (cost=299.00..510.63 rows=4940 width=9) (actual time=4.365..8.211 rows=4940 loops=1)
--                            Hash Cond: (o.event_id = e.id)
--                            ->  Seq Scan on orders o  (cost=0.00..198.66 rows=4940 width=4) (actual time=0.007..1.873 rows=4940 loops=1)
--                                  Filter: (order_status_id = 2)
--                                  Rows Removed by Filter: 5033
--                            ->  Hash  (cost=174.00..174.00 rows=10000 width=13) (actual time=4.344..4.345 rows=10000 loops=1)
--                                  Buckets: 16384  Batches: 1  Memory Usage: 597kB
--                                  ->  Seq Scan on events e  (cost=0.00..174.00 rows=10000 width=13) (actual time=0.005..2.376 rows=10000 loops=1)
--                      ->  Hash  (cost=224.00..224.00 rows=10000 width=14) (actual time=6.509..6.510 rows=10000 loops=1)
--                            Buckets: 16384  Batches: 1  Memory Usage: 597kB
--                            ->  Seq Scan on films f  (cost=0.00..224.00 rows=10000 width=14) (actual time=0.016..3.086 rows=10000 loops=1)
--  Planning time: 1.086 ms
--  Execution time: 21.543 ms

-- 1M
-- QUERY PLAN
-- ----------------------------------------------------------------------------------------------------------------------
-- Limit  (cost=186262.22..186262.22 rows=1 width=44) (actual time=6505.058..6505.062 rows=1 loops=1)
--    ->  Sort  (cost=186262.22..187523.92 rows=504680 width=44) (actual time=6505.056..6505.059 rows=1 loops=1)
--          Sort Key: (sum(e.price)) DESC
--          Sort Method: top-N heapsort  Memory: 25kB
--          ->  GroupAggregate  (cost=173645.22..183738.82 rows=504680 width=44) (actual time=5089.057..6394.357 rows=324364 loops=1)
--                Group Key: f.title
--                ->  Sort  (cost=173645.22..174906.92 rows=504680 width=17) (actual time=5089.043..6077.240 rows=498489 loops=1)
--                      Sort Key: f.title
--                      Sort Method: external merge  Disk: 13664kB
--                      ->  Hash Join  (cost=74421.51..115486.38 rows=504680 width=17) (actual time=1002.828..2208.805 rows=498489 loops=1)
--                            Hash Cond: (e.film_id = f.id)
--                            ->  Hash Join  (cost=34692.51..64619.59 rows=504680 width=9) (actual time=484.372..1137.425 rows=498489 loops=1)
--                                  Hash Cond: (o.event_id = e.id)
--                                  ->  Seq Scan on orders o  (cost=0.00..19781.28 rows=504680 width=4) (actual time=0.013..199.029 rows=498489 loops=1)
--                                        Filter: (order_status_id = 2)
--                                        Rows Removed by Filter: 497853
--                                  ->  Hash  (cost=17331.34..17331.34 rows=998734 width=13) (actual time=484.281..484.281 rows=998734 loops=1)
--                                        Buckets: 131072  Batches: 16  Memory Usage: 3957kB
--                                        ->  Seq Scan on events e  (cost=0.00..17331.34 rows=998734 width=13) (actual time=0.007..237.679 rows=998734 loops=1)
--                            ->  Hash  (cost=22346.00..22346.00 rows=1000000 width=16) (actual time=516.408..516.409 rows=1000000 loops=1)
--                                  Buckets: 131072 (originally 131072)  Batches: 32 (originally 16)  Memory Usage: 3073kB
--                                  ->  Seq Scan on films f  (cost=0.00..22346.00 rows=1000000 width=16) (actual time=0.019..222.811 rows=1000000 loops=1)
--  Planning time: 1.502 ms
--  Execution time: 6507.759 ms


----- CONCLUSION 4 -----
-- в данном случаес индекс orders_orderstatusid2_ind не был использованом



---------- 5 analysis:
-- select
--             f.id,
--             f.title,
--             fav.val_bool,
--             fa.title,
--             fat.title
--         from films f
--                  join "filmAttributeValues" fav on f.id = fav.film_id
--                  join "filmAttributes" fa on fav.attribute_id = fa.id
--                  join "filmAttributeTypes" fat on fa.type_id = fat.id
--         where fav.val_bool = true;
--
drop index fav_booltrue_ind;
explain analyse select
                         f.id,
                         f.title,
                         fav.val_bool,
                         fa.title,
                         fat.title
                from films f
                         join "filmAttributeValues" fav on f.id = fav.film_id
                         join "filmAttributes" fa on fav.attribute_id = fa.id
                         join "filmAttributeTypes" fat on fa.type_id = fat.id
                where fav.val_bool = true;
-- 10k
-- QUERY PLAN
-- ---------------------------------------------------------------------------------------------------------------------------------------------
--  Hash Join  (cost=388.35..636.30 rows=1255 width=291) (actual time=5.676..8.635 rows=1255 loops=1)
--    Hash Cond: (fa.type_id = fat.id)
--    ->  Hash Join  (cost=369.35..613.97 rows=1255 width=157) (actual time=5.651..8.102 rows=1255 loops=1)
--          Hash Cond: (fav.attribute_id = fa.id)
--          ->  Hash Join  (cost=349.00..590.29 rows=1255 width=19) (actual time=5.632..7.570 rows=1255 loops=1)
--                Hash Cond: (fav.film_id = f.id)
--                ->  Seq Scan on "filmAttributeValues" fav  (cost=0.00..238.00 rows=1255 width=9) (actual time=0.008..1.392 rows=1255 loops=1)
--                      Filter: val_bool
--                      Rows Removed by Filter: 8745
--                ->  Hash  (cost=224.00..224.00 rows=10000 width=14) (actual time=5.608..5.609 rows=10000 loops=1)
--                      Buckets: 16384  Batches: 1  Memory Usage: 586kB
--                      ->  Seq Scan on films f  (cost=0.00..224.00 rows=10000 width=14) (actual time=0.007..2.593 rows=10000 loops=1)
--          ->  Hash  (cost=14.60..14.60 rows=460 width=146) (actual time=0.014..0.014 rows=10 loops=1)
--                Buckets: 1024  Batches: 1  Memory Usage: 9kB
--                ->  Seq Scan on "filmAttributes" fa  (cost=0.00..14.60 rows=460 width=146) (actual time=0.004..0.008 rows=10 loops=1)
--    ->  Hash  (cost=14.00..14.00 rows=400 width=142) (actual time=0.017..0.017 rows=5 loops=1)
--          Buckets: 1024  Batches: 1  Memory Usage: 9kB
--          ->  Seq Scan on "filmAttributeTypes" fat  (cost=0.00..14.00 rows=400 width=142) (actual time=0.010..0.012 rows=5 loops=1)
--  Planning time: 0.839 ms
--  Execution time: 8.771 ms

-- 1M
-- QUERY PLAN
-- ----------------------------------------------------------------------------------------------------------------------
--  Hash Join  (cost=42114.04..64245.12 rows=125067 width=293) (actual time=526.852..992.545 rows=124483 loops=1)
--    Hash Cond: (fa.type_id = fat.id)
--    ->  Hash Join  (cost=42095.04..63894.34 rows=125067 width=159) (actual time=526.819..944.074 rows=124483 loops=1)
--          Hash Cond: (fav.attribute_id = fa.id)
--          ->  Hash Join  (cost=42074.69..63542.67 rows=125067 width=21) (actual time=526.791..893.342 rows=124483 loops=1)
--                Hash Cond: (fav.film_id = f.id)
--                ->  Bitmap Heap Scan on "filmAttributeValues" fav  (cost=2345.69..17380.36 rows=125067 width=9) (actual time=24.182..168.067 rows=124483 loops=1)
--                      Filter: val_bool
--                      Heap Blocks: exact=13783
--                      ->  Bitmap Index Scan on fav_bool_index  (cost=0.00..2314.43 rows=125067 width=0) (actual time=21.481..21.482 rows=124483 loops=1)
--                            Index Cond: (val_bool = true)
--                ->  Hash  (cost=22346.00..22346.00 rows=1000000 width=16) (actual time=502.326..502.326 rows=1000000 loops=1)
--                      Buckets: 131072  Batches: 16  Memory Usage: 4015kB
--                      ->  Seq Scan on films f  (cost=0.00..22346.00 rows=1000000 width=16) (actual time=0.008..226.458 rows=1000000 loops=1)
--          ->  Hash  (cost=14.60..14.60 rows=460 width=146) (actual time=0.020..0.020 rows=10 loops=1)
--                Buckets: 1024  Batches: 1  Memory Usage: 9kB
--                ->  Seq Scan on "filmAttributes" fa  (cost=0.00..14.60 rows=460 width=146) (actual time=0.006..0.012 rows=10 loops=1)
--    ->  Hash  (cost=14.00..14.00 rows=400 width=142) (actual time=0.021..0.021 rows=5 loops=1)
--          Buckets: 1024  Batches: 1  Memory Usage: 9kB
--          ->  Seq Scan on "filmAttributeTypes" fat  (cost=0.00..14.00 rows=400 width=142) (actual time=0.010..0.013 rows=5 loops=1)
--  Planning time: 1.235 ms
--  Execution time: 1000.847 ms




create index fav_booltrue_ind on "filmAttributeValues" using btree ("val_bool") where val_bool = true;
explain analyse select
                           f.id,
                           f.title,
                           fav.val_bool,
                           fa.title,
                           fat.title
                from films f
                         join "filmAttributeValues" fav on f.id = fav.film_id
                         join "filmAttributes" fa on fav.attribute_id = fa.id
                         join "filmAttributeTypes" fat on fa.type_id = fat.id
                where fav.val_bool = true;
-- 10k
-- QUERY PLAN
-- ---------------------------------------------------------------------------------------------------------------------------------------------
--  Hash Join  (cost=388.35..636.30 rows=1255 width=291) (actual time=7.207..10.156 rows=1255 loops=1)
--    Hash Cond: (fa.type_id = fat.id)
--    ->  Hash Join  (cost=369.35..613.97 rows=1255 width=157) (actual time=7.172..9.606 rows=1255 loops=1)
--          Hash Cond: (fav.attribute_id = fa.id)
--          ->  Hash Join  (cost=349.00..590.29 rows=1255 width=19) (actual time=7.144..9.064 rows=1255 loops=1)
--                Hash Cond: (fav.film_id = f.id)
--                ->  Seq Scan on "filmAttributeValues" fav  (cost=0.00..238.00 rows=1255 width=9) (actual time=0.010..1.380 rows=1255 loops=1)
--                      Filter: val_bool
--                      Rows Removed by Filter: 8745
--                ->  Hash  (cost=224.00..224.00 rows=10000 width=14) (actual time=7.104..7.104 rows=10000 loops=1)
--                      Buckets: 16384  Batches: 1  Memory Usage: 586kB
--                      ->  Seq Scan on films f  (cost=0.00..224.00 rows=10000 width=14) (actual time=0.010..3.241 rows=10000 loops=1)
--          ->  Hash  (cost=14.60..14.60 rows=460 width=146) (actual time=0.020..0.021 rows=10 loops=1)
--                Buckets: 1024  Batches: 1  Memory Usage: 9kB
--                ->  Seq Scan on "filmAttributes" fa  (cost=0.00..14.60 rows=460 width=146) (actual time=0.006..0.012 rows=10 loops=1)
--    ->  Hash  (cost=14.00..14.00 rows=400 width=142) (actual time=0.024..0.024 rows=5 loops=1)
--          Buckets: 1024  Batches: 1  Memory Usage: 9kB
--          ->  Seq Scan on "filmAttributeTypes" fat  (cost=0.00..14.00 rows=400 width=142) (actual time=0.012..0.016 rows=5 loops=1)
--  Planning time: 0.897 ms
--  Execution time: 10.317 ms

-- 1M
-- QUERY PLAN
-- ----------------------------------------------------------------------------------------------------------------------
-- Hash Join  (cost=41802.45..63933.53 rows=125067 width=293) (actual time=517.197..886.191 rows=124483 loops=1)
--    Hash Cond: (fa.type_id = fat.id)
--    ->  Hash Join  (cost=41783.45..63582.75 rows=125067 width=159) (actual time=517.165..837.775 rows=124483 loops=1)
--          Hash Cond: (fav.attribute_id = fa.id)
--          ->  Hash Join  (cost=41763.10..63231.07 rows=125067 width=21) (actual time=517.138..787.851 rows=124483 loops=1)
--                Hash Cond: (fav.film_id = f.id)
--                ->  Bitmap Heap Scan on "filmAttributeValues" fav  (cost=2034.10..17068.77 rows=125067 width=9) (actual time=11.684..64.461 rows=124483 loops=1)
--                      Recheck Cond: val_bool
--                      Heap Blocks: exact=13783
--                      ->  Bitmap Index Scan on fav_booltrue_ind  (cost=0.00..2002.83 rows=125067 width=0) (actual time=9.021..9.022 rows=124483 loops=1)
--                ->  Hash  (cost=22346.00..22346.00 rows=1000000 width=16) (actual time=505.206..505.206 rows=1000000 loops=1)
--                      Buckets: 131072  Batches: 16  Memory Usage: 4015kB
--                      ->  Seq Scan on films f  (cost=0.00..22346.00 rows=1000000 width=16) (actual time=0.008..228.340 rows=1000000 loops=1)
--          ->  Hash  (cost=14.60..14.60 rows=460 width=146) (actual time=0.020..0.020 rows=10 loops=1)
--                Buckets: 1024  Batches: 1  Memory Usage: 9kB
--                ->  Seq Scan on "filmAttributes" fa  (cost=0.00..14.60 rows=460 width=146) (actual time=0.006..0.011 rows=10 loops=1)
--    ->  Hash  (cost=14.00..14.00 rows=400 width=142) (actual time=0.021..0.021 rows=5 loops=1)
--          Buckets: 1024  Batches: 1  Memory Usage: 9kB
--          ->  Seq Scan on "filmAttributeTypes" fat  (cost=0.00..14.00 rows=400 width=142) (actual time=0.009..0.013 rows=5 loops=1)
--  Planning time: 1.372 ms
--  Execution time: 894.305 ms


----- CONCLUSION 5 -----
-- в данном случаес индекс fav_booltrue_ind, на мой взгляд, дает прирост на процентов 20 (в случае 1M), а в случае с 10 тысячами
-- записей немного даже захломляет систему (не используется в запросе)



---------- 6 analysis:
-- select
--     f.id,
--     f.title,
--     fav.val_bigint,
--     fav.val_bool
-- from films f
--          join "filmAttributeValues" fav on f.id = fav.film_id
-- where fav.val_bigint > 100 or fav.val_bool = true;
--
drop index fav_bigint_ind;
drop index fav_bool_ind;
explain analyse select
                              f.id,
                              f.title,
                              fav.val_bigint,
                              fav.val_bool
                from films f
                         join "filmAttributeValues" fav on f.id = fav.film_id
                where fav.val_bigint > 100 or fav.val_bool = true;
-- 10k
-- QUERY PLAN
-- ----------------------------------------------------------------------------------------------------------------------------------
--  Hash Join  (cost=349.00..620.82 rows=3359 width=23) (actual time=4.456..8.419 rows=3661 loops=1)
--    Hash Cond: (fav.film_id = f.id)
--    ->  Seq Scan on "filmAttributeValues" fav  (cost=0.00..263.00 rows=3359 width=13) (actual time=0.008..2.333 rows=3661 loops=1)
--          Filter: ((val_bigint > 100) OR val_bool)
--          Rows Removed by Filter: 6339
--    ->  Hash  (cost=224.00..224.00 rows=10000 width=14) (actual time=4.434..4.434 rows=10000 loops=1)
--          Buckets: 16384  Batches: 1  Memory Usage: 586kB
--          ->  Seq Scan on films f  (cost=0.00..224.00 rows=10000 width=14) (actual time=0.004..2.024 rows=10000 loops=1)
--  Planning time: 0.186 ms
--  Execution time: 8.678 ms

-- 1M
-- QUERY PLAN
-- ----------------------------------------------------------------------------------------------------------------------
--  Hash Join  (cost=39729.00..75128.35 rows=341467 width=25) (actual time=524.512..1180.262 rows=372751 loops=1)
--    Hash Cond: (fav.film_id = f.id)
--    ->  Seq Scan on "filmAttributeValues" fav  (cost=0.00..26284.00 rows=341467 width=13) (actual time=0.019..257.238 rows=372751 loops=1)
--          Filter: ((val_bigint > 100) OR val_bool)
--          Rows Removed by Filter: 627249
--    ->  Hash  (cost=22346.00..22346.00 rows=1000000 width=16) (actual time=524.241..524.241 rows=1000000 loops=1)
--          Buckets: 131072  Batches: 16  Memory Usage: 4015kB
--          ->  Seq Scan on films f  (cost=0.00..22346.00 rows=1000000 width=16) (actual time=0.010..236.968 rows=1000000 loops=1)
--  Planning time: 0.636 ms
--  Execution time: 1204.368 ms





create index fav_bigint_ind on "filmAttributeValues" using btree ("val_bigint");
create index fav_bool_ind on "filmAttributeValues" using btree ("val_bool");
explain analyse select
                           f.id,
                           f.title,
                           fav.val_bigint,
                           fav.val_bool
                from films f
                         join "filmAttributeValues" fav on f.id = fav.film_id
                where fav.val_bigint > 100 or fav.val_bool = true;
-- 10k
-- QUERY PLAN
-- ----------------------------------------------------------------------------------------------------------------------------------
--  Hash Join  (cost=349.00..620.82 rows=3359 width=23) (actual time=5.952..9.987 rows=3661 loops=1)
--    Hash Cond: (fav.film_id = f.id)
--    ->  Seq Scan on "filmAttributeValues" fav  (cost=0.00..263.00 rows=3359 width=13) (actual time=0.018..2.317 rows=3661 loops=1)
--          Filter: ((val_bigint > 100) OR val_bool)
--          Rows Removed by Filter: 6339
--    ->  Hash  (cost=224.00..224.00 rows=10000 width=14) (actual time=5.899..5.899 rows=10000 loops=1)
--          Buckets: 16384  Batches: 1  Memory Usage: 586kB
--          ->  Seq Scan on films f  (cost=0.00..224.00 rows=10000 width=14) (actual time=0.009..2.652 rows=10000 loops=1)
--  Planning time: 0.786 ms
--  Execution time: 10.283 ms

-- 1M
-- QUERY PLAN
-- ----------------------------------------------------------------------------------------------------------------------
-- Hash Join  (cost=44764.89..70951.43 rows=341467 width=25) (actual time=533.932..1089.222 rows=372751 loops=1)
--    Hash Cond: (fav.film_id = f.id)
--    ->  Bitmap Heap Scan on "filmAttributeValues" fav  (cost=5035.89..22107.08 rows=341467 width=13) (actual time=33.530..195.296 rows=372751 loops=1)
--          Recheck Cond: ((val_bigint > 100) OR val_bool)
--          Filter: ((val_bigint > 100) OR val_bool)
--          Heap Blocks: exact=13784
--          ->  BitmapOr  (cost=5035.89..5035.89 rows=262975 width=0) (actual time=30.880..30.881 rows=0 loops=1)
--                ->  Bitmap Index Scan on fav_bigint_ind  (cost=0.00..4571.42 rows=247333 width=0) (actual time=23.593..23.594 rows=248268 loops=1)
--                      Index Cond: (val_bigint > 100)
--                ->  Bitmap Index Scan on fav_booltrue_ind  (cost=0.00..293.73 rows=15642 width=0) (actual time=7.285..7.285 rows=124483 loops=1)
--                      Index Cond: (val_bool = true)
--    ->  Hash  (cost=22346.00..22346.00 rows=1000000 width=16) (actual time=500.235..500.236 rows=1000000 loops=1)
--          Buckets: 131072  Batches: 16  Memory Usage: 4015kB
--          ->  Seq Scan on films f  (cost=0.00..22346.00 rows=1000000 width=16) (actual time=0.009..223.356 rows=1000000 loops=1)
--  Planning time: 0.363 ms
--  Execution time: 1113.272 ms


----- CONCLUSION 6 -----
-- добавление индекса fav_bigint_ind => используется планировщиком, второй индекс fav_bool_ind не используется,
-- но в случае с 10 тысячами записей Execution time выросло.
-- п.с. в случае опыта с миллионом заюзался индекс fav_booltrue_ind (с прошлого анализа, забыл его снести)



-- p.s. https://docs.google.com/spreadsheets/d/1yZ_AGJSCR6FtiOMw0ieE_utpYZJF38Bh216RrZTrhbU/edit?usp=sharing
----- * the same report in .xlsx, but only with explain (without analyse)
