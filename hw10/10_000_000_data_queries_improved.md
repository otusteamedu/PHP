EXPLAIN ANALYSE SELECT cost from homework.tickets where cost = 3000;

CREATE INDEX index_cost ON homework.tickets (cost);

/* поставил index для поля cost, чтобы увеличить скорость запроса */
```
Bitmap Heap Scan on tickets  (cost=39.80..6999.49 rows=1982 width=4) (actual time=1.414..36.745 rows=1992 loops=1)
  Recheck Cond: (cost = '3000'::numeric)
      Heap Blocks: exact=1966
      ->  Bitmap Index Scan on index_cost  (cost=0.00..39.30 rows=1982 width=0) (actual time=1.151..1.151 rows=1992 loops=1)
            Index Cond: (cost = '3000'::numeric)
    Planning Time: 3.033 ms
    Execution Time: 37.010 ms
```

EXPLAIN ANALYSE SELECT id from homework.tickets where client_id = 500;

CREATE INDEX index_client_id ON homework.tickets (client_id);

/* поставил index для поля client_id, чтобы увеличить скорость запроса */
```
Bitmap Heap Scan on tickets  (cost=183.76..27897.21 rows=9720 width=8) (actual time=4.901..135.783 rows=10008 loops=1)
      Recheck Cond: (client_id = 500)
      Heap Blocks: exact=9403
      ->  Bitmap Index Scan on index_client_id  (cost=0.00..181.33 rows=9720 width=0) (actual time=2.845..2.845 rows=10008 loops=1)
            Index Cond: (client_id = 500)
    Planning Time: 2.469 ms
    Execution Time: 136.303 ms
```

EXPLAIN ANALYSE SELECT id from homework.sessions where movie_id = 500;

CREATE INDEX index_movie_id ON homework.sessions (movie_id);

/* поставил index для поля movie_id, чтобы увеличить скорость запроса */
```
Bitmap Heap Scan on sessions  (cost=183.49..35643.56 rows=9685 width=8) (actual time=4.678..791.567 rows=9934 loops=1)
  Recheck Cond: (movie_id = 500)
  Heap Blocks: exact=9819
  ->  Bitmap Index Scan on index_movie_id  (cost=0.00..181.07 rows=9685 width=0) (actual time=2.901..2.901 rows=9934 loops=1)
        Index Cond: (movie_id = 500)
Planning Time: 4.036 ms
Execution Time: 792.597 ms
```

EXPLAIN ANALYZE SELECT homework.movies.title from homework.sessions 
JOIN homework.movies ON homework.movies.id = homework.sessions.movie_id 
where homework.sessions.movie_id = 20

/* поставил index с предыдущего запроса, скорость запроса стала быстрее(index для поля movie_id) */
```
Nested Loop  (cost=0.87..20386.80 rows=9685 width=264) (actual time=0.500..50.663 rows=9949 loops=1)
  ->  Index Scan using movies_pkey on movies  (cost=0.43..8.45 rows=1 width=272) (actual time=0.029..0.030 rows=1 loops=1)
        Index Cond: (id = 20)
  ->  Index Only Scan using index_movie_id on sessions  (cost=0.43..20281.49 rows=9685 width=8) (actual time=0.469..49.592 rows=9949 loops=1)
        Index Cond: (movie_id = 20)
        Heap Fetches: 9949
Planning Time: 6.363 ms
Execution Time: 51.022 ms
```

EXPLAIN ANALYZE SELECT tickets.id, sessions.title, client.first_name FROM  homework.tickets as tickets join homework.client as client on tickets.client_id = client.id
                                          join homework.sessions as sessions on tickets.session_id = sessions.id
                                           where client.id = 44

 /* поставил index с предыдущего запроса, скорость запроса стала быстрее(index для поля client_id) */
```
Nested Loop  (cost=28556.93..29790.64 rows=9720 width=537) (actual time=1893.919..1898.540 rows=10050 loops=1)
  ->  Index Scan using client_pkey on client  (cost=0.43..8.45 rows=1 width=272) (actual time=0.079..0.080 rows=1 loops=1)
        Index Cond: (id = 44)
  ->  Merge Join  (cost=28556.49..29684.99 rows=9720 width=281) (actual time=1893.837..1897.931 rows=10050 loops=1)
        Merge Cond: (sessions.id = tickets.session_id)
        ->  Index Scan using sessions_pkey on sessions  (cost=0.43..1059395.44 rows=10000000 width=273) (actual time=0.009..2.334 rows=5924 loops=1)
        ->  Sort  (cost=28541.00..28565.30 rows=9720 width=24) (actual time=1893.823..1894.354 rows=10050 loops=1)
              Sort Key: tickets.session_id
              Sort Method: quicksort  Memory: 1170kB
              ->  Bitmap Heap Scan on tickets  (cost=183.76..27897.21 rows=9720 width=24) (actual time=8.878..1884.848 rows=10050 loops=1)
                    Recheck Cond: (client_id = 44)
                    Heap Blocks: exact=9477
                    ->  Bitmap Index Scan on index_client_id  (cost=0.00..181.33 rows=9720 width=0) (actual time=5.742..5.742 rows=10050 loops=1)
                          Index Cond: (client_id = 44)
Planning Time: 12.383 ms
Execution Time: 1899.147 ms
```   

EXPLAIN ANALYZE SELECT tickets.id, sessions.title, halls.title FROM  homework.tickets as tickets 
                                          left join homework.sessions as sessions on tickets.session_id = sessions.id
                                          left join homework.halls as halls on sessions.hall_id = halls.id
                                          where halls.title = '7 зал'
            
CREATE INDEX index_title ON homework.halls (title);

 /* как только поставил index для title, Execution Time стал меньше */            
 ```
Gather  (cost=853213.02..993838.80 rows=1 width=535) (actual time=37595.359..41920.565 rows=2 loops=1)
  Workers Planned: 2
  Workers Launched: 2
  ->  Parallel Hash Join  (cost=852213.02..992838.70 rows=1 width=535) (actual time=38975.472..41846.379 rows=1 loops=3)
        Hash Cond: (tickets.session_id = sessions.id)
        ->  Parallel Seq Scan on tickets  (cost=0.00..125000.67 rows=4166667 width=16) (actual time=0.563..3897.554 rows=3333333 loops=3)
        ->  Parallel Hash  (cost=852213.01..852213.01 rows=1 width=535) (actual time=37534.615..37534.615 rows=3310 loops=3)
              Buckets: 16384 (originally 1024)  Batches: 1 (originally 1)  Memory Usage: 5976kB
              ->  Hash Join  (cost=8.84..852213.01 rows=1 width=535) (actual time=12420.315..37291.553 rows=3310 loops=3)
                    Hash Cond: (sessions.hall_id = halls.id)
                    ->  Parallel Seq Scan on sessions  (cost=0.00..841266.67 rows=4166667 width=281) (actual time=12418.073..36867.130 rows=3333333 loops=3)
                    ->  Hash  (cost=8.83..8.83 rows=1 width=270) (actual time=0.536..0.537 rows=1 loops=3)
                          Buckets: 1024  Batches: 1  Memory Usage: 9kB
                          ->  Index Scan using index_title on halls  (cost=0.81..8.83 rows=1 width=270) (actual time=0.516..0.519 rows=1 loops=3)
                                Index Cond: (title = '7 зал'::bpchar)
Planning Time: 11.587 ms
Execution Time: 41920.704 ms
```                                  