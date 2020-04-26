EXPLAIN ANALYSE SELECT cost from homework.tickets where cost = 3000;

```
Gather  (cost=1000.00..136615.95 rows=1982 width=4) (actual time=1.097..9436.546 rows=1992 loops=1)
  Workers Planned: 2
  Workers Launched: 2
  ->  Parallel Seq Scan on tickets  (cost=0.00..135417.75 rows=826 width=4) (actual time=12.421..9376.286 rows=664 loops=3)
        Filter: (cost = '3000'::numeric)
        Rows Removed by Filter: 3332669
    Planning Time: 1.312 ms
    Execution Time: 9440.303 ms
```

EXPLAIN ANALYSE SELECT id from homework.tickets where client_id = 500;

```
Gather  (cost=1000.00..137389.75 rows=9720 width=8) (actual time=2.916..522.899 rows=10008 loops=1)
  Workers Planned: 2
  Workers Launched: 2
  ->  Parallel Seq Scan on tickets  (cost=0.00..135417.75 rows=4050 width=8) (actual time=1.897..460.807 rows=3336 loops=3)
        Filter: (client_id = 500)
        Rows Removed by Filter: 3329997
        Planning Time: 0.980 ms
        Execution Time: 523.452 ms
```

EXPLAIN ANALYSE SELECT id from homework.sessions where movie_id = 500;
```
Gather  (cost=1000.00..853558.05 rows=9667 width=8) (actual time=13.300..58724.030 rows=9934 loops=1)
  Workers Planned: 2
  Workers Launched: 2
  ->  Parallel Seq Scan on sessions  (cost=0.00..851591.35 rows=4028 width=8) (actual time=12412.505..58654.458 rows=3311 loops=3)
        Filter: (movie_id = 500)
        Rows Removed by Filter: 3330022
Planning Time: 6.042 ms
Execution Time: 58725.818 ms
```

EXPLAIN ANALYZE SELECT homework.movies.title from homework.sessions JOIN homework.movies ON homework.movies.id = homework.sessions.movie_id where homework.sessions.movie_id = 20
```
Nested Loop  (cost=1000.43..853663.18 rows=9667 width=264) (actual time=18682.712..37617.791 rows=9949 loops=1)
  ->  Index Scan using movies_pkey on movies  (cost=0.43..8.45 rows=1 width=272) (actual time=1.137..1.141 rows=1 loops=1)
        Index Cond: (id = 20)
  ->  Gather  (cost=1000.00..853558.05 rows=9667 width=8) (actual time=18681.572..37621.385 rows=9949 loops=1)
        Workers Planned: 2
        Workers Launched: 2
        ->  Parallel Seq Scan on sessions  (cost=0.00..851591.35 rows=4028 width=8) (actual time=18651.727..37561.742 rows=3316 loops=3)
              Filter: (movie_id = 20)
              Rows Removed by Filter: 3330017
Planning Time: 7.970 ms
Execution Time: 37626.497 ms
```

EXPLAIN ANALYZE SELECT tickets.id, sessions.title, client.first_name FROM  homework.tickets as tickets join homework.client as client on tickets.client_id = client.id
                                          join homework.sessions as sessions on tickets.session_id = sessions.id
                                           where client.id = 44
```
Nested Loop  (cost=138049.47..139282.92 rows=9720 width=537) (actual time=4577.452..4589.437 rows=10050 loops=1)
  ->  Index Scan using client_pkey on client  (cost=0.43..8.45 rows=1 width=272) (actual time=1.966..1.966 rows=1 loops=1)
        Index Cond: (id = 44)
  ->  Merge Join  (cost=138049.04..139177.27 rows=9720 width=281) (actual time=4575.480..4586.689 rows=10050 loops=1)
        Merge Cond: (sessions.id = tickets.session_id)
        ->  Index Scan using sessions_pkey on sessions  (cost=0.43..1059130.53 rows=9982340 width=273) (actual time=0.388..8.479 rows=5924 loops=1)
        ->  Sort  (cost=138033.54..138057.84 rows=9720 width=24) (actual time=4575.080..4576.396 rows=10050 loops=1)
              Sort Key: tickets.session_id
              Sort Method: quicksort  Memory: 1170kB
              ->  Gather  (cost=1000.00..137389.75 rows=9720 width=24) (actual time=3.887..4568.518 rows=10050 loops=1)
                    Workers Planned: 2
                    Workers Launched: 2
                    ->  Parallel Seq Scan on tickets  (cost=0.00..135417.75 rows=4050 width=24) (actual time=4.884..4512.487 rows=3350 loops=3)
                          Filter: (client_id = 44)
                          Rows Removed by Filter: 3329983
Planning Time: 24.311 ms
Execution Time: 4590.097 ms
```   

EXPLAIN ANALYZE SELECT tickets.id, sessions.title, halls.title FROM  homework.tickets as tickets 
                                          left join homework.sessions as sessions on tickets.session_id = sessions.id
                                          left join homework.halls as halls on sessions.hall_id = halls.id
                                          where halls.title = '7 зал'
            
 ```
Gather  (cost=1289810.71..1430436.94 rows=1 width=535) (actual time=100067.613..100100.695 rows=2 loops=1)
  Workers Planned: 2
  Workers Launched: 2
  ->  Parallel Hash Join  (cost=1288810.71..1429436.84 rows=1 width=535) (actual time=98390.902..100015.984 rows=1 loops=3)
        Hash Cond: (tickets.session_id = sessions.id)
        ->  Parallel Seq Scan on tickets  (cost=0.00..125001.00 rows=4166700 width=16) (actual time=0.463..4440.962 rows=3333333 loops=3)
        ->  Parallel Hash  (cost=1288810.70..1288810.70 rows=1 width=535) (actual time=95136.931..95136.931 rows=3310 loops=3)
              Buckets: 16384 (originally 1024)  Batches: 1 (originally 1)  Memory Usage: 5944kB
              ->  Parallel Hash Join  (cost=436699.43..1288810.70 rows=1 width=535) (actual time=69117.089..94908.384 rows=3310 loops=3)
                    Hash Cond: (sessions.hall_id = halls.id)
                    ->  Parallel Seq Scan on sessions  (cost=0.00..841193.08 rows=4159308 width=281) (actual time=0.013..38824.160 rows=3333333 loops=3)
                    ->  Parallel Hash  (cost=436699.42..436699.42 rows=1 width=270) (actual time=55594.492..55594.492 rows=0 loops=3)
                          Buckets: 1024  Batches: 1  Memory Usage: 40kB
                          ->  Parallel Seq Scan on halls  (cost=0.00..436699.42 rows=1 width=270) (actual time=37057.381..55594.416 rows=0 loops=3)
                                Filter: (title = '7 зал'::bpchar)
                                Rows Removed by Filter: 3333333
Planning Time: 11.162 ms
Execution Time: 100100.813 ms
```                                  