 --
 --
 --
 --Выбор по таблицам в 10 000 строк
 --
 --
 
 --Выбор фильмов по промежутку даты (простой запрос без индексов): 
--Узкий выбор с промежутком в 1 мес
explain analyze select * from movies where creation_date between '2018-06-08 15:24:19' and '2018-07-08 15:24:19'

Seq Scan on movies  (cost=0.00..2150.00 rows=89 width=1326) (actual time=0.037..4.959 rows=83 loops=1)
  Filter: ((creation_date >= '2018-06-08 15:24:19'::timestamp without time zone) AND (creation_date <= '2018-07-08 15:24:19'::timestamp without time zone))
  Rows Removed by Filter: 9917
Planning Time: 0.961 ms
Execution Time: 5.012 ms

>> 83 rows


--широкий выбор с промежутком в 9 лет
explain analyze select * from movies where creation_date between '2014-06-08 15:24:19' and '2022-07-08 15:24:19'

Seq Scan on movies  (cost=0.00..2150.00 rows=8116 width=1326) (actual time=0.019..7.140 rows=8111 loops=1)
  Filter: ((creation_date >= '2014-06-08 15:24:19'::timestamp without time zone) AND (creation_date <= '2022-07-08 15:24:19'::timestamp without time zone))
  Rows Removed by Filter: 1889
Planning Time: 0.130 ms
Execution Time: 7.711 ms

>>8011 rows



 --Выбор фильмов по промежутку даты (простой запрос с индексами (240Кб)): 
--Узкий выбор с промежутком в 1 мес
explain analyze select * from movies where creation_date between '2018-06-08 15:24:19' and '2018-07-08 15:24:19'

Bitmap Heap Scan on movies  (cost=5.20..303.16 rows=89 width=1326) (actual time=0.063..0.214 rows=83 loops=1)
  Recheck Cond: ((creation_date >= '2018-06-08 15:24:19'::timestamp without time zone) AND (creation_date <= '2018-07-08 15:24:19'::timestamp without time zone))
  Heap Blocks: exact=83
  ->  Bitmap Index Scan on movies_creation_date_idx  (cost=0.00..5.17 rows=89 width=0) (actual time=0.037..0.037 rows=83 loops=1)
        Index Cond: ((creation_date >= '2018-06-08 15:24:19'::timestamp without time zone) AND (creation_date <= '2018-07-08 15:24:19'::timestamp without time zone))
Planning Time: 1.471 ms
Execution Time: 0.270 ms

>> 83 rows


 --Выбор фильмов по промежутку даты (простой запрос с индексами (240Кб)): 
--Узкий выбор с промежутком в 1 мес

Seq Scan on movies  (cost=0.00..2150.00 rows=7131 width=1326) (actual time=0.024..7.065 rows=7123 loops=1)
  Filter: ((creation_date >= '2014-06-08 15:24:19'::timestamp without time zone) AND (creation_date <= '2021-07-08 15:24:19'::timestamp without time zone))
  Rows Removed by Filter: 2877
Planning Time: 0.119 ms
Execution Time: 7.608 ms


--Итог: 
	--на узких запросах индексы отрабатывают корректно, прирост скорости в 20 раз
	--на запросах с широким диапазоном > 20% строк выборки срабатывает Seq Scan, скорость работы упала примерно в таком же диапазоне как и  с запросом без индексов
	--в данном случае индекс повысит производительность. Добавляем.
	




 --Выбор фильмов по промежутку даты (сложный запрос с JOIN c индексом на movies.created_at): 
--Узкий выбор с промежутком в 1 мес

explain analyze
select 
	m.name as movie_name,
	a.name as actor_name
from movies m
left join actors_in_movies act on act.movie_id = m.id 
left join actors a on a.id = act.actor_id 
where creation_date 
between '2014-06-08 15:24:19' and '2014-07-08 15:24:19'


Nested Loop Left Join  (cost=257.52..511.12 rows=74 width=200) (actual time=0.373..5.018 rows=131 loops=1)
  ->  Hash Right Join  (cost=257.24..438.50 rows=74 width=104) (actual time=0.350..4.598 rows=131 loops=1)
        Hash Cond: (act.movie_id = m.id)
        ->  Seq Scan on actors_in_movies act  (cost=0.00..155.00 rows=10000 width=8) (actual time=0.023..1.917 rows=10000 loops=1)
        ->  Hash  (cost=256.31..256.31 rows=74 width=104) (actual time=0.307..0.308 rows=68 loops=1)
              Buckets: 1024  Batches: 1  Memory Usage: 18kB
              ->  Bitmap Heap Scan on movies m  (cost=5.04..256.31 rows=74 width=104) (actual time=0.067..0.250 rows=68 loops=1)
                    Recheck Cond: ((creation_date >= '2014-06-08 15:24:19'::timestamp without time zone) AND (creation_date <= '2014-07-08 15:24:19'::timestamp without time zone))
                    Heap Blocks: exact=67
                    ->  Bitmap Index Scan on movies_creation_date_idx  (cost=0.00..5.03 rows=74 width=0) (actual time=0.035..0.035 rows=68 loops=1)
                          Index Cond: ((creation_date >= '2014-06-08 15:24:19'::timestamp without time zone) AND (creation_date <= '2014-07-08 15:24:19'::timestamp without time zone))
  ->  Index Scan using actors_pk on actors a  (cost=0.29..0.98 rows=1 width=104) (actual time=0.002..0.002 rows=1 loops=131)
        Index Cond: (id = act.actor_id)
Planning Time: 0.707 ms
Execution Time: 5.124 ms



 --Выбор фильмов по промежутку даты (сложный запрос с JOIN c индексом на movies.created_at): 
--широкий выбор с промежутком в 9 лет

explain analyze
select 
	m.name as movie_name,
	a.name as actor_name
from movies m
left join actors_in_movies act on act.movie_id = m.id 
left join actors a on a.id = act.actor_id 
where creation_date 
between '2014-06-08 15:24:19' and '2022-07-08 15:24:19'


Merge Right Join  (cost=2979.44..3297.68 rows=8116 width=200) (actual time=18.761..23.953 rows=15455 loops=1)
  Merge Cond: (a.id = act.actor_id)
  ->  Index Scan using actors_pk on actors a  (cost=0.29..1940.29 rows=10000 width=104) (actual time=0.020..0.501 rows=1100 loops=1)
  ->  Sort  (cost=2959.71..2980.00 rows=8116 width=104) (actual time=18.683..20.319 rows=15455 loops=1)
        Sort Key: act.actor_id
        Sort Method: quicksort  Memory: 2558kB
        ->  Hash Right Join  (cost=2251.45..2432.71 rows=8116 width=104) (actual time=8.231..13.860 rows=15455 loops=1)
              Hash Cond: (act.movie_id = m.id)
              ->  Seq Scan on actors_in_movies act  (cost=0.00..155.00 rows=10000 width=8) (actual time=0.011..1.047 rows=10000 loops=1)
              ->  Hash  (cost=2150.00..2150.00 rows=8116 width=104) (actual time=8.195..8.195 rows=8111 loops=1)
                    Buckets: 8192  Batches: 1  Memory Usage: 1142kB
                    ->  Seq Scan on movies m  (cost=0.00..2150.00 rows=8116 width=104) (actual time=0.017..5.282 rows=8111 loops=1)
                          Filter: ((creation_date >= '2014-06-08 15:24:19'::timestamp without time zone) AND (creation_date <= '2022-07-08 15:24:19'::timestamp without time zone))
                          Rows Removed by Filter: 1889
Planning Time: 0.674 ms
Execution Time: 25.014 ms




 --Выбор фильмов по промежутку даты (сложный запрос с JOIN c индексом на movies.created_at и actors_in_movies.movie_id, actors_in_movies.actor_id): 
--Узкий выбор с промежутком в 1 мес

explain analyze
select 
	m.name as movie_name,
	a.name as actor_name
from movies m
left join actors_in_movies act on act.movie_id = m.id 
left join actors a on a.id = act.actor_id 
where creation_date 
between '2014-06-08 15:24:19' and '2014-07-08 15:24:19'


Nested Loop Left Join  (cost=257.52..511.12 rows=74 width=200) (actual time=0.308..4.640 rows=131 loops=1)
  ->  Hash Right Join  (cost=257.24..438.50 rows=74 width=104) (actual time=0.291..4.246 rows=131 loops=1)
        Hash Cond: (act.movie_id = m.id)
        ->  Seq Scan on actors_in_movies act  (cost=0.00..155.00 rows=10000 width=8) (actual time=0.018..1.819 rows=10000 loops=1)
        ->  Hash  (cost=256.31..256.31 rows=74 width=104) (actual time=0.258..0.259 rows=68 loops=1)
              Buckets: 1024  Batches: 1  Memory Usage: 18kB
              ->  Bitmap Heap Scan on movies m  (cost=5.04..256.31 rows=74 width=104) (actual time=0.059..0.212 rows=68 loops=1)
                    Recheck Cond	: ((creation_date >= '2014-06-08 15:24:19'::timestamp without time zone) AND (creation_date <= '2014-07-08 15:24:19'::timestamp without time zone))
                    Heap Blocks: exact=67
                    ->  Bitmap Index Scan on movies_creation_date_idx  (cost=0.00..5.03 rows=74 width=0) (actual time=0.036..0.036 rows=68 loops=1)
                          Index Cond: ((creation_date >= '2014-06-08 15:24:19'::timestamp without time zone) AND (creation_date <= '2014-07-08 15:24:19'::timestamp without time zone))
  ->  Index Scan using actors_pk on actors a  (cost=0.29..0.98 rows=1 width=104) (actual time=0.002..0.002 rows=1 loops=131)
        Index Cond: (id = act.actor_id)
Planning Time: 0.686 ms
Execution Time: 4.719 ms




 --Выбор фильмов по промежутку даты (сложный запрос с JOIN c индексом на movies.created_at и actors_in_movies.movie_id, actors_in_movies.actor_id): 
--широкий выбор с промежутком в 9 лет


Merge Right Join  (cost=2979.44..3297.68 rows=8116 width=200) (actual time=22.127..26.020 rows=15455 loops=1)
  Merge Cond: (a.id = act.actor_id)
  ->  Index Scan using actors_pk on actors a  (cost=0.29..1940.29 rows=10000 width=104) (actual time=0.015..0.366 rows=1100 loops=1)
  ->  Sort  (cost=2959.71..2980.00 rows=8116 width=104) (actual time=22.061..23.291 rows=15455 loops=1)
        Sort Key: act.actor_id
        Sort Method: quicksort  Memory: 2558kB
        ->  Hash Right Join  (cost=2251.45..2432.71 rows=8116 width=104) (actual time=9.557..16.387 rows=15455 loops=1)
              Hash Cond: (act.movie_id = m.id)
              ->  Seq Scan on actors_in_movies act  (cost=0.00..155.00 rows=10000 width=8) (actual time=0.013..1.180 rows=10000 loops=1)
              ->  Hash  (cost=2150.00..2150.00 rows=8116 width=104) (actual time=9.521..9.521 rows=8111 loops=1)
                    Buckets: 8192  Batches: 1  Memory Usage: 1142kB
                    ->  Seq Scan on movies m  (cost=0.00..2150.00 rows=8116 width=104) (actual time=0.013..6.149 rows=8111 loops=1)
                          Filter: ((creation_date >= '2014-06-08 15:24:19'::timestamp without time zone) AND (creation_date <= '2022-07-08 15:24:19'::timestamp without time zone))
                          Rows Removed by Filter: 1889
Planning Time: 0.675 ms
Execution Time: 26.747 ms


--
--ИТОГИ сложного запроса на 10000 строк:
--При выборке с двумя join скорость обрботки запроса с дополнительными индексами по таблице actors_in_movies дает минимальный выигрышь, маскимум 5-10% 
--Добавление индексов не обязательно, так как на перестроение индексов будет тратится в дальнейшем время и 5-10% выигранных перекроются































