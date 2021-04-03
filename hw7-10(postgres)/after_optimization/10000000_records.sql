-------=====simple queries======-----------------------
explain analyze
select *
from tickets t
order by session_id desc
limit 1;

Limit
    (cost=0.43..0.50 rows =1 width=48)
    (actual time =0.013..0.014 rows =1 loops=1)
    ->  Index Scan using tickets_session_id_idx on tickets t  (cost=0.43..633518.47 rows=10000000 width=48) (actual time=0.012..0.013 rows=1 loops=1)
Planning time: 0.065 ms
Execution time: 0.028 ms

-----------------------------------------------------------

explain analyze
select *
from sessions s
where s.start_time > now();

Index Scan using sessions_start_time_idx on sessions s  (cost=0.44..4.46 rows=1 width=56) (actual time=0.037..0.037 rows=0 loops=1)
  Index Cond: (start_time > now())
Planning time: 0.168 ms
Execution time: 0.079 ms

------------------------------------------------------------

explain analyze
select *
from orders o
where o.created_at > now();

Index Scan using orders_created_at_idx on orders o  (cost=0.44..4.46 rows=1 width=28) (actual time=0.028..0.028 rows=0 loops=1)
  Index Cond: (created_at > now())
Planning time: 0.158 ms
Execution time: 0.067 ms

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

Hash Right Join  (cost=172286.59..204687.47 rows=71429 width=524) (actual time=106.236..1709.152 rows=1428312 loops=1)
  Hash Cond: (tasks.movie_id = m.id)
  CTE tasks
    ->  Nested Loop  (cost=26743.86..172285.36 rows=1428571 width=12) (actual time=106.119..1211.060 rows=1428312 loops=1)
          ->  Seq Scan on movie_attribute_types t  (cost=0.00..1.09 rows=1 width=4) (actual time=0.014..0.017 rows=1 loops=1)
                Filter: ((name)::text = 'Служебные задачи'::text)
                Rows Removed by Filter: 6
          ->  Bitmap Heap Scan on movie_attribute_values v  (cost=26743.86..136570.00 rows=1428571 width=12) (actual time=106.093..715.391 rows=1428312 loops=1)
                Recheck Cond: (attribute_type_id = t.id)
                Rows Removed by Index Recheck: 3077872
                Heap Blocks: exact=58944 lossy=33025
                ->  Bitmap Index Scan on movie_attribute_values_attribute_type_id_idx  (cost=0.00..26386.72 rows=1428571 width=0) (actual time=96.165..96.165 rows=1428312 loops=1)
                      Index Cond: (attribute_type_id = t.id)
  ->  CTE Scan on tasks  (cost=0.00..28571.42 rows=1428571 width=12) (actual time=106.123..1486.139 rows=1428312 loops=1)
  ->  Hash  (cost=1.10..1.10 rows=10 width=520) (actual time=0.098..0.098 rows=10 loops=1)
        Buckets: 1024  Batches: 1  Memory Usage: 9kB
        ->  Seq Scan on movies m  (cost=0.00..1.10 rows=10 width=520) (actual time=0.074..0.082 rows=10 loops=1)
Planning time: 0.622 ms
Execution time: 1750.285 ms

-----------------------------------------------------------------------

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
         LEFT JOIN movies m ON m.id = v.movie_id
where m.id > 1 and m.id < 3;

Hash Left Join  (cost=10770.21..147874.29 rows=1000000 width=1580) (actual time=77.867..1222.496 rows=1000290 loops=1)
  Hash Cond: (v.attribute_type_id = t.id)
  ->  Hash Left Join  (cost=10769.05..128658.85 rows=1000000 width=1063) (actual time=77.846..995.812 rows=1000290 loops=1)
        Hash Cond: (v.attribute_id = a.id)
        ->  Nested Loop  (cost=10767.73..125237.88 rows=1000000 width=551) (actual time=77.822..828.946 rows=1000290 loops=1)
              ->  Seq Scan on movies m  (cost=0.00..1.15 rows=1 width=520) (actual time=0.013..0.016 rows=1 loops=1)
                    Filter: ((id > 1) AND (id < 3))
                    Rows Removed by Filter: 9
              ->  Bitmap Heap Scan on movie_attribute_values v  (cost=10767.73..115236.74 rows=1000000 width=39) (actual time=77.805..700.617 rows=1000290 loops=1)
                    Recheck Cond: (movie_id = m.id)
                    Rows Removed by Index Recheck: 3231527
                    Heap Blocks: exact=58944 lossy=33025
                    ->  Bitmap Index Scan on movie_attribute_values_movie_id_idx  (cost=0.00..10517.73 rows=1000000 width=0) (actual time=65.038..65.038 rows=1000290 loops=1)
                          Index Cond: (movie_id = m.id)
        ->  Hash  (cost=1.14..1.14 rows=14 width=520) (actual time=0.014..0.014 rows=14 loops=1)
              Buckets: 1024  Batches: 1  Memory Usage: 9kB
              ->  Seq Scan on movie_attributes a  (cost=0.00..1.14 rows=14 width=520) (actual time=0.008..0.009 rows=14 loops=1)
  ->  Hash  (cost=1.07..1.07 rows=7 width=520) (actual time=0.017..0.017 rows=7 loops=1)
        Buckets: 1024  Batches: 1  Memory Usage: 9kB
        ->  Seq Scan on movie_attribute_types t  (cost=0.00..1.07 rows=7 width=520) (actual time=0.006..0.007 rows=7 loops=1)
Planning time: 0.297 ms
Execution time: 1249.567 ms

--------------------------------------------------------------------------------------

explain analyze
SELECT tickets.id                         AS ticket_id,
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
         LEFT JOIN movies ON movies.id = sessions.movie_id
where movies.id > 1 and movies.id < 3 ;

Gather  (cost=154745.32..655454.24 rows=1000000 width=40) (actual time=1558.487..6379.984 rows=1003755 loops=1)
  Workers Planned: 2
  Workers Launched: 2
  ->  Nested Loop Left Join  (cost=153745.32..550079.24 rows=416667 width=40) (actual time=1556.241..6113.730 rows=334585 loops=3)
        ->  Hash Join  (cost=153744.88..354236.22 rows=416667 width=24) (actual time=1556.205..3371.171 rows=334585 loops=3)
              Hash Cond: (tickets.session_id = sessions.id)
              ->  Parallel Seq Scan on tickets  (cost=0.00..135124.67 rows=4166667 width=12) (actual time=0.014..437.917 rows=3333333 loops=3)
              ->  Hash  (cost=136361.88..136361.88 rows=1000000 width=16) (actual time=1555.484..1555.486 rows=999031 loops=3)
                    Buckets: 131072  Batches: 16  Memory Usage: 3941kB
                    ->  Nested Loop  (cost=10767.73..136361.88 rows=1000000 width=16) (actual time=76.955..1354.578 rows=999031 loops=3)
                          ->  Seq Scan on movies  (cost=0.00..1.15 rows=1 width=8) (actual time=0.012..0.015 rows=1 loops=3)
                                Filter: ((id > 1) AND (id < 3))
                                Rows Removed by Filter: 9
                          ->  Bitmap Heap Scan on sessions  (cost=10767.73..126360.74 rows=1000000 width=16) (actual time=76.938..1214.136 rows=999031 loops=3)
                                Recheck Cond: (movie_id = movies.id)
                                Rows Removed by Index Recheck: 5756948
                                Heap Blocks: exact=37166 lossy=65922
                                ->  Bitmap Index Scan on sessions_movie_id_idx  (cost=0.00..10517.73 rows=1000000 width=0) (actual time=69.923..69.923 rows=999031 loops=3)
                                      Index Cond: (movie_id = movies.id)
        ->  Index Scan using hall_seats_pkey on hall_seats  (cost=0.43..0.46 rows=1 width=12) (actual time=0.008..0.008 rows=1 loops=1003755)
              Index Cond: (id = tickets.hall_seat_id)
Planning time: 0.788 ms
Execution time: 6420.530 ms
























-----------------------------------------------------------------------------------------------