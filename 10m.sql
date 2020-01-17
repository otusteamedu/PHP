do
$$
    begin
        perform filling_test_data(10000000);
    end;
$$;

-- 1 Короткометражные фильмы
explain analyse
select title, duration
from movies
where duration <= 60;
/*
Seq Scan on movies  (cost=0.00..22908.55 rows=316686 width=17) (actual time=0.017..165.676 rows=312391 loops=1)
Filter: (duration <= 60)
Rows Removed by Filter: 890213
Planning Time: 0.882 ms
Execution Time: 180.568 ms

Добавил индекс по полю duration, теперь происходит чтение индекса
 */
create index movie_duration_idx on movies (duration);
/*
Index Scan using movie_duration_idx on movies  (cost=0.43..14287.88 rows=316686 width=17) (actual time=0.032..92.281 rows=312391 loops=1)
Index Cond: (duration <= 60)
Planning Time: 0.192 ms
Execution Time: 94.625 ms
*/


-- 2 Список ID сотни фильмов-новинок из последних
explain analyse
select id_movie
from movies_attributes_values
where id_attribute = 2
order by id desc
limit 100;
/*
Limit  (cost=0.43..270.99 rows=100 width=12) (actual time=0.097..3.890 rows=100 loops=1)
  ->  Index Scan Backward using movies_attributes_values_pkey on movies_attributes_values  (cost=0.43..181959.63 rows=67254 width=12) (actual time=0.094..3.875 rows=100 loops=1)
        Filter: (id_attribute = 2)
        Rows Removed by Filter: 11644
Planning Time: 0.580 ms
Execution Time: 3.927 ms

Добавление составного индекса по полям (id_movie, id_attribute), а для данного запроса покрывающего, на результат не повлияло,
Т.к. существуют индексы по полям, их достаточно, возможно будет заметно при увелечении БД, но при этом будет увеличиваться
и объём индекса, тогда нужно будет взвесить стоимость добавления/хранения индекса и необходимость увеличения скорости.
Либо, как вариант, можно рассмотреть перенос хранения метки "Новинка" в отдельную таблицу, в которой будет не такое
большое кол-во строк, хранящих занчения других аттрибутов, скорее всего более целесообразно эту метку хранить в таблице movies.
*/
create index attr_movie_idx on movies_attributes_values (id_attribute, id_movie);
/*
Limit  (cost=0.43..270.98 rows=100 width=12) (actual time=0.061..2.662 rows=100 loops=1)
  ->  Index Scan Backward using movies_attributes_values_pkey on movies_attributes_values  (cost=0.43..181967.87 rows=67260 width=12) (actual time=0.060..2.647 rows=100 loops=1)
        Filter: (id_attribute = 2)
        Rows Removed by Filter: 11644
Planning Time: 0.118 ms
Execution Time: 2.688 ms
*/

-- 3 Отзывы по фильму
explain analyse
select id_movie as movie_id, as_text as review
from movies_attributes_values
where id_attribute = 1
  and id_movie = 15615;
/*
Gather  (cost=1000.00..97928.01 rows=5 width=39) (actual time=901.803..910.818 rows=2 loops=1)
  Workers Planned: 2
  Workers Launched: 2
  ->  Parallel Seq Scan on movies_attributes_values  (cost=0.00..96927.51 rows=2 width=39) (actual time=737.904..815.598 rows=1 loops=3)
        Filter: ((id_attribute = 1) AND (id_movie = 15615))
        Rows Removed by Filter: 2025893
Planning Time: 0.102 ms
Execution Time: 910.860 ms

А во этом случае добавление индекса attr_movie_idx (запрос #2) значительно повлияло на время выполнения запроса в лучшую сторону

Index Scan using attr_movie_idx on movies_attributes_values  (cost=0.43..6.32 rows=5 width=39) (actual time=2.959..2.963 rows=2 loops=1)
Index Cond: ((id_attribute = 1) AND (id_movie = 15615))
Planning Time: 1.668 ms
Execution Time: 2.984 ms
*/


-- 4 Посещаемость в течение дня: кол-во проданных билетов в разрезе начала сеансов
explain analyse
select s.time              as time,
       count(t.session_id) as tickets_count
from tickets t
         left join sessions s on t.session_id = s.id
group by s.time;
/*
Finalize GroupAggregate  (cost=265756.45..265757.97 rows=6 width=14) (actual time=6187.024..6187.045 rows=6 loops=1)
  Group Key: s."time"
  ->  Gather Merge  (cost=265756.45..265757.85 rows=12 width=14) (actual time=6187.006..6220.593 rows=18 loops=1)
        Workers Planned: 2
        Workers Launched: 2
        ->  Sort  (cost=264756.43..264756.44 rows=6 width=14) (actual time=6117.333..6117.334 rows=6 loops=3)
              Sort Key: s."time"
              Sort Method: quicksort  Memory: 25kB
              Worker 0:  Sort Method: quicksort  Memory: 25kB
              Worker 1:  Sort Method: quicksort  Memory: 25kB
              ->  Partial HashAggregate  (cost=264756.29..264756.35 rows=6 width=14) (actual time=6117.203..6117.205 rows=6 loops=3)
                    Group Key: s."time"
                    ->  Parallel Hash Left Join  (cost=18814.97..227392.53 rows=7472752 width=10) (actual time=270.043..4128.462 rows=5978234 loops=3)
                          Hash Cond: (t.session_id = s.id)
                          ->  Parallel Seq Scan on tickets t  (cost=0.00..188961.52 rows=7472752 width=8) (actual time=0.013..1288.247 rows=5978234 loops=3)
                          ->  Parallel Hash  (cost=12591.10..12591.10 rows=497910 width=10) (actual time=253.482..253.482 rows=398328 loops=3)
                                Buckets: 2097152  Batches: 1  Memory Usage: 72512kB
                                ->  Parallel Seq Scan on sessions s  (cost=0.00..12591.10 rows=497910 width=10) (actual time=0.097..93.289 rows=398328 loops=3)
Planning Time: 0.513 ms
Execution Time: 6220.866 ms

Удалось незначительно улучшить время выполнения запроса за счёт хранения времени начала сеанса как целочисленное значение и добавления индекса
*/
alter table sessions
    alter column time type char(2) using time::char(2);
alter table sessions
    alter column time type integer using time::integer;
create index ses_time_idx on sessions (time);
/* ....... отличие плана выполнения только в том, что после изменений происходит чтение индекса ses_time_idx вместо последовательного чтения строк при группировке
                    Group Key: s."time"
                    ->  Parallel Hash Left Join  (cost=22626.32..345437.88 rows=7472752 width=8) (actual time=250.728..4352.550 rows=5978234 loops=3)
                          Hash Cond: (t.session_id = s.id)
                          ->  Parallel Seq Scan on tickets t  (cost=0.00..303195.52 rows=7472752 width=4) (actual time=0.028..1362.792 rows=5978234 loops=3)
                          ->  Parallel Hash  (cost=16402.45..16402.45 rows=497910 width=8) (actual time=458.985..458.985 rows=398328 loops=3)
                                Buckets: 2097152  Batches: 1  Memory Usage: 63168kB
                                ->  Parallel Index Scan using ses_time_idx on sessions s  (cost=0.43..16402.45 rows=497910 width=8) (actual time=0.255..272.717 rows=398328 loops=3)
Planning Time: 0.938 ms
Execution Time: 3781.097 ms
*/

-- 5 Фильмы, которые были показаны не менее 3 раз
explain analyse
select m.id        as movie_id,
       m.title     as movie_title,
       count(s.id) as sessions_count
from movies m
         left join movies_attributes_values v on m.id = v.id_movie and v.id_attribute = 6
         left join sessions s on m.id = s.movie_id
group by m.id
having count(s.id) >= 3;
/*
HashAggregate  (cost=300947.92..315980.47 rows=400868 width=25) (actual time=4668.763..4923.752 rows=95393 loops=1)
  Group Key: m.id
  Filter: (count(s.id) >= 3)
  Rows Removed by Filter: 1107211
  ->  Hash Right Join  (cost=88153.82..291928.39 rows=1202604 width=21) (actual time=2331.916..3955.188 rows=1641119 loops=1)
        Hash Cond: (v.id_movie = m.id)
        ->  Seq Scan on movies_attributes_values v  (cost=0.00..193855.03 rows=721421 width=4) (actual time=0.038..841.100 rows=721398 loops=1)
              Filter: (id_attribute = 6)
              Rows Removed by Filter: 5356284
        ->  Hash  (cost=73121.27..73121.27 rows=1202604 width=21) (actual time=2321.148..2321.149 rows=1641119 loops=1)
              Buckets: 2097152  Batches: 1  Memory Usage: 102993kB
              ->  Hash Right Join  (cost=42810.59..73121.27 rows=1202604 width=21) (actual time=778.478..1791.374 rows=1641119 loops=1)
                    Hash Cond: (s.movie_id = m.id)
                    ->  Seq Scan on sessions s  (cost=0.00..27173.84 rows=1194984 width=8) (actual time=0.035..228.017 rows=1194984 loops=1)
                    ->  Hash  (cost=27778.04..27778.04 rows=1202604 width=17) (actual time=767.420..767.421 rows=1202604 loops=1)
                          Buckets: 2097152  Batches: 1  Memory Usage: 75100kB
                          ->  Seq Scan on movies m  (cost=0.00..27778.04 rows=1202604 width=17) (actual time=0.042..341.649 rows=1202604 loops=1)
Planning Time: 0.787 ms
Execution Time: 8024.315 ms
 */

/*
Добавление индекса attr_movie_idx (запрос #2) немного повлияло на время выполнения запроса в лучшую сторону

HashAggregate  (cost=149363.76..164396.31 rows=400868 width=25) (actual time=4490.921..4755.584 rows=95393 loops=1)
  Group Key: m.id
  Filter: (count(s.id) >= 3)
  Rows Removed by Filter: 1107211
  ->  Hash Right Join  (cost=88154.26..140344.23 rows=1202604 width=21) (actual time=2036.332..3734.261 rows=1641119 loops=1)
        Hash Cond: (v.id_movie = m.id)
        ->  Index Only Scan using attr_movie_idx on movies_attributes_values v  (cost=0.43..42270.87 rows=721421 width=4) (actual time=0.098..903.111 rows=721398 loops=1)
              Index Cond: (id_attribute = 6)
              Heap Fetches: 721398
        ->  Hash  (cost=73121.27..73121.27 rows=1202604 width=21) (actual time=2024.678..2024.678 rows=1641119 loops=1)
              Buckets: 2097152  Batches: 1  Memory Usage: 102993kB
              ->  Hash Right Join  (cost=42810.59..73121.27 rows=1202604 width=21) (actual time=584.675..1545.423 rows=1641119 loops=1)
                    Hash Cond: (s.movie_id = m.id)
                    ->  Seq Scan on sessions s  (cost=0.00..27173.84 rows=1194984 width=8) (actual time=0.031..209.944 rows=1194984 loops=1)
                    ->  Hash  (cost=27778.04..27778.04 rows=1202604 width=17) (actual time=573.810..573.810 rows=1202604 loops=1)
                          Buckets: 2097152  Batches: 1  Memory Usage: 75100kB
                          ->  Seq Scan on movies m  (cost=0.00..27778.04 rows=1202604 width=17) (actual time=0.046..208.485 rows=1202604 loops=1)
Planning Time: 0.473 ms
Execution Time: 4858.861 ms
*/


-- 6 Фильмы с рейтингом не ниже среднего из имеющихся (запрос написан криво для примера)
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
Sort  (cost=175446.91..175497.18 rows=20108 width=74) (actual time=5901.805..5957.340 rows=361210 loops=1)
  Sort Key: popular_movies.rating DESC, m.title
  Sort Method: quicksort  Memory: 59321kB
  CTE movies_ratings
    ->  HashAggregate  (cost=138469.40..143134.56 rows=466516 width=12) (actual time=1670.783..1857.000 rows=721769 loops=1)
          Group Key: movies_attributes_values.id_movie, movies_attributes_values.as_float
          ->  Seq Scan on movies_attributes_values  (cost=0.00..134907.14 rows=712452 width=12) (actual time=0.042..1275.575 rows=721769 loops=1)
                Filter: (id_attribute = 4)
                Rows Removed by Filter: 5355913
  CTE popular_movies
    ->  CTE Scan on movies_ratings movies_ratings_1  (cost=10496.62..20993.23 rows=155505 width=12) (actual time=2166.225..2299.218 rows=361210 loops=1)
          Filter: (rating >= $1)
          Rows Removed by Filter: 360559
          InitPlan 2 (returns $1)
            ->  Aggregate  (cost=10496.61..10496.62 rows=1 width=8) (actual time=495.434..495.434 rows=1 loops=1)
                  ->  CTE Scan on movies_ratings  (cost=0.00..9330.32 rows=466516 width=8) (actual time=0.001..398.288 rows=721769 loops=1)
  ->  Hash Join  (cost=5886.99..9881.86 rows=20108 width=74) (actual time=4295.741..5499.071 rows=361210 loops=1)
        Hash Cond: (popular_movies.movie_id = m.id)
        ->  CTE Scan on popular_movies  (cost=0.00..3110.10 rows=155505 width=12) (actual time=2166.228..2241.306 rows=361210 loops=1)
        ->  Hash  (cost=3943.18..3943.18 rows=155505 width=25) (actual time=2128.298..2128.298 rows=361210 loops=1)
              Buckets: 524288 (originally 262144)  Batches: 1 (originally 1)  Memory Usage: 25107kB
              ->  Nested Loop  (cost=3499.29..3943.18 rows=155505 width=25) (actual time=405.768..1969.577 rows=361210 loops=1)
                    ->  HashAggregate  (cost=3498.86..3500.86 rows=200 width=4) (actual time=405.728..528.084 rows=361210 loops=1)
                          Group Key: popular_movies_1.movie_id
                          ->  CTE Scan on popular_movies popular_movies_1  (cost=0.00..3110.10 rows=155505 width=4) (actual time=0.001..244.214 rows=361210 loops=1)
                    ->  Index Scan using movies_pkey on movies m  (cost=0.43..2.41 rows=1 width=21) (actual time=0.003..0.003 rows=1 loops=361210)
                          Index Cond: (id = popular_movies_1.movie_id)
Planning Time: 0.336 ms
Execution Time: 6062.930 ms
*/

/*
Добавление индекса и перенос значения рэйтинга в поле decimal
 */
update movies_attributes_values
set as_dec = as_float
where id_attribute = 4;
update movies_attributes_values
set as_float = null
where id_attribute = 4;
create index idx_as_dec on movies_attributes_values (id_attribute, id_movie, as_dec);
/*
И на самом деле запрос должен выглядеть совершенно по другому
Для большого кол-ва дынных такого рода можно считать что выражение (select avg(as_dec) as avg_rating) всегда равно 5.00,
при имеющихся данных в моём случае (select avg(as_dec) as avg_rating) = 5.0058334176169938
*/
explain analyse
select m.id       as movie_id,
       m.title    as movie_title,
       m.duration as movie_duration,
       v.as_dec   as movie_rating
from movies_attributes_values v
         inner join movies m on v.id_movie = m.id
where as_dec >= (
    select avg(as_dec) as avg_rating
    from movies_attributes_values
    where id_attribute = 4
);
/*
Hash Join  (cost=55198.09..140845.19 rows=2026251 width=27) (actual time=857.500..1154.526 rows=361270 loops=1)
  Hash Cond: (v.id_movie = m.id)
  InitPlan 1 (returns $1)
    ->  Finalize Aggregate  (cost=12387.06..12387.07 rows=1 width=32) (actual time=186.135..186.136 rows=1 loops=1)
          ->  Gather  (cost=12386.84..12387.05 rows=2 width=32) (actual time=185.507..186.195 rows=3 loops=1)
                Workers Planned: 2
                Workers Launched: 2
                ->  Partial Aggregate  (cost=11386.84..11386.85 rows=1 width=32) (actual time=118.476..118.476 rows=1 loops=3)
                      ->  Parallel Index Only Scan using idx_as_dec on movies_attributes_values  (cost=0.43..10600.82 rows=314407 width=6) (actual time=0.450..73.130 rows=240590 loops=3)
                            Index Cond: (id_attribute = 4)
                            Heap Fetches: 0
  ->  Index Only Scan using idx_as_dec on movies_attributes_values v  (cost=0.43..80328.60 rows=2026251 width=10) (actual time=359.198..508.656 rows=361270 loops=1)
        Index Cond: (as_dec >= $1)
        Heap Fetches: 0
  ->  Hash  (cost=27778.04..27778.04 rows=1202604 width=21) (actual time=487.222..487.222 rows=1202604 loops=1)
        Buckets: 2097152  Batches: 1  Memory Usage: 81623kB
        ->  Seq Scan on movies m  (cost=0.00..27778.04 rows=1202604 width=21) (actual time=0.050..163.053 rows=1202604 loops=1)
Planning Time: 25.719 ms
Execution Time: 1184.438 ms
*/
