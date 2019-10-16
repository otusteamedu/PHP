/*SIMPLE QUERIES*/

/* 1 */
EXPLAIN ANALYSE SELECT id FROM tickets WHERE price = 100;
/*
 QUERY PLAN
Seq Scan on tickets  (cost=0.00..189.00 rows=23 width=4) (actual time=0.089..2.542 rows=18 loops=1)
  Filter: (price = '100'::numeric)
  Rows Removed by Filter: 9982
Planning Time: 0.316 ms
Execution Time: 2.576 ms
 */

CREATE INDEX price_idx ON tickets (price);
EXPLAIN ANALYSE SELECT id FROM tickets WHERE price = 100;
/*
QUERY PLAN
Bitmap Heap Scan on tickets  (cost=4.46..51.21 rows=23 width=4) (actual time=0.046..0.097 rows=18 loops=1)
  Recheck Cond: (price = '100'::numeric)
  Heap Blocks: exact=15
  ->  Bitmap Index Scan on price_idx  (cost=0.00..4.46 rows=23 width=0) (actual time=0.035..0.035 rows=18 loops=1)
        Index Cond: (price = '100'::numeric)
Planning Time: 0.564 ms
Execution Time: 0.131 ms
 */
/* после того как установили индекс по полю цены - скорость запроса ощутимо выросла*/


/* 2 */
EXPLAIN ANALYZE SELECT id FROM tickets WHERE seat_id = 36;
/*
QUERY PLAN
Bitmap Heap Scan on tickets  (cost=5.06..72.93 rows=100 width=4) (actual time=0.048..0.067 rows=100 loops=1)
  Recheck Cond: (seat_id = 36)
  Heap Blocks: exact=1
  ->  Bitmap Index Scan on tickets_seat_id_session_id_key  (cost=0.00..5.04 rows=100 width=0) (actual time=0.027..0.027 rows=100 loops=1)
        Index Cond: (seat_id = 36)
Planning Time: 0.572 ms
Execution Time: 0.132 ms
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
EXPLAIN ANALYZE SELECT id FROM tickets WHERE session_id = 110;
/*
QUERY PLAN
Seq Scan on tickets  (cost=0.00..189.00 rows=1 width=4) (actual time=1.560..1.560 rows=0 loops=1)
  Filter: (session_id = 110)
  Rows Removed by Filter: 10000
Planning Time: 0.278 ms
Execution Time: 1.580 ms
 */
CREATE INDEX session_idx ON tickets (session_id);
EXPLAIN ANALYZE SELECT id FROM tickets WHERE session_id = 110;
/*
QUERY PLAN
Index Scan using session_idx on tickets  (cost=0.29..8.30 rows=1 width=4) (actual time=0.029..0.029 rows=0 loops=1)
  Index Cond: (session_id = 110)
Planning Time: 0.633 ms
Execution Time: 0.052 ms
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
    sessions.film_id = 2;
/*
QUERY PLAN
Hash Join  (cost=2.38..193.74 rows=1000 width=12) (actual time=0.064..2.489 rows=1000 loops=1)
  Hash Cond: (tickets.session_id = sessions.id)
  ->  Seq Scan on tickets  (cost=0.00..164.00 rows=10000 width=8) (actual time=0.011..1.027 rows=10000 loops=1)
  ->  Hash  (cost=2.25..2.25 rows=10 width=12) (actual time=0.022..0.022 rows=10 loops=1)
        Buckets: 1024  Batches: 1  Memory Usage: 9kB
        ->  Seq Scan on sessions  (cost=0.00..2.25 rows=10 width=12) (actual time=0.010..0.016 rows=10 loops=1)
              Filter: (film_id = 2)
              Rows Removed by Filter: 90
Planning Time: 0.783 ms
Execution Time: 2.570 ms
 */
CREATE INDEX film_id_idx ON sessions (film_id);
/*
 QUERY PLAN
Nested Loop  (cost=5.06..76.18 rows=100 width=12) (actual time=0.137..0.137 rows=0 loops=1)
  ->  Seq Scan on sessions  (cost=0.00..2.25 rows=1 width=12) (actual time=0.136..0.136 rows=0 loops=1)
        Filter: (film_id = 22)
        Rows Removed by Filter: 100
  ->  Bitmap Heap Scan on tickets  (cost=5.06..72.93 rows=100 width=8) (never executed)
        Recheck Cond: (session_id = sessions.id)
        ->  Bitmap Index Scan on session_idx  (cost=0.00..5.04 rows=100 width=0) (never executed)
              Index Cond: (session_id = sessions.id)
Planning Time: 2.196 ms
Execution Time: 0.180 ms
 */
 /* добавили индекс по film_id стало хорошо*/



/* 2 */
EXPLAIN ANALYZE SELECT
    tickets.id,
    sessions.time,
    films.name
FROM
    tickets JOIN sessions ON tickets.session_id = sessions.id
            JOIN films ON sessions.film_id = films.id
WHERE
        films.id = 2;
/*
QUERY PLAN
Nested Loop  (cost=2.52..211.90 rows=1000 width=528) (actual time=0.189..3.739 rows=1000 loops=1)
  ->  Index Scan using films_pkey on films  (cost=0.14..8.16 rows=1 width=520) (actual time=0.011..0.016 rows=1 loops=1)
        Index Cond: (id = 2)
  ->  Hash Join  (cost=2.38..193.74 rows=1000 width=16) (actual time=0.175..3.596 rows=1000 loops=1)
        Hash Cond: (tickets.session_id = sessions.id)
        ->  Seq Scan on tickets  (cost=0.00..164.00 rows=10000 width=8) (actual time=0.011..1.838 rows=10000 loops=1)
        ->  Hash  (cost=2.25..2.25 rows=10 width=16) (actual time=0.024..0.024 rows=10 loops=1)
              Buckets: 1024  Batches: 1  Memory Usage: 9kB
              ->  Seq Scan on sessions  (cost=0.00..2.25 rows=10 width=16) (actual time=0.011..0.018 rows=10 loops=1)
                    Filter: (film_id = 2)
                    Rows Removed by Filter: 90
Planning Time: 0.786 ms
Execution Time: 3.839 ms
 */

/* индекс из предыдущего примера не использовался, т.к объем выборки по sessions.film_id довольно маленький*/



/* 3 */
EXPLAIN ANALYZE SELECT
    tickets.id,
    sessions.time,
    halls.name
FROM
    tickets JOIN sessions ON tickets.session_id = sessions.id
        JOIN halls ON sessions.film_id = halls.id
WHERE
    halls.name = 'ql1Zc3eBV4';

/*
 QUERY PLAN
Nested Loop  (cost=12.05..20.83 rows=71 width=528) (actual time=2.558..3.506 rows=1000 loops=1)
  ->  Hash Join  (cost=11.76..14.04 rows=1 width=528) (actual time=2.407..2.433 rows=10 loops=1)
        Hash Cond: (sessions.film_id = halls.id)
        ->  Seq Scan on sessions  (cost=0.00..2.00 rows=100 width=16) (actual time=0.015..0.024 rows=100 loops=1)
        ->  Hash  (cost=11.75..11.75 rows=1 width=520) (actual time=0.036..0.036 rows=1 loops=1)
              Buckets: 1024  Batches: 1  Memory Usage: 9kB
              ->  Seq Scan on halls  (cost=0.00..11.75 rows=1 width=520) (actual time=0.025..0.028 rows=1 loops=1)
                    Filter: ((name)::text = 'ql1Zc3eBV4'::text)
                    Rows Removed by Filter: 9
  ->  Index Scan using session_idx on tickets  (cost=0.29..5.79 rows=100 width=8) (actual time=0.018..0.093 rows=100 loops=10)
        Index Cond: (session_id = sessions.id)
Planning Time: 2.312 ms
Execution Time: 3.706 ms
 */

 /* там где строк больше всего надо было перебрать - использовался индекс session_idx. в остальных выборках строк мало. не думаю что стоит
    тут что-то еще улучшать
  */