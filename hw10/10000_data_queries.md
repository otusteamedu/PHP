EXPLAIN ANALYSE SELECT cost from homework.tickets where cost = 3000;

```
Seq Scan on tickets  (cost=0.00..209.00 rows=6 width=4) (actual time=0.233..1.736 rows=6 loops=1)
    Filter: (cost = '3000'::numeric)
    Rows Removed by Filter: 9994
        Planning Time: 0.936 ms
        Execution Time: 1.750 ms 
```

EXPLAIN ANALYSE SELECT id from homework.tickets where client_id = 500;

```
Seq Scan on tickets  (cost=0.00..209.00 rows=2 width=8) (actual time=1.770..1.770 rows=0 loops=1)
  Filter: (client_id = 500)
  Rows Removed by Filter: 10000
Planning Time: 1.115 ms
Execution Time: 1.783 ms
```

EXPLAIN ANALYSE SELECT id from homework.sessions where movie_id = 500;
```
Seq Scan on sessions  (cost=0.00..525.00 rows=2 width=8) (actual time=2.187..3.063 rows=1 loops=1)
  Filter: (movie_id = 500)
  Rows Removed by Filter: 9999
Planning Time: 1.299 ms
Execution Time: 3.080 ms
```

EXPLAIN ANALYZE SELECT homework.movies.title from homework.sessions JOIN homework.movies ON homework.movies.id = homework.sessions.movie_id where homework.sessions.movie_id = 20
```
Nested Loop  (cost=0.29..533.32 rows=2 width=264) (actual time=3.554..3.554 rows=0 loops=1)
  ->  Index Scan using movies_pkey on movies  (cost=0.29..8.30 rows=1 width=272) (actual time=0.037..0.040 rows=1 loops=1)
        Index Cond: (id = 20)
  ->  Seq Scan on sessions  (cost=0.00..525.00 rows=2 width=8) (actual time=3.512..3.512 rows=0 loops=1)
        Filter: (movie_id = 20)
        Rows Removed by Filter: 10000
Planning Time: 2.461 ms
Execution Time: 3.583 ms
```

EXPLAIN ANALYZE SELECT tickets.id, sessions.title, client.first_name FROM  homework.tickets as tickets join homework.client as client on tickets.client_id = client.id
                                          join homework.sessions as sessions on tickets.session_id = sessions.id
                                           where client.id = 44
```
Nested Loop  (cost=0.57..233.93 rows=2 width=537) (actual time=0.561..1.176 rows=1 loops=1)
  ->  Nested Loop  (cost=0.29..217.32 rows=2 width=280) (actual time=0.543..1.158 rows=1 loops=1)
        ->  Index Scan using client_pkey on client  (cost=0.29..8.30 rows=1 width=272) (actual time=0.050..0.052 rows=1 loops=1)
              Index Cond: (id = 44)
        ->  Seq Scan on tickets  (cost=0.00..209.00 rows=2 width=24) (actual time=0.491..1.104 rows=1 loops=1)
              Filter: (client_id = 44)
              Rows Removed by Filter: 9999
  ->  Index Scan using sessions_pkey on sessions  (cost=0.29..8.30 rows=1 width=273) (actual time=0.016..0.017 rows=1 loops=1)
        Index Cond: (id = tickets.session_id)
Planning Time: 4.261 ms
Execution Time: 1.218 ms
```   

EXPLAIN ANALYZE SELECT tickets.id, sessions.title, halls.title FROM  homework.tickets as tickets 
                                          left join homework.sessions as sessions on tickets.session_id = sessions.id
                                          left join homework.halls as halls on sessions.hall_id = halls.id
                                          where halls.title = '7 зал'
            
 ```
Hash Join  (cost=1421.29..1642.80 rows=1 width=535) (actual time=11.794..12.719 rows=2 loops=1)
  Hash Cond: (tickets.session_id = sessions.id)
  ->  Seq Scan on tickets  (cost=0.00..184.00 rows=10000 width=16) (actual time=0.029..0.991 rows=10000 loops=1)
  ->  Hash  (cost=1421.27..1421.27 rows=1 width=535) (actual time=10.923..10.923 rows=1 loops=1)
        Buckets: 1024  Batches: 1  Memory Usage: 9kB
        ->  Hash Join  (cost=895.01..1421.27 rows=1 width=535) (actual time=7.972..10.896 rows=1 loops=1)
              Hash Cond: (sessions.hall_id = halls.id)
              ->  Seq Scan on sessions  (cost=0.00..500.00 rows=10000 width=281) (actual time=0.060..2.671 rows=10000 loops=1)
              ->  Hash  (cost=895.00..895.00 rows=1 width=270) (actual time=7.101..7.103 rows=1 loops=1)
                    Buckets: 1024  Batches: 1  Memory Usage: 9kB
                    ->  Seq Scan on halls  (cost=0.00..895.00 rows=1 width=270) (actual time=2.219..7.084 rows=1 loops=1)
                          Filter: (title = '7 зал'::bpchar)
                          Rows Removed by Filter: 9999
Planning Time: 4.228 ms
Execution Time: 12.768 ms
```                                  