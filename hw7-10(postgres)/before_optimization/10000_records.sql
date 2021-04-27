-------=====simple queries======-----------------------
explain analyze
select *
from tickets t
where t.status = 'sold';

Seq Scan on tickets t  (cost=0.00..437.00 rows=5045 width=48) (actual time=0.010..1.896 rows=5045 loops=1)
  Filter: (status = 'sold'::ticket_statuses)
  Rows Removed by Filter: 14955
Planning time: 0.126 ms
Execution time: 2.062 ms
------------------------------------------------------------------------

explain analyze
select *
from sessions s
where s.title = 'Имя сессии';

Seq Scan on sessions s  (cost=0.00..457.00 rows=20000 width=56) (actual time=0.005..2.574 rows=20000 loops=1)
  Filter: ((title)::text = 'Имя сессии'::text)
Planning time: 0.102 ms
Execution time: 3.191 ms
-------------------------------------------------------------------------

explain analyze
select *
from orders o
where created_at > now();

Seq Scan on orders o  (cost=0.00..671.00 rows=1 width=28) (actual time=8.855..8.857 rows=1 loops=1)
  Filter: (created_at > now())
  Rows Removed by Filter: 29999
Planning time: 0.131 ms
Execution time: 8.890 ms

----------=======complex queries======---------------------------
explain analyze
WITH tasks AS (
    SELECT CASE
               WHEN v.value_date = CURRENT_DATE THEN v.value_date
               ELSE NULL::date
               END AS actual_task,
           CASE
               WHEN v.value_date = date(CURRENT_DATE + '20 days'::interval day) THEN v.value_date
               ELSE NULL::date
               END AS actual_in_20_days,
           v.movie_id
    FROM movie_attribute_values v
             LEFT JOIN movie_attribute_types t ON t.id = v.attribute_type_id
    WHERE t.name::text = 'Служебные задачи'::text
)
SELECT m.title,
       tasks.actual_task,
       tasks.actual_in_20_days
FROM movies m
         LEFT JOIN tasks ON m.id = tasks.movie_id;

Hash Right Join  (cost=345.46..350.32 rows=75 width=524) (actual time=0.299..18.084 rows=4269 loops=1)
  Hash Cond: (tasks.movie_id = m.id)
  CTE tasks
    ->  Nested Loop  (cost=35.51..333.89 rows=214 width=12) (actual time=0.213..11.744 rows=4269 loops=1)
          ->  Index Scan using movie_attribute_types_name_idx on movie_attribute_types t  (cost=0.14..8.16 rows=1 width=4) (actual time=0.040..0.050 rows=3 loops=1)
                Index Cond: ((name)::text = 'Служебные задачи'::text)
          ->  Bitmap Heap Scan on movie_attribute_values v  (cost=35.36..308.22 rows=1429 width=12) (actual time=0.341..1.648 rows=1423 loops=3)
                Recheck Cond: (attribute_type_id = t.id)
                Heap Blocks: exact=496
                ->  Bitmap Index Scan on movie_attribute_values_attribute_type_id_idx  (cost=0.00..35.01 rows=1429 width=0) (actual time=0.266..0.266 rows=1423 loops=3)
                      Index Cond: (attribute_type_id = t.id)
  ->  CTE Scan on tasks  (cost=0.00..4.28 rows=214 width=12) (actual time=0.217..14.917 rows=4269 loops=1)
  ->  Hash  (cost=10.70..10.70 rows=70 width=520) (actual time=0.045..0.046 rows=30 loops=1)
        Buckets: 1024  Batches: 1  Memory Usage: 10kB
        ->  Seq Scan on movies m  (cost=0.00..10.70 rows=70 width=520) (actual time=0.014..0.025 rows=30 loops=1)
Planning time: 1.666 ms
Execution time: 18.781 ms

-------------------------------------------------------------------------------

explain analyze
SELECT m.title,
       t.name  AS task_type,
       a.name,
       CASE
           WHEN v.value_boolean AND v.value_int IS NULL AND v.value_float IS NULL AND v.value_date IS NULL AND
                v.value_text IS NULL THEN 'Присутствует'::text
           WHEN v.value_date IS NOT NULL AND v.value_int IS NULL AND v.value_float IS NULL AND v.value_text IS NULL
               THEN v.value_date::text
           WHEN v.value_date IS NULL AND v.value_int IS NOT NULL AND v.value_float IS NULL AND v.value_text IS NULL
               THEN v.value_int::text
           WHEN v.value_date IS NULL AND v.value_int IS NULL AND v.value_float IS NOT NULL AND v.value_text IS NULL
               THEN v.value_float::text
           WHEN v.value_date IS NULL AND v.value_int IS NULL AND v.value_float IS NULL AND v.value_text IS NOT NULL
               THEN v.value_text
           ELSE NULL::text
           END AS value
FROM movie_attribute_values v
         LEFT JOIN movie_attributes a ON a.id = v.attribute_id
         LEFT JOIN movie_attribute_types t ON t.id = v.attribute_type_id
         LEFT JOIN movies m ON m.id = v.movie_id;

-> Hash Left Join  (cost=26.30..743.56 rows=30000 width=1059) (actual time=0.197..24.632 rows=30000 loops=1)
        Hash Cond: (v.attribute_type_id = t.id)
        ->  Hash Left Join  (cost=13.15..649.28 rows=30000 width=547) (actual time=0.142..15.777 rows=30000 loops=1)
              Hash Cond: (v.attribute_id = a.id)
              ->  Seq Scan on movie_attribute_values v  (cost=0.00..555.00 rows=30000 width=35) (actual time=0.029..4.293 rows=30000 loops=1)
              ->  Hash  (cost=11.40..11.40 rows=140 width=520) (actual time=0.078..0.079 rows=42 loops=1)
                    Buckets: 1024  Batches: 1  Memory Usage: 11kB
                    ->  Seq Scan on movie_attributes a  (cost=0.00..11.40 rows=140 width=520) (actual time=0.017..0.040 rows=42 loops=1)
        ->  Hash  (cost=11.40..11.40 rows=140 width=520) (actual time=0.042..0.042 rows=21 loops=1)
              Buckets: 1024  Batches: 1  Memory Usage: 10kB
              ->  Seq Scan on movie_attribute_types t  (cost=0.00..11.40 rows=140 width=520) (actual time=0.011..0.024 rows=21 loops=1)
  ->  Hash  (cost=10.70..10.70 rows=70 width=520) (actual time=0.060..0.060 rows=30 loops=1)
        Buckets: 1024  Batches: 1  Memory Usage: 10kB
        ->  Seq Scan on movies m  (cost=0.00..10.70 rows=70 width=520) (actual time=0.014..0.032 rows=30 loops=1)
Planning time: 1.691 ms
Execution time: 38.993 ms

----------------------------------------------------------------------------------------

explain analyze
SELECT tickets.id AS ticket_id,
       tickets.session_id,
       tickets.hall_seat_id,
       movies.base_price,
       hall_seats.seat_price_modificator,
       sessions.session_price_modificator,
       movies.base_price::double precision * hall_seats.seat_price_modificator *
       sessions.session_price_modificator AS ticket_price
FROM tickets
         LEFT JOIN hall_seats ON hall_seats.id = tickets.hall_seat_id
         LEFT JOIN sessions ON sessions.id = tickets.session_id
         LEFT JOIN movies ON movies.id = sessions.movie_id;

Hash Left Join  (cost=1863.58..2910.62 rows=30000 width=40) (actual time=37.821..62.009 rows=30000 loops=1)
  Hash Cond: (sessions.movie_id = movies.id)
  ->  Hash Left Join  (cost=1852.00..2590.52 rows=30000 width=32) (actual time=37.787..55.790 rows=30000 loops=1)
        Hash Cond: (tickets.session_id = sessions.id)
        ->  Hash Left Join  (cost=867.00..1526.76 rows=30000 width=20) (actual time=25.996..36.788 rows=30000 loops=1)
              Hash Cond: (tickets.hall_seat_id = hall_seats.id)
              ->  Seq Scan on tickets  (cost=0.00..581.00 rows=30000 width=12) (actual time=0.017..2.884 rows=30000 loops=1)
              ->  Hash  (cost=492.00..492.00 rows=30000 width=12) (actual time=25.910..25.911 rows=30000 loops=1)
                    Buckets: 32768  Batches: 1  Memory Usage: 1546kB
                    ->  Seq Scan on hall_seats  (cost=0.00..492.00 rows=30000 width=12) (actual time=0.022..11.965 rows=30000 loops=1)
        ->  Hash  (cost=610.00..610.00 rows=30000 width=16) (actual time=11.583..11.583 rows=30000 loops=1)
              Buckets: 32768  Batches: 1  Memory Usage: 1663kB
              ->  Seq Scan on sessions  (cost=0.00..610.00 rows=30000 width=16) (actual time=0.010..5.717 rows=30000 loops=1)
  ->  Hash  (cost=10.70..10.70 rows=70 width=8) (actual time=0.016..0.016 rows=30 loops=1)
        Buckets: 1024  Batches: 1  Memory Usage: 10kB
        ->  Seq Scan on movies  (cost=0.00..10.70 rows=70 width=8) (actual time=0.006..0.009 rows=30 loops=1)
Planning time: 1.329 ms
Execution time: 63.120 ms
