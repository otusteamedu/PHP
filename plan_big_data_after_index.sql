

EXPLAIN ANALYSE SELECT COUNT(*) FROM seance WHERE film_id = 5;
QUERY PLAN                                                                  
----------------------------------------------------------------------------------------------------------------------------------------------
 Aggregate  (cost=114.26..114.27 rows=1 width=8) (actual time=0.399..0.399 rows=1 loops=1)
   ->  Index Only Scan using seance_film_id_idx on seance  (cost=0.29..111.33 rows=1173 width=0) (actual time=0.020..0.343 rows=1173 loops=1)
         Index Cond: (film_id = 5)
         Heap Fetches: 1173
 Planning Time: 0.068 ms
 Execution Time: 0.431 ms
(6 rows)


EXPLAIN ANALYSE SELECT COUNT(*) FROM ticket WHERE length(hash) > 100;
QUERY PLAN                                                                          
--------------------------------------------------------------------------------------------------------------------------------------------------------------
 Finalize Aggregate  (cost=22347.46..22347.47 rows=1 width=8) (actual time=8.688..8.688 rows=1 loops=1)
   ->  Gather  (cost=22347.24..22347.45 rows=2 width=8) (actual time=0.370..10.211 rows=3 loops=1)
         Workers Planned: 2
         Workers Launched: 2
         ->  Partial Aggregate  (cost=21347.24..21347.25 rows=1 width=8) (actual time=0.022..0.022 rows=1 loops=3)
               ->  Parallel Index Scan using ticket_length_idx on ticket  (cost=0.43..20950.54 rows=158682 width=0) (actual time=0.019..0.019 rows=0 loops=3)
                     Index Cond: (length(hash) > 100)
 Planning Time: 0.207 ms
 Execution Time: 10.287 ms
(9 rows)


EXPLAIN ANALYSE SELECT MAX(price) FROM seance;
QUERY PLAN                                                                         
-----------------------------------------------------------------------------------------------------------------------------------------------------------
 Result  (cost=0.31..0.32 rows=1 width=32) (actual time=0.049..0.049 rows=1 loops=1)
   InitPlan 1 (returns $0)
     ->  Limit  (cost=0.29..0.31 rows=1 width=5) (actual time=0.045..0.045 rows=1 loops=1)
           ->  Index Only Scan Backward using seance_price_idx on seance  (cost=0.29..326.25 rows=11712 width=5) (actual time=0.044..0.044 rows=1 loops=1)
                 Index Cond: (price IS NOT NULL)
                 Heap Fetches: 1
 Planning Time: 0.389 ms
 Execution Time: 0.076 ms
(8 rows)


QUERY PLAN                                                                                
--------------------------------------------------------------------------------------------------------------------------------------------------------------------------
 GroupAggregate  (cost=1.72..9640011.71 rows=160 width=36) (actual time=799.948..938.630 rows=1 loops=1)
   Group Key: f.film_id
   Filter: (SubPlan 1)
   Rows Removed by Filter: 9
   ->  Nested Loop Left Join  (cost=0.86..54139.99 rows=1142514 width=9) (actual time=0.038..350.394 rows=1142522 loops=1)
         ->  Merge Left Join  (cost=0.43..461.11 rows=11712 width=13) (actual time=0.028..5.112 rows=11712 loops=1)
               Merge Cond: (f.film_id = s.film_id)
               ->  Index Only Scan using film_pkey on film f  (cost=0.15..16.95 rows=320 width=4) (actual time=0.005..0.026 rows=10 loops=1)
                     Heap Fetches: 10
               ->  Index Scan using seance_film_id_idx on seance s  (cost=0.29..296.97 rows=11712 width=13) (actual time=0.019..3.228 rows=11712 loops=1)
         ->  Index Only Scan using ticket_seance_id_idx on ticket t  (cost=0.43..3.58 rows=100 width=4) (actual time=0.005..0.022 rows=98 loops=11712)
               Index Cond: (seance_id = s.seance_id)
               Heap Fetches: 1142514
   SubPlan 1
     ->  Materialize  (cost=0.86..59858.16 rows=320 width=36) (actual time=4.487..47.098 rows=4 loops=10)
           ->  GroupAggregate  (cost=0.86..59856.56 rows=320 width=36) (actual time=44.862..470.960 rows=10 loops=1)
                 Group Key: f_1.film_id
                 ->  Nested Loop Left Join  (cost=0.86..54139.99 rows=1142514 width=9) (actual time=0.021..352.126 rows=1142522 loops=1)
                       ->  Merge Left Join  (cost=0.43..461.11 rows=11712 width=13) (actual time=0.014..5.359 rows=11712 loops=1)
                             Merge Cond: (f_1.film_id = s_1.film_id)
                             ->  Index Only Scan using film_pkey on film f_1  (cost=0.15..16.95 rows=320 width=4) (actual time=0.004..0.024 rows=10 loops=1)
                                   Heap Fetches: 10
                             ->  Index Scan using seance_film_id_idx on seance s_1  (cost=0.29..296.97 rows=11712 width=13) (actual time=0.007..3.457 rows=11712 loops=1)
                       ->  Index Only Scan using ticket_seance_id_idx on ticket t_1  (cost=0.43..3.58 rows=100 width=4) (actual time=0.005..0.022 rows=98 loops=11712)
                             Index Cond: (seance_id = s_1.seance_id)
                             Heap Fetches: 1142514
 Planning Time: 0.530 ms
 Execution Time: 938.739 ms
(28 rows)


EXPLAIN ANALYSE SELECT SUM(price) FROM ticket join seance USING (seance_id);
QUERY PLAN                                                                   
------------------------------------------------------------------------------------------------------------------------------------------------
 Finalize Aggregate  (cost=24013.42..24013.43 rows=1 width=32) (actual time=208.179..208.180 rows=1 loops=1)
   ->  Gather  (cost=24013.20..24013.41 rows=2 width=32) (actual time=208.167..214.279 rows=3 loops=1)
         Workers Planned: 2
         Workers Launched: 2
         ->  Partial Aggregate  (cost=23013.20..23013.21 rows=1 width=32) (actual time=200.132..200.132 rows=1 loops=3)
               ->  Hash Join  (cost=350.52..21823.08 rows=476048 width=5) (actual time=5.454..152.734 rows=380838 loops=3)
                     Hash Cond: (ticket.seance_id = seance.seance_id)
                     ->  Parallel Seq Scan on ticket  (cost=0.00..20222.47 rows=476048 width=4) (actual time=0.011..56.399 rows=380838 loops=3)
                     ->  Hash  (cost=204.12..204.12 rows=11712 width=9) (actual time=5.340..5.340 rows=11712 loops=3)
                           Buckets: 16384  Batches: 1  Memory Usage: 632kB
                           ->  Seq Scan on seance  (cost=0.00..204.12 rows=11712 width=9) (actual time=0.015..1.361 rows=11712 loops=3)
 Planning Time: 0.244 ms
 Execution Time: 214.343 ms
(13 rows)



