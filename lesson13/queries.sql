-- Найти ближайшие 5 сеансов
select seance.id, seance.hall_id, seance.date_start, seance.date_end
from test_db2.seance
where date(date_start) > (CURRENT_TIMESTAMP)
order by date_start
limit 5;

-- result for 12326 rows in db
-- 42	3	2019-05-10 00:00:00.000000	2019-05-10 01:54:46.000000	8
-- 58	4	2019-05-10 00:00:00.000000	2019-05-10 01:08:02.000000	4
-- 10	1	2019-05-10 00:00:00.000000	2019-05-10 01:54:46.000000	8
-- 26	2	2019-05-10 00:00:00.000000	2019-05-10 01:42:55.000000	2
-- 74	5	2019-05-10 00:00:00.000000	2019-05-10 01:08:02.000000	4


-- Plan for 12326 rows in db
-- Limit  (cost=6.06..6.07 rows=5 width=40) (actual time=0.113..0.116 rows=5 loops=1)
--   ->  Sort  (cost=6.06..6.21 rows=59 width=40) (actual time=0.111..0.111 rows=5 loops=1)
--         Sort Key: date_start
--         Sort Method: top-N heapsort  Memory: 25kB
--         ->  Seq Scan on seance  (cost=0.00..5.08 rows=59 width=40) (actual time=0.024..0.096 rows=77 loops=1)
--               Filter: (date(date_start) > CURRENT_TIMESTAMP)
--               Rows Removed by Filter: 99
-- Planning Time: 0.149 ms
-- Execution Time: 0.137 ms

-- Plan for 10058217 rows in db
-- Limit  (cost=436.31..436.32 rows=5 width=32) (actual time=9.780..9.783 rows=5 loops=1)
--   ->  Sort  (cost=436.31..447.89 rows=4635 width=32) (actual time=9.778..9.779 rows=5 loops=1)
--         Sort Key: date_start
--         Sort Method: top-N heapsort  Memory: 25kB
--         ->  Seq Scan on seance  (cost=0.00..359.32 rows=4635 width=32) (actual time=0.052..6.847 rows=11231 loops=1)
--               Filter: (date(date_start) > CURRENT_TIMESTAMP)
--               Rows Removed by Filter: 2673
-- Planning Time: 0.139 ms
-- Execution Time: 9.818 ms

-- After tuning
-- Limit  (cost=0.29..1.29 rows=5 width=32) (actual time=1.383..1.387 rows=5 loops=1)
--   ->  Index Scan using seance_date_start_idx on seance  (cost=0.29..936.29 rows=4635 width=32) (actual time=1.383..1.384 rows=5 loops=1)
--         Filter: (date(date_start) > CURRENT_TIMESTAMP)
--         Rows Removed by Filter: 2673
-- Planning Time: 0.092 ms
-- Execution Time: 1.404 ms


-- ########################
-- Найти ближайшие 5 комедий

select distinct film.title
from film
         left join seance on seance.film_id = film.id
         left join genre on genre.id = film.genre_id
where genre.title = 'Комедия'
and date(seance.date_start) > (CURRENT_TIMESTAMP);

-- result for 12326 rows in db
-- Ладони изнутри веры


-- Plan for 12326 rows in db
--Unique  (cost=20.97..20.98 rows=1 width=516) (actual time=0.051..0.053 rows=1 loops=1)
--  ->  Sort  (cost=20.97..20.98 rows=1 width=516) (actual time=0.051..0.052 rows=11 loops=1)
--        Sort Key: film.title
--        Sort Method: quicksort  Memory: 25kB
--        ->  Nested Loop  (cost=0.29..20.96 rows=1 width=516) (actual time=0.031..0.043 rows=11 loops=1)
--              ->  Nested Loop  (cost=0.14..19.92 rows=1 width=524) (actual time=0.021..0.022 rows=1 loops=1)
--                    ->  Seq Scan on genre  (cost=0.00..11.75 rows=1 width=8) (actual time=0.011..0.012 rows=1 loops=1)
--                          Filter: ((title)::text = 'Комедия'::text)
--                          Rows Removed by Filter: 10
--                    ->  Index Scan using idx_films_to_genre_idx on film  (cost=0.14..8.16 rows=1 width=532) (actual time=0.007..0.007 rows=1 loops=1)
--                          Index Cond: (genre_id = genre.id)
--              ->  Index Scan using idx_seance_to_film_idx on seance  (cost=0.15..0.95 rows=9 width=8) (actual time=0.010..0.021 rows=11 loops=1)
--                    Index Cond: (film_id = film.id)
--                    Filter: (date(date_start) < CURRENT_TIMESTAMP)
--                    Rows Removed by Filter: 17
--Planning Time: 0.201 ms
--Execution Time: 0.080 ms

-- Plan for 10058217 rows in db
-- Unique  (cost=156.18..156.35 rows=33 width=44) (actual time=4.971..5.399 rows=226 loops=1)
--   ->  Sort  (cost=156.18..156.26 rows=33 width=44) (actual time=4.968..5.114 rows=1067 loops=1)
--         Sort Key: film.title
--         Sort Method: quicksort  Memory: 154kB
--         ->  Nested Loop  (cost=6.40..155.35 rows=33 width=44) (actual time=0.076..3.526 rows=1067 loops=1)
--               ->  Nested Loop  (cost=6.12..142.20 rows=19 width=52) (actual time=0.063..0.344 rows=226 loops=1)
--                     ->  Seq Scan on genre  (cost=0.00..11.75 rows=1 width=8) (actual time=0.012..0.017 rows=1 loops=1)
--                           Filter: ((title)::text = 'Комедия'::text)
--                           Rows Removed by Filter: 10
--                     ->  Bitmap Heap Scan on film  (cost=6.12..128.08 rows=237 width=60) (actual time=0.046..0.263 rows=226 loops=1)
--                           Recheck Cond: (genre_id = genre.id)
--                           Heap Blocks: exact=109
--                           ->  Bitmap Index Scan on idx_films_to_genre_idx  (cost=0.00..6.06 rows=237 width=0) (actual time=0.026..0.026 rows=226 loops=1)
--                                 Index Cond: (genre_id = genre.id)
--               ->  Index Scan using idx_seance_to_film_idx on seance  (cost=0.29..0.67 rows=2 width=8) (actual time=0.004..0.013 rows=5 loops=226)
--                     Index Cond: (film_id = film.id)
--                     Filter: (date(date_start) > CURRENT_TIMESTAMP)
--                     Rows Removed by Filter: 1
-- Planning Time: 0.398 ms
-- Execution Time: 5.491 ms

-- After tuning
-- HashAggregate  (cost=296.66..300.87 rows=421 width=44) (actual time=3.394..3.469 rows=226 loops=1)
--   Group Key: film.title
--   ->  Nested Loop  (cost=6.40..295.61 rows=421 width=44) (actual time=0.112..2.756 rows=1067 loops=1)
--         ->  Nested Loop  (cost=6.12..131.59 rows=237 width=52) (actual time=0.092..0.372 rows=226 loops=1)
--               ->  Seq Scan on genre  (cost=0.00..1.14 rows=1 width=8) (actual time=0.018..0.022 rows=1 loops=1)
--                     Filter: ((title)::text = 'Комедия'::text)
--                     Rows Removed by Filter: 10
--               ->  Bitmap Heap Scan on film  (cost=6.12..128.08 rows=237 width=60) (actual time=0.065..0.270 rows=226 loops=1)
--                     Recheck Cond: (genre_id = genre.id)
--                     Heap Blocks: exact=109
--                     ->  Bitmap Index Scan on idx_films_to_genre_idx  (cost=0.00..6.06 rows=237 width=0) (actual time=0.039..0.040 rows=226 loops=1)
--                           Index Cond: (genre_id = genre.id)
--         ->  Index Scan using idx_seance_to_film_idx on seance  (cost=0.29..0.67 rows=2 width=8) (actual time=0.004..0.009 rows=5 loops=226)
--               Index Cond: (film_id = film.id)
--               Filter: (date(date_start) > CURRENT_TIMESTAMP)
--               Rows Removed by Filter: 1
-- Planning Time: 0.744 ms
-- Execution Time: 3.627 ms


-- ########################
-- Ближайшие 10 фильмов
select distinct film.title
from test_db.film
         left join test_db.seance on seance.film_id=film.id
    and date(seance.date_start) > (CURRENT_TIMESTAMP)
limit 10;

-- Момент могилы в глубине
-- Мир легкости умирающей
-- Вены вскрытой нежности
-- Пепел вечности в глубине
-- Боль бессмыслицы первой
-- Ложь гневности после
-- Отражение нежности умирающей
-- Боль крови раскрытой
-- Агония смерти вчерашней
-- Рассвет вскрытой вечности

-- Plan for 12326 rows in db
-- Limit  (cost=0.29..5.77 rows=10 width=524) (actual time=0.041..0.272 rows=10 loops=1)
--   ->  Group  (cost=0.29..71.54 rows=130 width=524) (actual time=0.039..0.266 rows=10 loops=1)
--         Group Key: film.id
--         ->  Merge Left Join  (cost=0.29..71.22 rows=130 width=524) (actual time=0.037..0.247 rows=69 loops=1)
--               Merge Cond: (film.id = seance.film_id)
--               ->  Index Scan using idx_film_primary on film  (cost=0.14..50.09 rows=130 width=524) (actual time=0.016..0.022 rows=10 loops=1)
--               ->  Index Scan using idx_seance_to_film_idx on seance  (cost=0.14..20.06 rows=59 width=8) (actual time=0.015..0.202 rows=69 loops=1)
--                     Filter: (date(date_start) > CURRENT_TIMESTAMP)
--                     Rows Removed by Filter: 91
-- Planning Time: 0.270 ms
-- Execution Time: 0.320 ms

-- Plan for 10058217 rows in db
-- Limit  (cost=0.57..4.13 rows=10 width=52) (actual time=0.039..0.220 rows=10 loops=1)
--   ->  Group  (cost=0.57..931.07 rows=2610 width=52) (actual time=0.038..0.213 rows=10 loops=1)
--         Group Key: film.id
--         ->  Merge Left Join  (cost=0.57..919.48 rows=4635 width=52) (actual time=0.034..0.195 rows=69 loops=1)
--               Merge Cond: (film.id = seance.film_id)
--               ->  Index Scan using idx_film_primary on film  (cost=0.28..201.91 rows=2610 width=52) (actual time=0.018..0.025 rows=10 loops=1)
--               ->  Index Scan using idx_seance_to_film_idx on seance  (cost=0.29..653.11 rows=4635 width=8) (actual time=0.013..0.139 rows=69 loops=1)
--                     Filter: (date(date_start) > CURRENT_TIMESTAMP)
--                     Rows Removed by Filter: 91
-- Planning Time: 0.404 ms
-- Execution Time: 0.275 ms

-- After tuning
-- Limit  (cost=0.57..4.13 rows=10 width=52) (actual time=0.044..0.160 rows=10 loops=1)
--   ->  Group  (cost=0.57..931.07 rows=2610 width=52) (actual time=0.043..0.155 rows=10 loops=1)
--         Group Key: film.id
--         ->  Merge Left Join  (cost=0.57..919.48 rows=4635 width=52) (actual time=0.040..0.140 rows=69 loops=1)
--               Merge Cond: (film.id = seance.film_id)
--               ->  Index Scan using idx_film_primary on film  (cost=0.28..201.91 rows=2610 width=52) (actual time=0.017..0.017 rows=10 loops=1)
--               ->  Index Scan using idx_seance_to_film_idx on seance  (cost=0.29..653.11 rows=4635 width=8) (actual time=0.018..0.096 rows=69 loops=1)
--                     Filter: (date(date_start) > CURRENT_TIMESTAMP)
--                     Rows Removed by Filter: 91
-- Planning Time: 0.483 ms
-- Execution Time: 0.211 ms


-- ########################
-- Найти фильм по слову в названии или аннотации

select film.title, film.annotation
from test_db.film
where title ilike '%смерти%' or annotation ilike '%смерти%';

-- result for 12326 rows in db
-- Рассвет вскрытой вечности	Данный фильм рассказывает о привязонности и смерти, смысловая подача такая, что фильм ожидает на провал. В общем смерти не избежать.
-- Агония смерти вчерашней	    Данный фильм рассказывает о бездейственности и боли, смысловая подача такая, что фильм ожидает на успех. В общем надежды не избежать.


-- Plan for 12326 rows in db
-- Seq Scan on film  (cost=0.00..11.95 rows=1 width=548) (actual time=0.031..0.055 rows=2 loops=1)
--   Filter: (((title)::text ~~* '%смерти%'::text) OR (annotation ~~* '%смерти%'::text))
--   Rows Removed by Filter: 8
-- Planning Time: 0.074 ms
-- Execution Time: 0.072 ms

-- Plan for 10058217 rows in db
-- Seq Scan on film  (cost=0.00..158.15 rows=624 width=301) (actual time=0.041..9.522 rows=489 loops=1)
--   Filter: (((title)::text ~~* '%смерти%'::text) OR (annotation ~~* '%смерти%'::text))
--   Rows Removed by Filter: 2121
-- Planning Time: 0.630 ms
-- Execution Time: 9.588 ms

-- After tuning
-- Seq Scan on film  (cost=0.00..158.15 rows=624 width=301) (actual time=0.036..7.093 rows=489 loops=1)
--   Filter: (((title)::text ~~* '%смерти%'::text) OR (annotation ~~* '%смерти%'::text))
--   Rows Removed by Filter: 2121
-- Planning Time: 0.505 ms
-- Execution Time: 7.160 ms
-- ## создание триграммов не помогло, хоть и поиск по title ускорился, но поле annotation не использует индекс, в итоге планировщик не использует индесы


-- ########################
-- Найти название фильма, описани, время начала сеанса и количество билетов которые можно купить на ближайшие 3 часа
select
       film.title, film.annotation, seance.date_start,
       (select hall.seats from test_db.hall where hall.id = seance.hall_id) - count(ticket.id)
from test_db.film
         left join test_db.seance on seance.film_id = film.id
         left join test_db.hall on hall.id = seance.hall_id
         left join test_db.ticket on ticket.seance_id = seance.id
where date(seance.date_start) between (current_timestamp) and (current_timestamp + interval '6 hours')
group by seance.id, film.id;

-- Рассвет вскрытой вечности	Данный фильм рассказывает о привязонности и смерти, смысловая подача такая, что фильм ожидает на провал. В общем смерти не избежать.	2019-05-10 06:00:00.000000	84
-- Агония смерти вчерашней	Данный фильм рассказывает о бездейственности и боли, смысловая подача такая, что фильм ожидает на успех. В общем надежды не избежать.	2019-05-10 18:00:00.000000	82
-- Отражение нежности умирающей	Данный фильм рассказывает о игры и фантазии, смысловая подача такая, что фильм возможно получит на нейстральную оценку. В общем бездейственности не избежать.	2019-05-10 12:00:00.000000	91
-- Боль бессмыслицы первой	Данный фильм рассказывает о ненависти и игры, смысловая подача такая, что фильм ожидает на провал. В общем безмятежности не избежать.	2019-05-10 00:00:00.000000	78
-- Момент могилы в глубине	Данный фильм рассказывает о бессмыслицы и бесконечности, смысловая подача такая, что фильм явно не хочет на провал. В общем легкости не избежать.	2019-05-10 12:00:00.000000	66
-- Пепел вечности в глубине	Данный фильм рассказывает о мечты и преданности, смысловая подача такая, что фильм ожидает на нейстральную оценку. В общем апатии не избежать.	2019-05-10 15:00:00.000000	75
-- Пепел вечности в глубине	Данный фильм рассказывает о мечты и преданности, смысловая подача такая, что фильм ожидает на нейстральную оценку. В общем апатии не избежать.	2019-05-10 00:00:00.000000	79
-- Боль бессмыслицы первой	Данный фильм рассказывает о ненависти и игры, смысловая подача такая, что фильм ожидает на провал. В общем безмятежности не избежать.	2019-05-10 06:00:00.000000	72
-- Ложь гневности после	Данный фильм рассказывает о фантазии и крови, смысловая подача такая, что фильм ожидает на провал. В общем глупости не избежать.	2019-05-10 15:00:00.000000	73
-- Вены вскрытой нежности	Данный фильм рассказывает о привязонности и страсти, смысловая подача такая, что фильм явно не хочет на успех. В общем ярости не избежать.	2019-05-10 12:00:00.000000	75
-- ...

-- Plan for 12326 rows in db
-- Limit  (cost=25.47..107.25 rows=10 width=580) (actual time=3.890..3.912 rows=10 loops=1)
--   ->  HashAggregate  (cost=25.47..507.95 rows=59 width=580) (actual time=3.889..3.909 rows=10 loops=1)
--         Group Key: seance.id, film.id
--         ->  Nested Loop Left Join  (cost=0.43..25.03 rows=59 width=588) (actual time=0.043..2.542 rows=4595 loops=1)
--               ->  Nested Loop  (cost=0.14..15.12 rows=1 width=580) (actual time=0.033..0.372 rows=77 loops=1)
--                     ->  Seq Scan on seance  (cost=0.00..6.84 rows=1 width=32) (actual time=0.024..0.133 rows=77 loops=1)
--                           Filter: ((date(date_start) >= CURRENT_TIMESTAMP) AND (date(date_start) <= (CURRENT_TIMESTAMP + '06:00:00'::interval)))
--                           Rows Removed by Filter: 99
--                     ->  Index Scan using idx_film_primary on film  (cost=0.14..8.16 rows=1 width=556) (actual time=0.002..0.002 rows=1 loops=77)
--                           Index Cond: (id = seance.film_id)
--               ->  Index Scan using idx_ticket_to_seance_idx on ticket  (cost=0.29..9.32 rows=59 width=16) (actual time=0.004..0.017 rows=60 loops=77)
--                     Index Cond: (seance_id = seance.id)
--         SubPlan 1
--           ->  Index Scan using idx_hall_primary on hall  (cost=0.15..8.17 rows=1 width=4) (actual time=0.002..0.002 rows=1 loops=10)
--                 Index Cond: (id = seance.hall_id)
-- Planning Time: 0.474 ms
-- Execution Time: 4.000 ms

-- Plan for 10058217 rows in db
-- Limit  (cost=1408.73..1490.50 rows=10 width=333) (actual time=290.708..290.741 rows=10 loops=1)
--   ->  HashAggregate  (cost=1408.73..35435.30 rows=4161 width=333) (actual time=290.707..290.734 rows=10 loops=1)
--         Group Key: seance.id, film.id
--         ->  Nested Loop Left Join  (cost=178.15..1377.52 rows=4161 width=341) (actual time=4.618..117.162 rows=140496 loops=1)
--               ->  Hash Join  (cost=177.72..676.27 rows=70 width=333) (actual time=4.597..15.387 rows=2365 loops=1)
--                     Hash Cond: (seance.film_id = film.id)
--                     ->  Seq Scan on seance  (cost=0.00..498.36 rows=70 width=32) (actual time=0.052..8.455 rows=2365 loops=1)
--                           Filter: ((date(date_start) >= CURRENT_TIMESTAMP) AND (date(date_start) <= (CURRENT_TIMESTAMP + '06:00:00'::interval)))
--                           Rows Removed by Filter: 11539
--                     ->  Hash  (cost=145.10..145.10 rows=2610 width=309) (actual time=4.527..4.527 rows=2610 loops=1)
--                           Buckets: 4096  Batches: 1  Memory Usage: 918kB
--                           ->  Seq Scan on film  (cost=0.00..145.10 rows=2610 width=309) (actual time=0.015..1.740 rows=2610 loops=1)
--               ->  Index Scan using idx_ticket_to_seance_idx on ticket  (cost=0.42..9.42 rows=60 width=16) (actual time=0.006..0.020 rows=59 loops=2365)
--                     Index Cond: (seance_id = seance.id)
--         SubPlan 1
--           ->  Index Scan using idx_hall_primary on hall  (cost=0.15..8.17 rows=1 width=4) (actual time=0.002..0.002 rows=1 loops=10)
--                 Index Cond: (id = seance.hall_id)
-- Planning Time: 1.233 ms
-- Execution Time: 291.356 ms

-- After tuning
-- Limit  (cost=1408.73..1490.50 rows=10 width=333) (actual time=127.856..127.878 rows=10 loops=1)
--   ->  HashAggregate  (cost=1408.73..35435.30 rows=4161 width=333) (actual time=127.855..127.874 rows=10 loops=1)
--         Group Key: seance.id, film.id
--         ->  Nested Loop Left Join  (cost=178.15..1377.52 rows=4161 width=341) (actual time=3.122..83.334 rows=140496 loops=1)
--               ->  Hash Join  (cost=177.72..676.27 rows=70 width=333) (actual time=3.104..12.759 rows=2365 loops=1)
--                     Hash Cond: (seance.film_id = film.id)
--                     ->  Seq Scan on seance  (cost=0.00..498.36 rows=70 width=32) (actual time=0.040..7.377 rows=2365 loops=1)
--                           Filter: ((date(date_start) >= CURRENT_TIMESTAMP) AND (date(date_start) <= (CURRENT_TIMESTAMP + '06:00:00'::interval)))
--                           Rows Removed by Filter: 11539
--                     ->  Hash  (cost=145.10..145.10 rows=2610 width=309) (actual time=3.050..3.050 rows=2610 loops=1)
--                           Buckets: 4096  Batches: 1  Memory Usage: 918kB
--                           ->  Seq Scan on film  (cost=0.00..145.10 rows=2610 width=309) (actual time=0.012..0.957 rows=2610 loops=1)
--               ->  Index Scan using idx_ticket_to_seance_idx on ticket  (cost=0.42..9.42 rows=60 width=16) (actual time=0.005..0.018 rows=59 loops=2365)
--                     Index Cond: (seance_id = seance.id)
--         SubPlan 1
--           ->  Index Scan using idx_hall_primary on hall  (cost=0.15..8.17 rows=1 width=4) (actual time=0.002..0.002 rows=1 loops=10)
--                 Index Cond: (id = seance.hall_id)
-- Planning Time: 0.912 ms
-- Execution Time: 128.373 ms



-- ########################
-- Показать топ фильмов по продажам

SELECT f.title, sum(t.price)
FROM
    test_db.seance as s
        LEFT JOIN test_db.ticket t on t.seance_id = s.id
        LEFT JOIN test_db.film f on f.id = s.film_id
GROUP BY s.id, f.id
order by sum(t.price) desc
limit 5;

-- Боль бессмыслицы первой	4542972
-- Вены вскрытой нежности	4380709
-- Рассвет вскрытой вечности	4301006
-- Пепел вечности в глубине	4296068
-- Момент могилы в глубине	4270175

-- Plan for 12326 rows in db
-- Limit  (cost=3884.96..3884.97 rows=5 width=564) (actual time=16.016..16.020 rows=5 loops=1)
--   ->  Sort  (cost=3884.96..3910.98 rows=10410 width=564) (actual time=16.015..16.015 rows=5 loops=1)
--         Sort Key: (sum(t.price)) DESC
--         Sort Method: top-N heapsort  Memory: 26kB
--         ->  GroupAggregate  (cost=3477.83..3712.05 rows=10410 width=564) (actual time=13.444..15.938 rows=176 loops=1)
--               Group Key: s.id, f.id
--               ->  Sort  (cost=3477.83..3503.85 rows=10410 width=540) (actual time=13.416..14.179 rows=10410 loops=1)
--                     Sort Key: s.id, f.id
--                     Sort Method: quicksort  Memory: 1848kB
--                     ->  Hash Left Join  (cost=18.89..256.18 rows=10410 width=540) (actual time=0.322..10.007 rows=10410 loops=1)
--                           Hash Cond: (s.film_id = f.id)
--                           ->  Hash Right Join  (cost=5.96..215.04 rows=10410 width=24) (actual time=0.291..6.413 rows=10410 loops=1)
--                                 Hash Cond: (t.seance_id = s.id)
--                                 ->  Seq Scan on ticket t  (cost=0.00..181.10 rows=10410 width=16) (actual time=0.015..1.740 rows=10410 loops=1)
--                                 ->  Hash  (cost=3.76..3.76 rows=176 width=16) (actual time=0.267..0.267 rows=176 loops=1)
--                                       Buckets: 1024  Batches: 1  Memory Usage: 17kB
--                                       ->  Seq Scan on seance s  (cost=0.00..3.76 rows=176 width=16) (actual time=0.018..0.061 rows=176 loops=1)
--                           ->  Hash  (cost=11.30..11.30 rows=130 width=524) (actual time=0.019..0.019 rows=10 loops=1)
--                                 Buckets: 1024  Batches: 1  Memory Usage: 9kB
--                                 ->  Seq Scan on film f  (cost=0.00..11.30 rows=130 width=524) (actual time=0.010..0.013 rows=10 loops=1)
-- Planning Time: 0.463 ms
-- Execution Time: 16.092 ms

-- Plan for 10058217 rows in db
-- Limit  (cost=200641.93..200641.94 rows=5 width=92) (actual time=3324.121..3324.126 rows=5 loops=1)
--   ->  Sort  (cost=200641.93..202708.06 rows=826455 width=92) (actual time=3324.121..3324.122 rows=5 loops=1)
--         Sort Key: (sum(t.price)) DESC
--         Sort Method: top-N heapsort  Memory: 26kB
--         ->  GroupAggregate  (cost=168319.57..186914.80 rows=826455 width=92) (actual time=2614.585..3317.127 rows=13904 loops=1)
--               Group Key: s.id, f.id
--               ->  Sort  (cost=168319.57..170385.70 rows=826455 width=68) (actual time=2614.556..2998.323 rows=826455 loops=1)
--                     Sort Key: s.id, f.id
--                     Sort Method: external merge  Disk: 66776kB
--                     ->  Hash Left Join  (cost=606.57..19291.19 rows=826455 width=68) (actual time=9.552..1497.902 rows=826455 loops=1)
--                           Hash Cond: (s.film_id = f.id)
--                           ->  Hash Right Join  (cost=428.84..16940.49 rows=826455 width=24) (actual time=7.212..959.143 rows=826455 loops=1)
--                                 Hash Cond: (t.seance_id = s.id)
--                                 ->  Seq Scan on ticket t  (cost=0.00..14341.55 rows=826455 width=16) (actual time=0.022..282.610 rows=826455 loops=1)
--                                 ->  Hash  (cost=255.04..255.04 rows=13904 width=16) (actual time=7.171..7.172 rows=13904 loops=1)
--                                       Buckets: 16384  Batches: 1  Memory Usage: 780kB
--                                       ->  Seq Scan on seance s  (cost=0.00..255.04 rows=13904 width=16) (actual time=0.030..3.132 rows=13904 loops=1)
--                           ->  Hash  (cost=145.10..145.10 rows=2610 width=52) (actual time=2.286..2.286 rows=2610 loops=1)
--                                 Buckets: 4096  Batches: 1  Memory Usage: 258kB
--                                 ->  Seq Scan on film f  (cost=0.00..145.10 rows=2610 width=52) (actual time=0.012..1.033 rows=2610 loops=1)
-- Planning Time: 0.449 ms
-- Execution Time: 3355.366 ms

-- After tuning
-- Limit  (cost=202708.06..202708.08 rows=5 width=92) (actual time=1591.006..1591.011 rows=5 loops=1)
--   ->  Sort  (cost=202708.06..204774.20 rows=826455 width=92) (actual time=1591.005..1591.005 rows=5 loops=1)
--         Sort Key: (sum((t.price)::numeric)) DESC
--         Sort Method: top-N heapsort  Memory: 26kB
--         ->  GroupAggregate  (cost=168319.57..188980.94 rows=826455 width=92) (actual time=1226.490..1582.900 rows=13904 loops=1)
--               Group Key: s.id, f.id
--               ->  Sort  (cost=168319.57..170385.70 rows=826455 width=68) (actual time=1226.453..1369.900 rows=826455 loops=1)
--                     Sort Key: s.id, f.id
--                     Sort Method: external merge  Disk: 66776kB
--                     ->  Hash Left Join  (cost=606.57..19291.19 rows=826455 width=68) (actual time=9.919..648.789 rows=826455 loops=1)
--                           Hash Cond: (s.film_id = f.id)
--                           ->  Hash Right Join  (cost=428.84..16940.49 rows=826455 width=24) (actual time=8.369..404.969 rows=826455 loops=1)
--                                 Hash Cond: (t.seance_id = s.id)
--                                 ->  Seq Scan on ticket t  (cost=0.00..14341.55 rows=826455 width=16) (actual time=0.014..123.839 rows=826455 loops=1)
--                                 ->  Hash  (cost=255.04..255.04 rows=13904 width=16) (actual time=8.341..8.342 rows=13904 loops=1)
--                                       Buckets: 16384  Batches: 1  Memory Usage: 780kB
--                                       ->  Seq Scan on seance s  (cost=0.00..255.04 rows=13904 width=16) (actual time=0.013..5.325 rows=13904 loops=1)
--                           ->  Hash  (cost=145.10..145.10 rows=2610 width=52) (actual time=1.512..1.512 rows=2610 loops=1)
--                                 Buckets: 4096  Batches: 1  Memory Usage: 258kB
--                                 ->  Seq Scan on film f  (cost=0.00..145.10 rows=2610 width=52) (actual time=0.007..0.717 rows=2610 loops=1)
-- Planning Time: 0.693 ms
-- Execution Time: 1616.253 ms

-- ####################################
-- План улучшений
-- - Индексация поля seance.date_start
-- CREATE INDEX seance_date_start_idx ON test_db.seance (date_start);
-- - Индексация текстовых полей film.title и film.anotation
-- CREATE EXTENSION pg_trgm;
-- CREATE INDEX trgm_idx_film_title ON test_db.film USING gin (title gin_trgm_ops);
-- CREATE INDEX trgm_idx_film_annotation ON test_db.film USING gin (annotation gin_trgm_ops);

-- Отсортированный список (15 значений) самых больших по размеру объектов БД (таблицы, включая индексы, сами индексы)
-- SELECT table_schema, table_name, row_estimate
--      , pg_size_pretty(total_bytes) AS total
--      , pg_size_pretty(index_bytes) AS INDEX
--      , pg_size_pretty(table_bytes) AS TABLE
-- FROM (
--          SELECT *, total_bytes - index_bytes - COALESCE(toast_bytes, 0) AS table_bytes
--          FROM (
--                   SELECT c.oid
--                        , nspname                               AS table_schema
--                        , relname                               AS TABLE_NAME
--                        , c.reltuples                           AS row_estimate
--                        , pg_total_relation_size(c.oid)         AS total_bytes
--                        , pg_indexes_size(c.oid)                AS index_bytes
--                        , pg_total_relation_size(reltoastrelid) AS toast_bytes
--                   FROM pg_class c
--                            LEFT JOIN pg_namespace n ON n.oid = c.relnamespace
--                   WHERE relkind = 'r'
--               ) a
--      ) a
-- order by total_bytes desc

-- test_db	    ticket	        826455	132 MB	84 MB	48 MB
-- test_db	    seance	        13904	2424 kB	1472 kB	952 kB
-- pg_catalog	pg_depend	    7707	1624 kB	1064 kB	560 kB
-- test_db	    film	        2610	1192 kB	208 kB	976 kB
-- test_db	    film_attribute	5014	1072 kB	704 kB	368 kB
-- pg_catalog	pg_proc	        2961	1016 kB	368 kB	640 kB
-- pg_catalog	pg_attribute	2838	904 kB	344 kB	560 kB
-- test_db	    attribute_value	5014	768 kB	128 kB	632 kB
-- pg_catalog	pg_rewrite	    121	    744 kB	32 kB	128 kB
-- pg_catalog	pg_description	4678	544 kB	184 kB	352 kB
-- pg_catalog	pg_collation	967	    400 kB	120 kB	280 kB
-- pg_catalog	pg_statistic	440	    400 kB	40 kB	256 kB
-- test_db	    seat	        1660	296 kB	184 kB	112 kB
-- pg_catalog	pg_class	    392	    264 kB	128 kB	136 kB
-- pg_catalog	pg_operator	    788	    240 kB	88 kB	152 kB

-- Индексы отсортированные по их использованию
-- select * from pg_statio_user_indexes order by idx_blks_read desc;
-- 19007	19061	test_db	ticket	        idx_uniq_seance_seat	    3166	938614
-- 19007	19060	test_db	ticket	        idx_ticket_to_seat_idx	    3141	2425589
-- 19007	19046	test_db	ticket	        idx_ticket_primary	        2268	986954
-- 19007	19059	test_db	ticket	        idx_ticket_to_seance_idx	2248	1697820
-- 18997	19055	test_db	seance	        idx_seance_to_film_idx	    55	    106808
-- 18997	19056	test_db	seance	        idx_seance_to_hall_idx	    51	    30888
-- 18997	19042	test_db	seance	        idx_seance_primary	        40	    1672177
-- 18982	19053	test_db	film_attribute	idx_attribute_to_type_idx	23	    10997
-- 18982	19052	test_db	film_attribute	idx_attribute_to_name_idx	22	    10258
-- 18982	19036	test_db	film_attribute	idx_film_attr_primary	    16	    9887
-- 18965	19032	test_db	attribute_value	idx_attr_value_primary	    16	    19738
-- 18982	19054	test_db	film_attribute	idx_films_attributes_idx	16	    76385
-- 18982	19051	test_db	film_attribute	idx_attribute_to_value_idx	16	    9887
-- 18974	19050	test_db	film	        idx_films_to_genre_idx	    11	    4883
-- 18997	19131	test_db	seance	        seance_date_start_idx	    10	    28
-- 18974	19034	test_db	film	        idx_film_primary	        10	    40386
-- 19002	19058	test_db	seat	        idx_uniq_seat	            9	    3503
-- 19002	19057	test_db	seat	        idx_seats_to_hall_idx	    7	    39866
-- 19002	19044	test_db	seat	        idx_seat_primary	        7	    1657784
-- 18960	19049	test_db	attribute_type	idx_attr_type_title_unique	2	    11
-- 18955	19028	test_db	attribute_name	idx_attr_name_primary	    2	    5148
-- 18960	19030	test_db	attribute_type	idx_attr_type_primary	    2	    5142
-- 18987	19038	test_db	genre	        idx_genre_primary	        2	    2631
-- 18992	19040	test_db	hall	        idx_hall_primary	        2	    16837
-- 18955	19048	test_db	attribute_name	idx_attr_name_title_unique	2	    17
-- 18974	19217	test_db	film	        trgm_idx_film_title	        0	    0
-- 18974	19218	test_db	film	        trgm_idx_film_annotation	0	    0

