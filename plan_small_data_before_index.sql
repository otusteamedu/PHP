/* На малых данных (3 дня) */

EXPLAIN ANALYSE SELECT COUNT(*) FROM seance WHERE film_id = 5;
QUERY PLAN                                              
------------------------------------------------------------------------------------------------------
 Aggregate  (cost=2.22..2.23 rows=1 width=8) (actual time=0.016..0.016 rows=1 loops=1)
   ->  Seq Scan on seance  (cost=0.00..2.20 rows=9 width=0) (actual time=0.009..0.013 rows=9 loops=1)
         Filter: (film_id = 5)
         Rows Removed by Filter: 87
 Planning Time: 0.072 ms
 Execution Time: 0.044 ms
(6 rows)


EXPLAIN ANALYSE SELECT COUNT(*) FROM ticket WHERE length(hash) > 100;
QUERY PLAN                                                 
-----------------------------------------------------------------------------------------------------------
 Aggregate  (cost=212.80..212.81 rows=1 width=8) (actual time=0.948..0.948 rows=1 loops=1)
   ->  Seq Scan on ticket  (cost=0.00..204.66 rows=3259 width=0) (actual time=0.944..0.944 rows=0 loops=1)
         Filter: (length(hash) > 100)
         Rows Removed by Filter: 9777
 Planning Time: 0.055 ms
 Execution Time: 0.989 ms
(6 rows)


EXPLAIN ANALYSE SELECT MAX(price) FROM seance;
QUERY PLAN                                               
--------------------------------------------------------------------------------------------------------
 Aggregate  (cost=2.20..2.21 rows=1 width=32) (actual time=0.027..0.027 rows=1 loops=1)
   ->  Seq Scan on seance  (cost=0.00..1.96 rows=96 width=5) (actual time=0.006..0.011 rows=96 loops=1)
 Planning Time: 0.105 ms
 Execution Time: 0.055 ms
(4 rows)


-- бестселлер
QUERY PLAN                                                                  
---------------------------------------------------------------------------------------------------------------------------------------------
 HashAggregate  (cost=865.25..1894.85 rows=160 width=36) (actual time=10.939..10.942 rows=1 loops=1)
   Group Key: f.film_id
   Filter: (SubPlan 1)
   Rows Removed by Filter: 9
   ->  Hash Right Join  (cost=20.36..228.94 rows=32590 width=9) (actual time=0.080..3.923 rows=9777 loops=1)
         Hash Cond: (s.film_id = f.film_id)
         ->  Hash Right Join  (cost=3.16..185.73 rows=9777 width=9) (actual time=0.057..2.478 rows=9777 loops=1)
               Hash Cond: (t.seance_id = s.seance_id)
               ->  Seq Scan on ticket t  (cost=0.00..155.77 rows=9777 width=4) (actual time=0.006..0.780 rows=9777 loops=1)
               ->  Hash  (cost=1.96..1.96 rows=96 width=13) (actual time=0.043..0.043 rows=96 loops=1)
                     Buckets: 1024  Batches: 1  Memory Usage: 13kB
                     ->  Seq Scan on seance s  (cost=0.00..1.96 rows=96 width=13) (actual time=0.004..0.012 rows=96 loops=1)
         ->  Hash  (cost=13.20..13.20 rows=320 width=4) (actual time=0.019..0.019 rows=10 loops=1)
               Buckets: 1024  Batches: 1  Memory Usage: 9kB
               ->  Seq Scan on film f  (cost=0.00..13.20 rows=320 width=4) (actual time=0.005..0.006 rows=10 loops=1)
   SubPlan 1
     ->  Materialize  (cost=391.89..397.49 rows=320 width=36) (actual time=0.540..0.540 rows=3 loops=10)
           ->  HashAggregate  (cost=391.89..395.89 rows=320 width=36) (actual time=5.392..5.395 rows=10 loops=1)
                 Group Key: f_1.film_id
                 ->  Hash Right Join  (cost=20.36..228.94 rows=32590 width=9) (actual time=0.083..3.839 rows=9777 loops=1)
                       Hash Cond: (s_1.film_id = f_1.film_id)
                       ->  Hash Right Join  (cost=3.16..185.73 rows=9777 width=9) (actual time=0.047..2.378 rows=9777 loops=1)
                             Hash Cond: (t_1.seance_id = s_1.seance_id)
                             ->  Seq Scan on ticket t_1  (cost=0.00..155.77 rows=9777 width=4) (actual time=0.005..0.671 rows=9777 loops=1)
                             ->  Hash  (cost=1.96..1.96 rows=96 width=13) (actual time=0.029..0.029 rows=96 loops=1)
                                   Buckets: 1024  Batches: 1  Memory Usage: 13kB
                                   ->  Seq Scan on seance s_1  (cost=0.00..1.96 rows=96 width=13) (actual time=0.005..0.013 rows=96 loops=1)
                       ->  Hash  (cost=13.20..13.20 rows=320 width=4) (actual time=0.011..0.011 rows=10 loops=1)
                             Buckets: 1024  Batches: 1  Memory Usage: 9kB
                             ->  Seq Scan on film f_1  (cost=0.00..13.20 rows=320 width=4) (actual time=0.004..0.005 rows=10 loops=1)
 Planning Time: 0.383 ms
 Execution Time: 11.025 ms
(32 rows)


EXPLAIN ANALYSE SELECT SUM(price) FROM ticket join seance USING (seance_id);
QUERY PLAN                                                     
--------------------------------------------------------------------------------------------------------------------
 Aggregate  (cost=210.17..210.18 rows=1 width=32) (actual time=3.152..3.152 rows=1 loops=1)
   ->  Hash Join  (cost=3.16..185.73 rows=9777 width=5) (actual time=0.038..2.328 rows=9777 loops=1)
         Hash Cond: (ticket.seance_id = seance.seance_id)
         ->  Seq Scan on ticket  (cost=0.00..155.77 rows=9777 width=4) (actual time=0.008..0.728 rows=9777 loops=1)
         ->  Hash  (cost=1.96..1.96 rows=96 width=9) (actual time=0.025..0.025 rows=96 loops=1)
               Buckets: 1024  Batches: 1  Memory Usage: 13kB
               ->  Seq Scan on seance  (cost=0.00..1.96 rows=96 width=9) (actual time=0.004..0.014 rows=96 loops=1)
 Planning Time: 0.279 ms
 Execution Time: 3.187 ms
(9 rows)


-- самый ночной фильм, который заканчивается или начинается между 20:00 и 5:00
QUERY PLAN                                                                                                                                                                                                                                              
-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
 GroupAggregate  (cost=10.54..1020.46 rows=38 width=230) (actual time=0.191..0.210 rows=1 loops=1)
   Group Key: f.film_id
   Filter: (SubPlan 1)
   Rows Removed by Filter: 9
   ->  Merge Join  (cost=5.27..29.11 rows=77 width=222) (actual time=0.045..0.106 rows=48 loops=1)
         Merge Cond: (f.film_id = s.film_id)
         Join Filter: (((s.time_start)::time without time zone < '05:00:00'::time without time zone) OR ((s.time_start)::time without time zone > '20:00:00'::time without time zone) OR (((s.time_start)::time without time zone + (((f.duration)::text || ' minutes'::text))::interval) < '05:00:00'::time without time zone) OR (((s.time_start)::time without time zone + (((f.duration)::text || ' minutes'::text))::interval) > '20:00:00'::time without time zone))
         Rows Removed by Join Filter: 48
         ->  Index Scan using film_pkey on film f  (cost=0.15..16.95 rows=320 width=226) (actual time=0.006..0.008 rows=10 loops=1)
         ->  Sort  (cost=5.12..5.36 rows=96 width=12) (actual time=0.028..0.033 rows=96 loops=1)
               Sort Key: s.film_id
               Sort Method: quicksort  Memory: 29kB
               ->  Seq Scan on seance s  (cost=0.00..1.96 rows=96 width=12) (actual time=0.006..0.014 rows=96 loops=1)
   SubPlan 1
     ->  Materialize  (cost=5.27..30.65 rows=77 width=12) (actual time=0.004..0.009 rows=2 loops=10)
           ->  GroupAggregate  (cost=5.27..30.26 rows=77 width=12) (actual time=0.033..0.089 rows=10 loops=1)
                 Group Key: f_1.film_id
                 ->  Merge Join  (cost=5.27..29.11 rows=77 width=4) (actual time=0.024..0.083 rows=48 loops=1)
                       Merge Cond: (f_1.film_id = s_1.film_id)
                       Join Filter: (((s_1.time_start)::time without time zone < '05:00:00'::time without time zone) OR ((s_1.time_start)::time without time zone > '20:00:00'::time without time zone) OR (((s_1.time_start)::time without time zone + (((f_1.duration)::text || ' minutes'::text))::interval) < '05:00:00'::time without time zone) OR (((s_1.time_start)::time without time zone + (((f_1.duration)::text || ' minutes'::text))::interval) > '20:00:00'::time without time zone))
                       Rows Removed by Join Filter: 48
                       ->  Index Scan using film_pkey on film f_1  (cost=0.15..16.95 rows=320 width=8) (actual time=0.001..0.003 rows=10 loops=1)
                       ->  Sort  (cost=5.12..5.36 rows=96 width=12) (actual time=0.020..0.024 rows=96 loops=1)
                             Sort Key: s_1.film_id
                             Sort Method: quicksort  Memory: 29kB
                             ->  Seq Scan on seance s_1  (cost=0.00..1.96 rows=96 width=12) (actual time=0.002..0.009 rows=96 loops=1)
 Planning Time: 0.459 ms
 Execution Time: 0.312 ms
(28 rows)

