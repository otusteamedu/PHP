/*SIMPLE QUERIES*/

/* 1 */
EXPLAIN ANALYSE SELECT id FROM tickets WHERE price = 100;
/*
QUERY PLAN
Gather  (cost=1000.00..120010.96 rows=32333 width=4) (actual time=22.146..1858.692 rows=25146 loops=1)
  Workers Planned: 2
  Workers Launched: 2
  ->  Parallel Seq Scan on tickets  (cost=0.00..115777.66 rows=13472 width=4) (actual time=17.471..1661.202 rows=8382 loops=3)
        Filter: (price = '100'::numeric)
        Rows Removed by Filter: 3324951
Planning Time: 0.656 ms
JIT:
  Functions: 12
  Options: Inlining false, Optimization false, Expressions true, Deforming true
  Timing: Generation 2.547 ms, Inlining 0.000 ms, Optimization 1.095 ms, Emission 37.618 ms, Total 41.260 ms
Execution Time: 1926.329 ms
 */
CREATE INDEX price_idx ON tickets (price);
EXPLAIN ANALYSE SELECT id FROM tickets WHERE price = 100;
/*
QUERY PLAN
Bitmap Heap Scan on tickets  (cost=607.02..54937.12 rows=32333 width=4) (actual time=94.507..430.279 rows=25146 loops=1)
  Recheck Cond: (price = '100'::numeric)
  Heap Blocks: exact=20758
  ->  Bitmap Index Scan on price_idx  (cost=0.00..598.93 rows=32333 width=0) (actual time=78.727..78.727 rows=25146 loops=1)
        Index Cond: (price = '100'::numeric)
Planning Time: 0.874 ms
Execution Time: 432.875 ms
 */
/* после того как установили индекс по полю цены - скорость запроса ощутимо выросла*/


/* 2 */
EXPLAIN ANALYZE SELECT id FROM tickets WHERE seat_id = 3681;
/*
QUERY PLAN
Bitmap Heap Scan on tickets  (cost=257.66..26788.90 rows=9964 width=4) (actual time=7.560..76.818 rows=10000 loops=1)
  Recheck Cond: (seat_id = 3681)
  Heap Blocks: exact=10000
  ->  Bitmap Index Scan on tickets_seat_id_session_id_key  (cost=0.00..255.17 rows=9964 width=0) (actual time=4.832..4.832 rows=10000 loops=1)
        Index Cond: (seat_id = 3681)
Planning Time: 0.464 ms
Execution Time: 78.653 ms
 */
SELECT
    indexname,
    indexdef
FROM
    pg_indexes
WHERE
        tablename = 'tickets';
/*
tickets_pkey	CREATE UNIQUE INDEX tickets_pkey ON public.tickets USING btree (id)
tickets_seat_id_session_id_key	CREATE UNIQUE INDEX tickets_seat_id_session_id_key ON public.tickets USING btree (seat_id, session_id)
price_idx	CREATE INDEX price_idx ON public.tickets USING btree (price)
 */
 /*
 тут у нас уже сразу случился поиск с использованием индекса, потому что мы ранее добавляли условине уникальности по месту и сеансу, и
 собственно первая часть от этого составного индекса тут и использовалась
  */


/* 3 */
EXPLAIN ANALYZE SELECT id FROM tickets WHERE session_id = 10102122;
/*
QUERY PLAN
Gather  (cost=1000.00..116881.83 rows=1035 width=4) (actual time=56.991..1508.881 rows=1000 loops=1)
  Workers Planned: 2
  Workers Launched: 2
  ->  Parallel Seq Scan on tickets  (cost=0.00..115778.33 rows=431 width=4) (actual time=871.782..1351.671 rows=333 loops=3)
        Filter: (session_id = 10102122)
        Rows Removed by Filter: 3333000
Planning Time: 0.456 ms
JIT:
  Functions: 12
  Options: Inlining false, Optimization false, Expressions true, Deforming true
  Timing: Generation 1.748 ms, Inlining 0.000 ms, Optimization 5.459 ms, Emission 50.071 ms, Total 57.277 ms
Execution Time: 1662.337 ms
 */
CREATE INDEX session_idx ON tickets (session_id);
EXPLAIN ANALYZE SELECT id FROM tickets WHERE session_id = 10102122;
/*
QUERY PLAN
Index Scan using session_idx on tickets  (cost=0.43..40.55 rows=1035 width=4) (actual time=0.921..3.074 rows=1000 loops=1)
  Index Cond: (session_id = 10102122)
Planning Time: 0.900 ms
Execution Time: 3.179 ms
 */
 /* здесь пришлось делать индекс отдельный, потому что второую половину от составного индекса использовать нельзя, так что мы сгенерили отдельный*/



/*COMPLEX QUERIES*/

/* 1 */
EXPLAIN ANALYZE SELECT
    tickets.id,
    sessions.time
FROM
    tickets JOIN sessions ON tickets.session_id = sessions.id
WHERE
    sessions.film_id = 2231;
/*
QUERY PLAN
Nested Loop  (cost=0.43..7115.00 rows=100000 width=12) (actual time=0.033..106.887 rows=100000 loops=1)
  ->  Seq Scan on sessions  (cost=0.00..189.00 rows=100 width=12) (actual time=0.012..2.587 rows=100 loops=1)
        Filter: (film_id = 2231)
        Rows Removed by Filter: 9900
  ->  Index Scan using session_idx on tickets  (cost=0.43..58.72 rows=1054 width=8) (actual time=0.025..0.649 rows=1000 loops=100)
        Index Cond: (session_id = sessions.id)
Planning Time: 1.050 ms
Execution Time: 117.206 ms
 */
/*отработал индекс по сессии из предыдущих запросов*/

/* 2 */
EXPLAIN ANALYZE SELECT
    tickets.id,
    sessions.time,
    films.name
FROM
    tickets JOIN sessions ON tickets.session_id = sessions.id
        JOIN films ON sessions.film_id = films.id
WHERE
    films.id = 2231;
/*
QUERY PLAN
Nested Loop  (cost=0.43..7118.25 rows=100000 width=23) (actual time=0.035..84.181 rows=100000 loops=1)
  ->  Nested Loop  (cost=0.00..192.25 rows=100 width=23) (actual time=0.018..2.334 rows=100 loops=1)
        ->  Seq Scan on films  (cost=0.00..2.25 rows=1 width=15) (actual time=0.009..0.022 rows=1 loops=1)
              Filter: (id = 2231)
              Rows Removed by Filter: 99
        ->  Seq Scan on sessions  (cost=0.00..189.00 rows=100 width=16) (actual time=0.007..2.220 rows=100 loops=1)
              Filter: (film_id = 2231)
              Rows Removed by Filter: 9900
  ->  Index Scan using session_idx on tickets  (cost=0.43..58.72 rows=1054 width=8) (actual time=0.065..0.578 rows=1000 loops=100)
        Index Cond: (session_id = sessions.id)
Planning Time: 0.934 ms
Execution Time: 103.314 ms
 */
CREATE INDEX films_idx ON sessions (film_id);
/*
 QUERY PLAN
Nested Loop  (cost=5.50..7002.18 rows=100000 width=23) (actual time=0.134..78.387 rows=100000 loops=1)
  ->  Nested Loop  (cost=5.06..76.18 rows=100 width=23) (actual time=0.103..0.523 rows=100 loops=1)
        ->  Seq Scan on films  (cost=0.00..2.25 rows=1 width=15) (actual time=0.012..0.020 rows=1 loops=1)
              Filter: (id = 2231)
              Rows Removed by Filter: 99
        ->  Bitmap Heap Scan on sessions  (cost=5.06..72.93 rows=100 width=16) (actual time=0.086..0.391 rows=100 loops=1)
              Recheck Cond: (film_id = 2231)
              Heap Blocks: exact=11
              ->  Bitmap Index Scan on films_idx  (cost=0.00..5.04 rows=100 width=0) (actual time=0.068..0.068 rows=100 loops=1)
                    Index Cond: (film_id = 2231)
  ->  Index Scan using session_idx on tickets  (cost=0.43..58.72 rows=1054 width=8) (actual time=0.026..0.508 rows=1000 loops=100)
        Index Cond: (session_id = sessions.id)
Planning Time: 1.194 ms
Execution Time: 87.264 ms
 */
 /* добавили индексы по фильмам и это немного ускорило дело. немного потому что 10 000 000 записей у нас только билетов, а фильмов - 10 000*/


/* 3 */
EXPLAIN ANALYZE SELECT
    tickets.id,
    sessions.time,
    halls.name
FROM
    tickets JOIN sessions ON tickets.session_id = sessions.id
    JOIN halls ON sessions.film_id = halls.id
WHERE
    halls.name = 'c243XAz1L8';
/*
 QUERY PLAN
Merge Join  (cost=34.35..87.33 rows=5291 width=23) (actual time=0.068..0.068 rows=0 loops=1)
  Merge Cond: (sessions.film_id = halls.id)
  ->  Nested Loop  (cost=0.72..553040.00 rows=10000000 width=16) (actual time=0.026..0.026 rows=1 loops=1)
        ->  Index Scan using films_idx on sessions  (cost=0.29..524.00 rows=10000 width=16) (actual time=0.008..0.008 rows=1 loops=1)
        ->  Index Scan using session_idx on tickets  (cost=0.43..44.71 rows=1054 width=8) (actual time=0.014..0.014 rows=1 loops=1)
              Index Cond: (session_id = sessions.id)
  ->  Sort  (cost=33.63..33.64 rows=1 width=15) (actual time=0.040..0.040 rows=1 loops=1)
        Sort Key: halls.id
        Sort Method: quicksort  Memory: 25kB
        ->  Seq Scan on halls  (cost=0.00..33.62 rows=1 width=15) (actual time=0.010..0.011 rows=1 loops=1)
              Filter: ((name)::text = 'c243XAz1L8'::text)
              Rows Removed by Filter: 9
Planning Time: 1.519 ms
Execution Time: 0.151 ms
 */
CREATE INDEX name_idx ON halls (name);
/*

QUERY PLAN
Merge Join  (cost=1.85..1001.92 rows=100000 width=23) (actual time=0.066..0.066 rows=0 loops=1)
  Merge Cond: (sessions.film_id = halls.id)
  ->  Nested Loop  (cost=0.72..553040.00 rows=10000000 width=16) (actual time=0.025..0.026 rows=1 loops=1)
        ->  Index Scan using films_idx on sessions  (cost=0.29..524.00 rows=10000 width=16) (actual time=0.006..0.006 rows=1 loops=1)
        ->  Index Scan using session_idx on tickets  (cost=0.43..44.71 rows=1054 width=8) (actual time=0.014..0.014 rows=1 loops=1)
              Index Cond: (session_id = sessions.id)
  ->  Sort  (cost=1.14..1.14 rows=1 width=15) (actual time=0.039..0.039 rows=1 loops=1)
        Sort Key: halls.id
        Sort Method: quicksort  Memory: 25kB
        ->  Seq Scan on halls  (cost=0.00..1.12 rows=1 width=15) (actual time=0.009..0.010 rows=1 loops=1)
              Filter: ((name)::text = 'c243XAz1L8'::text)
              Rows Removed by Filter: 9
Planning Time: 1.116 ms
Execution Time: 0.144 ms
 */
 /* добавили индекс по залам, но т.к. залов всего 10, то планировщик забил на это и прошелся полным перебором десяти записей*/