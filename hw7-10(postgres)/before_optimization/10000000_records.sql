-------=====simple queries======-----------------------
explain analyze
select *
from tickets t
order by session_id desc
limit 1;

Limit
    (cost=243458.00..243458.00 rows =1 width=48)
    (actual time=1252.893..1252.894 rows=1 loops=1)
  ->  Sort  (cost=243458.00..268458.00 rows=10000000 width=48) (actual time=1252.891..1252.891 rows=1 loops=1)
        Sort Key: session_id DESC
        Sort Method: top-N heapsort  Memory: 25kB
        ->  Seq Scan on tickets t  (cost=0.00..193458.00 rows=10000000 width=48) (actual time=0.019..678.044 rows=10000000 loops=1)
Planning time: 0.223 ms
Execution time: 1252.931 ms
------------------------------------------------------------------------

explain analyze select * from sessions s where s.start_time > now();

Seq Scan on sessions s  (cost=0.00..253093.00 rows=1 width=56) (actual time=1312.089..1312.089 rows=0 loops=1)
  Filter: (start_time > now())
  Rows Removed by Filter: 10000000
Planning time: 0.279 ms
Execution time: 1312.129 ms
--------------------------------------------------------------------------

explain analyze
select *
from orders o
where o.created_at > now();

Seq Scan on orders o  (cost=0.00..223531.20 rows=1 width=28) (actual time=1633.186..1633.186 rows=0 loops=1)
  Filter: (created_at > now())
  Rows Removed by Filter: 10000000
Planning time: 1.228 ms
Execution time: 1633.216 ms

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

Hash Right Join  (cost=154143.46..155763.65 rows=25002 width=524) (actual time=2.535..2103.914 rows=1428312 loops=1)
  Hash Cond: (tasks.movie_id = m.id)
  CTE tasks
    ->  Gather  (cost=1008.17..154131.88 rows=71435 width=12) (actual time=2.289..1271.655 rows=1428312 loops=1)
          Workers Planned: 2
          Workers Launched: 2
          ->  Hash Join  (cost=8.17..145363.33 rows=29765 width=12) (actual time=0.836..1557.937 rows=476104 loops=3)
                Hash Cond: (v.attribute_type_id = t.id)
                ->  Parallel Seq Scan on movie_attribute_values v  (cost=0.00..133639.15 rows=4167015 width=12) (actual time=0.242..867.546 rows=3333333 loops=3)
                ->  Hash  (cost=8.16..8.16 rows=1 width=4) (actual time=0.526..0.527 rows=1 loops=3)
                      Buckets: 1024  Batches: 1  Memory Usage: 9kB
                      ->  Index Scan using movie_attribute_types_name_idx on movie_attribute_types t  (cost=0.14..8.16 rows=1 width=4) (actual time=0.521..0.522 rows=1 loops=3)
                            Index Cond: ((name)::text = 'Служебные задачи'::text)
  ->  CTE Scan on tasks  (cost=0.00..1428.70 rows=71435 width=12) (actual time=2.292..1727.818 rows=1428312 loops=1)
  ->  Hash  (cost=10.70..10.70 rows=70 width=520) (actual time=0.219..0.220 rows=10 loops=1)
        Buckets: 1024  Batches: 1  Memory Usage: 9kB
        ->  Seq Scan on movies m  (cost=0.00..10.70 rows=70 width=520) (actual time=0.211..0.213 rows=10 loops=1)
Planning time: 3.189 ms
Execution time: 2167.565 ms

----------------------------------------------------------------------------------

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

Hash Left Join  (cost=37.88..423963.17 rows=10000835 width=1580) (actual time=0.308..6560.682 rows=10000000 loops=1)
  Hash Cond: (v.movie_id = m.id)
  ->  Hash Left Join  (cost=26.30..246097.46 rows=10000835 width=1063) (actual time=0.286..4342.321 rows=10000000 loops=1)
        Hash Cond: (v.attribute_type_id = t.id)
        ->  Hash Left Join  (cost=13.15..219037.41 rows=10000835 width=551) (actual time=0.254..2825.805 rows=10000000 loops=1)
              Hash Cond: (v.attribute_id = a.id)
              ->  Seq Scan on movie_attribute_values v  (cost=0.00..191977.35 rows=10000835 width=39) (actual time=0.036..863.615 rows=10000000 loops=1)
              ->  Hash  (cost=11.40..11.40 rows=140 width=520) (actual time=0.202..0.202 rows=14 loops=1)
                    Buckets: 1024  Batches: 1  Memory Usage: 9kB
                    ->  Seq Scan on movie_attributes a  (cost=0.00..11.40 rows=140 width=520) (actual time=0.178..0.185 rows=14 loops=1)
        ->  Hash  (cost=11.40..11.40 rows=140 width=520) (actual time=0.016..0.016 rows=7 loops=1)
              Buckets: 1024  Batches: 1  Memory Usage: 9kB
              ->  Seq Scan on movie_attribute_types t  (cost=0.00..11.40 rows=140 width=520) (actual time=0.006..0.008 rows=7 loops=1)
  ->  Hash  (cost=10.70..10.70 rows=70 width=520) (actual time=0.011..0.011 rows=10 loops=1)
        Buckets: 1024  Batches: 1  Memory Usage: 9kB
        ->  Seq Scan on movies m  (cost=0.00..10.70 rows=70 width=520) (actual time=0.005..0.007 rows=10 loops=1)
Planning time: 1.522 ms
Execution time: 6831.323 ms

---------------------------------------------------------------------------------------

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
         LEFT JOIN movies ON movies.id = sessions.movie_id;

Hash Left Join  (cost=714460.64..1375762.09 rows=10000006 width=40) (actual time=5107.542..14832.228 rows=10000000 loops=1)
  Hash Cond: (sessions.movie_id = movies.id)
  ->  Hash Left Join  (cost=714449.06..1272911.17 rows=10000006 width=32) (actual time=5107.518..13462.497 rows=10000000 loops=1)
        Hash Cond: (tickets.session_id = sessions.id)
        ->  Hash Left Join  (cost=337526.59..703721.67 rows=10000006 width=20) (actual time=2506.255..7232.825 rows=10000000 loops=1)
              Hash Cond: (tickets.hall_seat_id = hall_seats.id)
              ->  Seq Scan on tickets  (cost=0.00..193458.06 rows=10000006 width=12) (actual time=0.052..1108.580 rows=10000000 loops=1)
              ->  Hash  (cost=163696.15..163696.15 rows=10000115 width=12) (actual time=2505.230..2505.230 rows=10000000 loops=1)
                    Buckets: 131072  Batches: 256  Memory Usage: 2706kB
                    ->  Seq Scan on hall_seats  (cost=0.00..163696.15 rows=10000115 width=12) (actual time=0.016..1172.459 rows=10000000 loops=1)
        ->  Hash  (cost=203093.21..203093.21 rows=10000021 width=16) (actual time=2580.313..2580.313 rows=10000000 loops=1)
              Buckets: 131072  Batches: 256  Memory Usage: 2858kB
              ->  Seq Scan on sessions  (cost=0.00..203093.21 rows=10000021 width=16) (actual time=0.006..1239.511 rows=10000000 loops=1)
  ->  Hash  (cost=10.70..10.70 rows=70 width=8) (actual time=0.010..0.010 rows=10 loops=1)
        Buckets: 1024  Batches: 1  Memory Usage: 9kB
        ->  Seq Scan on movies  (cost=0.00..10.70 rows=70 width=8) (actual time=0.004..0.005 rows=10 loops=1)
Planning time: 4.715 ms
Execution time: 15070.334 ms