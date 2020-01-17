set search_path to cinema_10k;

do
$$
    begin
        perform filling_test_data(10000);
    end;
$$;


-- 1 Фильмы продолжительностью 2 часа
explain analyse
select title, duration
from movies
where duration = 120;
/*
Seq Scan on movies  (cost=0.00..23.50 rows=1 width=520) (actual time=0.019..0.360 rows=36 loops=1)
Filter: (duration = 120)
Rows Removed by Filter: 2945
Planning Time: 0.064 ms
Execution Time: 0.372 ms
*/

-- 2 Список ID сотни фильмов-новинок из последних
explain analyse
select id_movie
from movies_attributes_values
where id_attribute = 2
order by id desc
limit 100;
/*
Limit  (cost=278.96..279.09 rows=51 width=12) (actual time=3.966..3.981 rows=100 loops=1)
  ->  Sort  (cost=278.96..279.09 rows=51 width=12) (actual time=3.965..3.973 rows=100 loops=1)
        Sort Key: id DESC
        Sort Method: quicksort  Memory: 32kB
        ->  Seq Scan on movies_attributes_values  (cost=0.00..277.51 rows=51 width=12) (actual time=0.019..3.887 rows=160 loops=1)
              Filter: (id_attribute = 2)
              Rows Removed by Filter: 15063
Planning Time: 0.095 ms
Execution Time: 4.011 ms
*/


-- 3 Сотня случайных короткометражных фильмов
explain analyse
select id, title, duration
from movies
where duration <= 60
order by random()
limit 100;
/*
Limit  (cost=26.77..27.01 rows=93 width=532) (actual time=1.139..1.155 rows=100 loops=1)
  ->  Sort  (cost=26.77..27.01 rows=93 width=532) (actual time=1.138..1.144 rows=100 loops=1)
        Sort Key: (random())
        Sort Method: top-N heapsort  Memory: 38kB
        ->  Seq Scan on movies  (cost=0.00..23.73 rows=93 width=532) (actual time=0.022..0.718 rows=782 loops=1)
              Filter: (duration <= 60)
              Rows Removed by Filter: 2199
Planning Time: 0.098 ms
Execution Time: 1.188 ms
*/


-- 4 Посещаемость в течение дня: кол-во проданных билетов в разрезе начала сеансов
explain analyse
select s.time      as time,
       count(t.id) as tickets_count
from tickets t
         left join sessions s on t.session_id = s.id
group by s.time;
/*
HashAggregate  (cost=1070.25..1070.31 rows=6 width=14) (actual time=31.509..31.511 rows=6 loops=1)
  Group Key: s."time"
  ->  Hash Left Join  (cost=81.18..864.32 rows=41186 width=10) (actual time=0.969..19.671 rows=41186 loops=1)
        Hash Cond: (t.session_id = s.id)
        ->  Seq Scan on tickets t  (cost=0.00..674.86 rows=41186 width=8) (actual time=0.012..5.381 rows=41186 loops=1)
        ->  Hash  (cost=46.08..46.08 rows=2808 width=10) (actual time=0.946..0.947 rows=2808 loops=1)
              Buckets: 4096  Batches: 1  Memory Usage: 153kB
              ->  Seq Scan on sessions s  (cost=0.00..46.08 rows=2808 width=10) (actual time=0.009..0.468 rows=2808 loops=1)
Planning Time: 0.236 ms
Execution Time: 31.553 ms
*/


-- 5 Фильмы, которые были показаны не менее 3 раз
explain analyse
select m.id        as movie_id,
       m.title     as movie_title,
       v.as_text   as movie_genre,
       count(s.id) as sessions_count
from movies m
         left join movies_attributes_values v on m.id = v.id_movie and v.id_attribute = 6
         left join sessions s on m.id = s.movie_id
group by m.id, v.as_text
having count(s.id) >= 3;
/*
HashAggregate  (cost=394.24..421.24 rows=720 width=560) (actual time=11.053..11.492 rows=214 loops=1)
  Group Key: m.id, v.as_text
  Filter: (count(s.id) >= 3)
  Rows Removed by Filter: 2767
  ->  Hash Left Join  (cost=304.45..372.64 rows=2160 width=556) (actual time=5.054..8.697 rows=3975 loops=1)
        Hash Cond: (m.id = v.id_movie)
        ->  Hash Right Join  (cost=26.30..71.66 rows=2160 width=524) (actual time=1.695..3.742 rows=3975 loops=1)
              Hash Cond: (s.movie_id = m.id)
              ->  Seq Scan on sessions s  (cost=0.00..39.60 rows=2160 width=8) (actual time=0.018..0.497 rows=2808 loops=1)
              ->  Hash  (cost=22.80..22.80 rows=280 width=520) (actual time=1.664..1.664 rows=2981 loops=1)
                    Buckets: 4096 (originally 1024)  Batches: 1 (originally 1)  Memory Usage: 178kB
                    ->  Seq Scan on movies m  (cost=0.00..22.80 rows=280 width=520) (actual time=0.018..0.823 rows=2981 loops=1)
        ->  Hash  (cost=277.51..277.51 rows=51 width=36) (actual time=3.351..3.351 rows=1826 loops=1)
              Buckets: 2048 (originally 1024)  Batches: 1 (originally 1)  Memory Usage: 98kB
              ->  Seq Scan on movies_attributes_values v  (cost=0.00..277.51 rows=51 width=36) (actual time=0.012..2.744 rows=1826 loops=1)
                    Filter: (id_attribute = 6)
                    Rows Removed by Filter: 13397
Planning Time: 0.321 ms
Execution Time: 11.708 ms
*/


-- 6 Фильмы с рейтингом не ниже среднего из имеющихся (запрос написан криво для примера, испарвленный запрос написан в 10m.sql)
explain analyse
with movies_ratings as (
    select id_movie as movie_id,
           as_float as rating
    from movies_attributes_values
    where id_attribute = 4
    group by id_movie, as_float
),
     popular_movies as (
         select rating, movie_id
         from movies_ratings
         where rating >= (select avg(rating) from movies_ratings)
     )
select m.id                                     as movie_id,
       m.title                                  as movie_title,
       m.duration                               as movie_duration,
       round(popular_movies.rating::numeric, 3) as movie_rating
from movies m
         right join popular_movies on m.id = popular_movies.movie_id
where m.id in (select movie_id from popular_movies)
order by rating desc, title;
/*
Sort  (cost=306.52..306.53 rows=1 width=1080) (actual time=9.311..9.363 rows=908 loops=1)
  Sort Key: popular_movies.rating DESC, m.title
  Sort Method: quicksort  Memory: 143kB
  CTE movies_ratings
    ->  Group  (cost=278.96..279.34 rows=50 width=12) (actual time=2.455..3.187 rows=1836 loops=1)
          Group Key: movies_attributes_values.id_movie, movies_attributes_values.as_float
          ->  Sort  (cost=278.96..279.09 rows=51 width=12) (actual time=2.453..2.587 rows=1836 loops=1)
                Sort Key: movies_attributes_values.id_movie, movies_attributes_values.as_float
                Sort Method: quicksort  Memory: 135kB
                ->  Seq Scan on movies_attributes_values  (cost=0.00..277.51 rows=51 width=12) (actual time=0.015..1.999 rows=1836 loops=1)
                      Filter: (id_attribute = 4)
                      Rows Removed by Filter: 13387
  CTE popular_movies
    ->  CTE Scan on movies_ratings movies_ratings_1  (cost=1.14..2.26 rows=17 width=12) (actual time=4.395..4.648 rows=908 loops=1)
          Filter: (rating >= $1)
          Rows Removed by Filter: 928
          InitPlan 2 (returns $1)
            ->  Aggregate  (cost=1.13..1.14 rows=1 width=8) (actual time=1.931..1.931 rows=1 loops=1)
                  ->  CTE Scan on movies_ratings  (cost=0.00..1.00 rows=50 width=8) (actual time=0.001..1.448 rows=1836 loops=1)
  ->  Hash Join  (cost=1.10..24.91 rows=1 width=1080) (actual time=5.293..8.623 rows=908 loops=1)
        Hash Cond: (m.id = popular_movies.movie_id)
        ->  Hash Semi Join  (cost=0.55..24.28 rows=17 width=528) (actual time=0.262..1.280 rows=908 loops=1)
              Hash Cond: (m.id = popular_movies_1.movie_id)
              ->  Seq Scan on movies m  (cost=0.00..22.80 rows=280 width=524) (actual time=0.024..0.360 rows=2981 loops=1)
              ->  Hash  (cost=0.34..0.34 rows=17 width=4) (actual time=0.228..0.228 rows=908 loops=1)
                    Buckets: 1024  Batches: 1  Memory Usage: 40kB
                    ->  CTE Scan on popular_movies popular_movies_1  (cost=0.00..0.34 rows=17 width=4) (actual time=0.001..0.102 rows=908 loops=1)
        ->  Hash  (cost=0.34..0.34 rows=17 width=12) (actual time=5.013..5.013 rows=908 loops=1)
              Buckets: 1024  Batches: 1  Memory Usage: 48kB
              ->  CTE Scan on popular_movies  (cost=0.00..0.34 rows=17 width=12) (actual time=4.397..4.893 rows=908 loops=1)
Planning Time: 0.391 ms
Execution Time: 9.628 ms
*/