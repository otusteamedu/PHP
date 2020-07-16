 --
 --
 --
 --Выбор по таблицам в 10 000 000 строк
 --
 --
 
 --Выбор фильмов по промежутку даты (простой запрос без индексов): 
--Узкий выбор с промежутком в 1 мес
explain analyze select * from movies where creation_date between '2018-06-08 15:24:19' and '2018-07-08 15:24:19'

Gather  (cost=1000.00..2072251.70 rows=87517 width=1326) (actual time=273.834..442611.852 rows=82293 loops=1)
  Workers Planned: 2
  Workers Launched: 2
  ->  Parallel Seq Scan on movies  (cost=0.00..2062500.00 rows=36465 width=1326) (actual time=222.100..442364.957 rows=27431 loops=3)
        Filter: ((creation_date >= '2018-06-08 15:24:19'::timestamp without time zone) AND (creation_date <= '2018-07-08 15:24:19'::timestamp without time zone))
        Rows Removed by Filter: 3305902
Planning Time: 1.945 ms
JIT:
  Functions: 12
  Options: Inlining true, Optimization true, Expressions true, Deforming true
  Timing: Generation 7.644 ms, Inlining 284.273 ms, Optimization 239.327 ms, Emission 136.749 ms, Total 667.993 ms
Execution Time: 442650.396 ms


--широкий выбор с промежутком в 9 лет
explain analyze select * from movies where creation_date between '2014-06-08 15:24:19' and '2022-07-08 15:24:19'

Seq Scan on movies  (cost=0.00..2150000.00 rows=8073769 width=1326) (actual time=94.702..54966.190 rows=8088608 loops=1)
  Filter: ((creation_date >= '2014-06-08 15:24:19'::timestamp without time zone) AND (creation_date <= '2022-07-08 15:24:19'::timestamp without time zone))
  Rows Removed by Filter: 1911392
Planning Time: 0.152 ms
JIT:
  Functions: 4
  Options: Inlining true, Optimization true, Expressions true, Deforming true
  Timing: Generation 2.702 ms, Inlining 8.089 ms, Optimization 56.817 ms, Emission 28.044 ms, Total 95.653 ms
Execution Time: 55578.628 ms





 --Выбор фильмов по промежутку даты (простой запрос с индексами (240Кб)): 
--Узкий выбор с промежутком в 1 мес
explain analyze select * from movies where creation_date between '2018-06-08 15:24:19' and '2018-07-08 15:24:19'

Gather  (cost=2861.48..339817.13 rows=87517 width=1326) (actual time=88.310..6075.079 rows=82293 loops=1)
  Workers Planned: 2
  Workers Launched: 2
  ->  Parallel Bitmap Heap Scan on movies  (cost=1861.48..330065.43 rows=36465 width=1326) (actual time=45.927..5959.756 rows=27431 loops=3)
        Recheck Cond: ((creation_date >= '2018-06-08 15:24:19'::timestamp without time zone) AND (creation_date <= '2018-07-08 15:24:19'::timestamp without time zone))
        Rows Removed by Index Recheck: 53860
        Heap Blocks: exact=13479 lossy=13675
        ->  Bitmap Index Scan on movies_creation_date_idx  (cost=0.00..1839.61 rows=87517 width=0) (actual time=53.436..53.437 rows=82293 loops=1)
              Index Cond: ((creation_date >= '2018-06-08 15:24:19'::timestamp without time zone) AND (creation_date <= '2018-07-08 15:24:19'::timestamp without time zone))
Planning Time: 1.407 ms
JIT:
  Functions: 12
  Options: Inlining false, Optimization false, Expressions true, Deforming true
  Timing: Generation 4.481 ms, Inlining 0.000 ms, Optimization 2.482 ms, Emission 29.906 ms, Total 36.869 ms
Execution Time: 6088.366 ms


 --Выбор фильмов по промежутку даты (простой запрос с индексами (240Кб)): 
--Широкий выбор с промежутком в 1 мес

Seq Scan on movies  (cost=0.00..2150000.00 rows=8073769 width=1326) (actual time=89.744..50751.201 rows=8088608 loops=1)
  Filter: ((creation_date >= '2014-06-08 15:24:19'::timestamp without time zone) AND (creation_date <= '2022-07-08 15:24:19'::timestamp without time zone))
  Rows Removed by Filter: 1911392
Planning Time: 0.187 ms
JIT:
  Functions: 4
  Options: Inlining true, Optimization true, Expressions true, Deforming true
  Timing: Generation 2.318 ms, Inlining 6.941 ms, Optimization 52.106 ms, Emission 29.167 ms, Total 90.532 ms
Execution Time: 51369.536 ms


--Итог: 
	--на узких запросах индексы отрабатывают корректно, прирост скорости в 500 раз
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


Merge Right Join  (cost=558391.39..560003.92 rows=78820 width=200) (actual time=4245.343..4316.753 rows=153059 loops=1)
  Merge Cond: (a.id = act.actor_id)
  ->  Index Scan using actors_pk on actors a  (cost=0.43..1926354.47 rows=10000002 width=104) (actual time=0.024..1.347 rows=1200 loops=1)
  ->  Materialize  (cost=558390.95..558785.05 rows=78820 width=104) (actual time=4016.917..4065.001 rows=153059 loops=1)
        ->  Sort  (cost=558390.95..558588.00 rows=78820 width=104) (actual time=4016.911..4043.745 rows=153059 loops=1)
              Sort Key: act.actor_id
              Sort Method: external merge  Disk: 16792kB
              ->  Hash Right Join  (cost=313848.91..547668.41 rows=78820 width=104) (actual time=438.520..3941.561 rows=153059 loops=1)
                    Hash Cond: (act.movie_id = m.id)
                    ->  Seq Scan on actors_in_movies act  (cost=0.00..138648.60 rows=8999960 width=8) (actual time=0.054..1228.914 rows=9000000 loops=1)
                    ->  Hash  (cost=311631.66..311631.66 rows=78820 width=104) (actual time=438.034..438.035 rows=82085 loops=1)
                          Buckets: 32768  Batches: 4  Memory Usage: 2968kB
                          ->  Index Scan using movies_creation_date_idx on movies m  (cost=0.43..311631.66 rows=78820 width=104) (actual time=0.063..388.766 rows=82085 loops=1)
                                Index Cond: ((creation_date >= '2014-06-08 15:24:19'::timestamp without time zone) AND (creation_date <= '2014-07-08 15:24:19'::timestamp without time zone))
Planning Time: 0.579 ms
JIT:
  Functions: 19
  Options: Inlining true, Optimization true, Expressions true, Deforming true
  Timing: Generation 3.359 ms, Inlining 10.576 ms, Optimization 142.129 ms, Emission 75.221 ms, Total 231.285 ms
Execution Time: 4328.751 ms



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


Hash Right Join  (cost=3801385.45..4390145.84 rows=8073769 width=200) (actual time=98471.834..136396.391 rows=15200809 loops=1)
  Hash Cond: (act.movie_id = m.id)
  ->  Merge Right Join  (cost=1424310.34..1582042.82 rows=8999960 width=104) (actual time=6101.521..10592.019 rows=9000000 loops=1)
        Merge Cond: (a.id = act.actor_id)
        ->  Index Scan using actors_pk on actors a  (cost=0.43..1926354.47 rows=10000002 width=104) (actual time=0.027..5.898 rows=1200 loops=1)
        ->  Materialize  (cost=1424309.90..1469309.70 rows=8999960 width=8) (actual time=6101.353..9123.336 rows=9000000 loops=1)
              ->  Sort  (cost=1424309.90..1446809.80 rows=8999960 width=8) (actual time=6101.343..7623.018 rows=9000000 loops=1)
                    Sort Key: act.actor_id
                    Sort Method: external merge  Disk: 158536kB
                    ->  Seq Scan on actors_in_movies act  (cost=0.00..138648.60 rows=8999960 width=8) (actual time=0.681..1409.519 rows=9000000 loops=1)
  ->  Hash  (cost=2150000.00..2150000.00 rows=8073769 width=104) (actual time=92369.990..92369.991 rows=8088608 loops=1)
        Buckets: 32768  Batches: 512  Memory Usage: 2372kB
        ->  Seq Scan on movies m  (cost=0.00..2150000.00 rows=8073769 width=104) (actual time=201.005..85380.556 rows=8088608 loops=1)
              Filter: ((creation_date >= '2014-06-08 15:24:19'::timestamp without time zone) AND (creation_date <= '2022-07-08 15:24:19'::timestamp without time zone))
              Rows Removed by Filter: 1911392
Planning Time: 0.852 ms
JIT:
  Functions: 19
  Options: Inlining true, Optimization true, Expressions true, Deforming true
  Timing: Generation 5.095 ms, Inlining 6.210 ms, Optimization 125.637 ms, Emission 68.800 ms, Total 205.742 ms
Execution Time: 137049.113 ms




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


Merge Right Join  (cost=558391.89..560004.43 rows=78820 width=200) (actual time=15629.233..15704.605 rows=153059 loops=1)
  Merge Cond: (a.id = act.actor_id)
  ->  Index Scan using actors_pk on actors a  (cost=0.43..1926354.47 rows=10000002 width=104) (actual time=0.028..1.490 rows=1200 loops=1)
  ->  Materialize  (cost=558391.46..558785.56 rows=78820 width=104) (actual time=15363.187..15414.490 rows=153059 loops=1)
        ->  Sort  (cost=558391.46..558588.51 rows=78820 width=104) (actual time=15363.181..15392.146 rows=153059 loops=1)
              Sort Key: act.actor_id
              Sort Method: external merge  Disk: 16792kB
              ->  Hash Right Join  (cost=313848.91..547668.92 rows=78820 width=104) (actual time=11835.990..15288.843 rows=153059 loops=1)
                    Hash Cond: (act.movie_id = m.id)
                    ->  Seq Scan on actors_in_movies act  (cost=0.00..138649.00 rows=9000000 width=8) (actual time=0.049..1206.301 rows=9000000 loops=1)
                    ->  Hash  (cost=311631.66..311631.66 rows=78820 width=104) (actual time=11835.587..11835.587 rows=82085 loops=1)
                          Buckets: 32768  Batches: 4  Memory Usage: 2968kB
                          ->  Index Scan using movies_creation_date_idx on movies m  (cost=0.43..311631.66 rows=78820 width=104) (actual time=0.782..11679.748 rows=82085 loops=1)
                                Index Cond: ((creation_date >= '2014-06-08 15:24:19'::timestamp without time zone) AND (creation_date <= '2014-07-08 15:24:19'::timestamp without time zone))
Planning Time: 1.273 ms
JIT:
  Functions: 19
  Options: Inlining true, Optimization true, Expressions true, Deforming true
  Timing: Generation 3.400 ms, Inlining 8.828 ms, Optimization 158.395 ms, Emission 98.284 ms, Total 268.906 ms
Execution Time: 15717.548 ms




 --Выбор фильмов по промежутку даты (сложный запрос с JOIN c индексом на movies.created_at и actors_in_movies.movie_id, actors_in_movies.actor_id): 
--широкий выбор с промежутком в 9 лет


Hash Right Join  (cost=3801390.76..4390151.96 rows=8073769 width=200) (actual time=95293.193..129929.062 rows=15200809 loops=1)
  Hash Cond: (act.movie_id = m.id)
  ->  Merge Right Join  (cost=1424315.65..1582048.83 rows=9000000 width=104) (actual time=12025.258..16424.975 rows=9000000 loops=1)
        Merge Cond: (a.id = act.actor_id)
        ->  Index Scan using actors_pk on actors a  (cost=0.43..1926354.47 rows=10000002 width=104) (actual time=0.033..5.774 rows=1200 loops=1)
        ->  Materialize  (cost=1424315.21..1469315.21 rows=9000000 width=8) (actual time=12025.105..14979.237 rows=9000000 loops=1)
              ->  Sort  (cost=1424315.21..1446815.21 rows=9000000 width=8) (actual time=12025.099..13517.104 rows=9000000 loops=1)
                    Sort Key: act.actor_id
                    Sort Method: external merge  Disk: 158536kB
                    ->  Seq Scan on actors_in_movies act  (cost=0.00..138649.00 rows=9000000 width=8) (actual time=0.346..7142.195 rows=9000000 loops=1)
  ->  Hash  (cost=2150000.00..2150000.00 rows=8073769 width=104) (actual time=83255.697..83255.697 rows=8088608 loops=1)
        Buckets: 32768  Batches: 512  Memory Usage: 2372kB
        ->  Seq Scan on movies m  (cost=0.00..2150000.00 rows=8073769 width=104) (actual time=230.278..76542.651 rows=8088608 loops=1)
              Filter: ((creation_date >= '2014-06-08 15:24:19'::timestamp without time zone) AND (creation_date <= '2022-07-08 15:24:19'::timestamp without time zone))
              Rows Removed by Filter: 1911392
Planning Time: 2.249 ms
JIT:
  Functions: 19
  Options: Inlining true, Optimization true, Expressions true, Deforming true
  Timing: Generation 3.673 ms, Inlining 8.561 ms, Optimization 143.358 ms, Emission 78.051 ms, Total 233.643 ms
Execution Time: 130587.159 ms


--
--ИТОГИ сложного запроса на 10 000 000 строк:
--При выборке с двумя join скорость обрботки запроса с дополнительными индексами по таблице actors_in_movies выигрыша не дает
--Добавление индексов не обязательно, так как результат выполнения с ними и без них практически идентичен































