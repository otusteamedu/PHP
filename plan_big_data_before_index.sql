/* На больших данных за год */

EXPLAIN ANALYSE SELECT COUNT(*) FROM seance WHERE film_id = 5;
QUERY PLAN                                                  
--------------------------------------------------------------------------------------------------------------
 Aggregate  (cost=236.33..236.34 rows=1 width=8) (actual time=0.850..0.851 rows=1 loops=1)
   ->  Seq Scan on seance  (cost=0.00..233.40 rows=1173 width=0) (actual time=0.015..0.793 rows=1173 loops=1)
         Filter: (film_id = 5)
         Rows Removed by Filter: 10539
 Planning Time: 0.054 ms
 Execution Time: 0.886 ms
(6 rows)


EXPLAIN ANALYSE SELECT COUNT(*) FROM ticket WHERE length(hash) > 100;
QUERY PLAN                                                               
----------------------------------------------------------------------------------------------------------------------------------------
 Finalize Aggregate  (cost=23999.63..23999.64 rows=1 width=8) (actual time=134.603..134.603 rows=1 loops=1)
   ->  Gather  (cost=23999.42..23999.63 rows=2 width=8) (actual time=130.614..134.683 rows=3 loops=1)
         Workers Planned: 2
         Workers Launched: 2
         ->  Partial Aggregate  (cost=22999.42..22999.43 rows=1 width=8) (actual time=124.756..124.756 rows=1 loops=3)
               ->  Parallel Seq Scan on ticket  (cost=0.00..22602.71 rows=158682 width=0) (actual time=124.752..124.752 rows=0 loops=3)
                     Filter: (length(hash) > 100)
                     Rows Removed by Filter: 380838
 Planning Time: 0.038 ms
 Execution Time: 134.728 ms
(10 rows)



EXPLAIN ANALYSE SELECT MAX(price) FROM seance;
QUERY PLAN                                                   
----------------------------------------------------------------------------------------------------------------
 Aggregate  (cost=233.40..233.41 rows=1 width=32) (actual time=2.004..2.004 rows=1 loops=1)
   ->  Seq Scan on seance  (cost=0.00..204.12 rows=11712 width=5) (actual time=0.008..0.839 rows=11712 loops=1)
 Planning Time: 0.077 ms
 Execution Time: 2.026 ms
(4 rows)



-- бестселлер
QUERY PLAN                                                                      
------------------------------------------------------------------------------------------------------------------------------------------------------
 HashAggregate  (cost=80869.15..81898.75 rows=160 width=36) (actual time=1315.242..1315.246 rows=1 loops=1)
   Group Key: f.film_id
   Filter: (SubPlan 1)
   Rows Removed by Filter: 9
   ->  Hash Right Join  (cost=367.72..33293.86 rows=1142514 width=9) (actual time=2.493..469.927 rows=1142522 loops=1)
         Hash Cond: (s.film_id = f.film_id)
         ->  Hash Right Join  (cost=350.52..30237.85 rows=1142514 width=9) (actual time=2.471..302.541 rows=1142522 loops=1)
               Hash Cond: (t.seance_id = s.seance_id)
               ->  Seq Scan on ticket t  (cost=0.00..26887.14 rows=1142514 width=4) (actual time=0.009..101.704 rows=1142514 loops=1)
               ->  Hash  (cost=204.12..204.12 rows=11712 width=13) (actual time=2.439..2.439 rows=11712 loops=1)
                     Buckets: 16384  Batches: 1  Memory Usage: 677kB
                     ->  Seq Scan on seance s  (cost=0.00..204.12 rows=11712 width=13) (actual time=0.005..1.223 rows=11712 loops=1)
         ->  Hash  (cost=13.20..13.20 rows=320 width=4) (actual time=0.008..0.008 rows=10 loops=1)
               Buckets: 1024  Batches: 1  Memory Usage: 9kB
               ->  Seq Scan on film f  (cost=0.00..13.20 rows=320 width=4) (actual time=0.004..0.006 rows=10 loops=1)
   SubPlan 1
     ->  Materialize  (cost=39006.43..39012.03 rows=320 width=36) (actual time=66.424..66.425 rows=3 loops=10)
           ->  HashAggregate  (cost=39006.43..39010.43 rows=320 width=36) (actual time=664.238..664.241 rows=10 loops=1)
                 Group Key: f_1.film_id
                 ->  Hash Right Join  (cost=367.72..33293.86 rows=1142514 width=9) (actual time=2.548..477.110 rows=1142522 loops=1)
                       Hash Cond: (s_1.film_id = f_1.film_id)
                       ->  Hash Right Join  (cost=350.52..30237.85 rows=1142514 width=9) (actual time=2.523..305.627 rows=1142522 loops=1)
                             Hash Cond: (t_1.seance_id = s_1.seance_id)
                             ->  Seq Scan on ticket t_1  (cost=0.00..26887.14 rows=1142514 width=4) (actual time=0.009..103.427 rows=1142514 loops=1)
                             ->  Hash  (cost=204.12..204.12 rows=11712 width=13) (actual time=2.492..2.492 rows=11712 loops=1)
                                   Buckets: 16384  Batches: 1  Memory Usage: 677kB
                                   ->  Seq Scan on seance s_1  (cost=0.00..204.12 rows=11712 width=13) (actual time=0.007..1.250 rows=11712 loops=1)
                       ->  Hash  (cost=13.20..13.20 rows=320 width=4) (actual time=0.014..0.014 rows=10 loops=1)
                             Buckets: 1024  Batches: 1  Memory Usage: 9kB
                             ->  Seq Scan on film f_1  (cost=0.00..13.20 rows=320 width=4) (actual time=0.010..0.011 rows=10 loops=1)
 Planning Time: 0.317 ms
 Execution Time: 1315.354 ms
(32 rows)



EXPLAIN ANALYSE SELECT SUM(price) FROM ticket join seance USING (seance_id);
QUERY PLAN                                                                   
------------------------------------------------------------------------------------------------------------------------------------------------
 Finalize Aggregate  (cost=24013.42..24013.43 rows=1 width=32) (actual time=210.494..210.495 rows=1 loops=1)
   ->  Gather  (cost=24013.20..24013.41 rows=2 width=32) (actual time=209.811..214.681 rows=3 loops=1)
         Workers Planned: 2
         Workers Launched: 2
         ->  Partial Aggregate  (cost=23013.20..23013.21 rows=1 width=32) (actual time=205.116..205.116 rows=1 loops=3)
               ->  Hash Join  (cost=350.52..21823.08 rows=476048 width=5) (actual time=5.437..156.182 rows=380838 loops=3)
                     Hash Cond: (ticket.seance_id = seance.seance_id)
                     ->  Parallel Seq Scan on ticket  (cost=0.00..20222.47 rows=476048 width=4) (actual time=0.009..68.151 rows=380838 loops=3)
                     ->  Hash  (cost=204.12..204.12 rows=11712 width=9) (actual time=5.325..5.326 rows=11712 loops=3)
                           Buckets: 16384  Batches: 1  Memory Usage: 632kB
                           ->  Seq Scan on seance  (cost=0.00..204.12 rows=11712 width=9) (actual time=0.012..1.761 rows=11712 loops=3)
 Planning Time: 0.139 ms
 Execution Time: 214.746 ms
(13 rows)


-- самый ночной фильм, который заканчивается или начинается между 20:00 и 5:00
QUERY PLAN                                                                                                                                                                                                                                              
-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
 HashAggregate  (cost=625.16..1525.16 rows=160 width=230) (actual time=17.894..17.896 rows=1 loops=1)
   Group Key: f.film_id
   Filter: (SubPlan 1)
   Rows Removed by Filter: 9
   ->  Hash Join  (cost=17.20..253.84 rows=9399 width=222) (actual time=0.023..8.193 rows=5856 loops=1)
         Hash Cond: (s.film_id = f.film_id)
         Join Filter: (((s.time_start)::time without time zone < '05:00:00'::time without time zone) OR ((s.time_start)::time without time zone > '20:00:00'::time without time zone) OR (((s.time_start)::time without time zone + (((f.duration)::text || ' minutes'::text))::interval) < '05:00:00'::time without time zone) OR (((s.time_start)::time without time zone + (((f.duration)::text || ' minutes'::text))::interval) > '20:00:00'::time without time zone))
         Rows Removed by Join Filter: 5856
         ->  Seq Scan on seance s  (cost=0.00..204.12 rows=11712 width=12) (actual time=0.007..0.843 rows=11712 loops=1)
         ->  Hash  (cost=13.20..13.20 rows=320 width=226) (actual time=0.009..0.009 rows=10 loops=1)
               Buckets: 1024  Batches: 1  Memory Usage: 9kB
               ->  Seq Scan on film f  (cost=0.00..13.20 rows=320 width=226) (actual time=0.004..0.006 rows=10 loops=1)
   SubPlan 1
     ->  Materialize  (cost=300.83..305.63 rows=320 width=12) (actual time=0.896..0.896 rows=3 loops=10)
           ->  HashAggregate  (cost=300.83..304.03 rows=320 width=12) (actual time=8.957..8.959 rows=10 loops=1)
                 Group Key: f_1.film_id
                 ->  Hash Join  (cost=17.20..253.84 rows=9399 width=4) (actual time=0.016..8.224 rows=5856 loops=1)
                       Hash Cond: (s_1.film_id = f_1.film_id)
                       Join Filter: (((s_1.time_start)::time without time zone < '05:00:00'::time without time zone) OR ((s_1.time_start)::time without time zone > '20:00:00'::time without time zone) OR (((s_1.time_start)::time without time zone + (((f_1.duration)::text || ' minutes'::text))::interval) < '05:00:00'::time without time zone) OR (((s_1.time_start)::time without time zone + (((f_1.duration)::text || ' minutes'::text))::interval) > '20:00:00'::time without time zone))
                       Rows Removed by Join Filter: 5856
                       ->  Seq Scan on seance s_1  (cost=0.00..204.12 rows=11712 width=12) (actual time=0.005..0.761 rows=11712 loops=1)
                       ->  Hash  (cost=13.20..13.20 rows=320 width=8) (actual time=0.006..0.006 rows=10 loops=1)
                             Buckets: 1024  Batches: 1  Memory Usage: 9kB
                             ->  Seq Scan on film f_1  (cost=0.00..13.20 rows=320 width=8) (actual time=0.002..0.004 rows=10 loops=1)
 Planning Time: 0.246 ms
 Execution Time: 17.978 ms
(26 rows)
