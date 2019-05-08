-- найти ближайшие 5 сеансов
select *
from seance
where date(date_start) < (CURRENT_TIMESTAMP)
order by date_start
limit 5;
--Limit  (cost=9.08..9.09 rows=5 width=40) (actual time=0.082..0.084 rows=5 loops=1)
--  ->  Sort  (cost=9.08..9.30 rows=88 width=40) (actual time=0.082..0.082 rows=5 loops=1)
--        Sort Key: date_start
--        Sort Method: top-N heapsort  Memory: 25kB
--        ->  Seq Scan on seance  (cost=0.00..7.62 rows=88 width=40) (actual time=0.014..0.070 rows=88 loops=1)
--              Filter: (date(date_start) < CURRENT_TIMESTAMP)
--              Rows Removed by Filter: 176
--Planning Time: 0.087 ms
--Execution Time: 0.095 ms

--CREATE INDEX seance_date_start_idx ON test_db.seance USING btree (date_start);

--Limit  (cost=0.15..1.62 rows=5 width=40) (actual time=0.015..0.017 rows=5 loops=1)
--  ->  Index Scan using seance_date_start_idx on seance  (cost=0.15..25.98 rows=88 width=40) (actual time=0.014..0.016 rows=5 loops=1)
--        Filter: (date(date_start) < CURRENT_TIMESTAMP)
--Planning Time: 0.084 ms
--Execution Time: 0.029 ms


-- найти ближайшие 5 комедий
select distinct film.title
from film
         left join seance on seance.film_id = film.id
         left join genre on genre.id = film.genre_id
where genre.title = 'Комедия'
and date(seance.date_start) < (CURRENT_TIMESTAMP);

-- Ладони изнутри веры

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

-- CREATE INDEX genre_title_idx ON test_db.genre (title);

--Unique  (cost=17.61..17.65 rows=8 width=516) (actual time=0.111..0.114 rows=1 loops=1)
--  ->  Sort  (cost=17.61..17.63 rows=8 width=516) (actual time=0.110..0.111 rows=11 loops=1)
--        Sort Key: film.title
--        Sort Method: quicksort  Memory: 25kB
--        ->  Hash Join  (cost=9.46..17.49 rows=8 width=516) (actual time=0.039..0.103 rows=11 loops=1)
--              Hash Cond: (seance.film_id = film.id)
--              ->  Seq Scan on seance  (cost=0.00..7.62 rows=88 width=8) (actual time=0.014..0.066 rows=88 loops=1)
--                    Filter: (date(date_start) < CURRENT_TIMESTAMP)
--                    Rows Removed by Filter: 176
--              ->  Hash  (cost=9.31..9.31 rows=12 width=524) (actual time=0.019..0.019 rows=1 loops=1)
--                    Buckets: 1024  Batches: 1  Memory Usage: 9kB
--                    ->  Nested Loop  (cost=0.14..9.31 rows=12 width=524) (actual time=0.015..0.017 rows=1 loops=1)
--                          ->  Seq Scan on genre  (cost=0.00..1.14 rows=1 width=8) (actual time=0.005..0.006 rows=1 loops=1)
--                                Filter: ((title)::text = 'Комедия'::text)
--                                Rows Removed by Filter: 10
--                          ->  Index Scan using idx_films_to_genre_idx on film  (cost=0.14..8.16 rows=1 width=532) (actual time=0.009..0.010 rows=1 loops=1)
--                                Index Cond: (genre_id = genre.id)
--Planning Time: 0.211 ms
--Execution Time: 0.144 ms


-- ближайшие 10 фильмов
    select distinct film.title
    from film
             left join seance on seance.film_id=film.id
        and date(seance.date_start) < (CURRENT_TIMESTAMP);

-- HashAggregate  (cost=21.11..22.41 rows=130 width=516) (actual time=0.122..0.125 rows=10 loops=1)
--   Group Key: film.title
--   ->  Hash Right Join  (cost=12.93..20.79 rows=130 width=516) (actual time=0.028..0.103 rows=88 loops=1)
--         Hash Cond: (seance.film_id = film.id)
--         ->  Seq Scan on seance  (cost=0.00..7.62 rows=88 width=8) (actual time=0.009..0.066 rows=88 loops=1)
--               Filter: (date(date_start) < CURRENT_TIMESTAMP)
--               Rows Removed by Filter: 176
--         ->  Hash  (cost=11.30..11.30 rows=130 width=524) (actual time=0.015..0.015 rows=10 loops=1)
--               Buckets: 1024  Batches: 1  Memory Usage: 9kB
--               ->  Seq Scan on film  (cost=0.00..11.30 rows=130 width=524) (actual time=0.010..0.012 rows=10 loops=1)
-- Planning Time: 0.138 ms
-- Execution Time: 0.153 ms

-- HashAggregate  (cost=21.11..22.41 rows=130 width=516) (actual time=0.124..0.127 rows=10 loops=1)
--   Group Key: film.title
--   ->  Hash Right Join  (cost=12.93..20.79 rows=130 width=516) (actual time=0.030..0.107 rows=88 loops=1)
--         Hash Cond: (seance.film_id = film.id)
--         ->  Seq Scan on seance  (cost=0.00..7.62 rows=88 width=8) (actual time=0.008..0.065 rows=88 loops=1)
--               Filter: (date(date_start) < CURRENT_TIMESTAMP)
--               Rows Removed by Filter: 176
--         ->  Hash  (cost=11.30..11.30 rows=130 width=524) (actual time=0.017..0.017 rows=10 loops=1)
--               Buckets: 1024  Batches: 1  Memory Usage: 9kB
--               ->  Seq Scan on film  (cost=0.00..11.30 rows=130 width=524) (actual time=0.011..0.011 rows=10 loops=1)
-- Planning Time: 0.170 ms
-- Execution Time: 0.158 ms