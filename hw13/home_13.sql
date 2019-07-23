create table films_test
(
	id SERIAL8
		constraint films_test_pk
			primary key,
	name VARCHAR(127) not null,
	year int2 not null
);



create table genres
(
	id SERIAL
		constraint genres_pk
			primary key,
	name VARCHAR(127) not null
);

create table film_genre
(
	film_id BIGINT not null,
	genre_id int not null
);


INSERT INTO genres (name)
VALUES ('боевик'),('вестерн'),
       ('детектив'),('детский'),
       ('драма'),('история'),
       ('комедия'),('криминал'),
       ('мелодрама'),('триллер'),
       ('ужасы'),('фантастика');



CREATE INDEX film_year_idx ON films_test(year);


explain SELECT * FROM films_test WHERE year = 2017;
                                   QUERY PLAN                                   
--------------------------------------------------------------------------------
 Bitmap Heap Scan on films_test  (cost=37.36..131.45 rows=1687 width=27)
   Recheck Cond: (year = 2017)
   ->  Bitmap Index Scan on film_year_idx  (cost=0.00..36.94 rows=1687 width=0)
         Index Cond: (year = 2017)


explain  SELECT name FROM films_test WHERE year = 2015;
                                   QUERY PLAN                                   
--------------------------------------------------------------------------------
 Bitmap Heap Scan on films_test  (cost=32.98..126.45 rows=1638 width=17)
   Recheck Cond: (year = 2015)
   ->  Bitmap Index Scan on film_year_idx  (cost=0.00..32.57 rows=1638 width=0)
         Index Cond: (year = 2015)

DROP INDEX film_year_idx ;

explain  SELECT name FROM films_test WHERE year = 2015;
                           QUERY PLAN                           
----------------------------------------------------------------
 Seq Scan on films_test  (cost=0.00..198.00 rows=1638 width=17)
   Filter: (year = 2015)
(2 rows)
 //увеличиваем таблицу film_test на порядок
explain SELECT name , (2019 - year) AS LAST FROM films_test;
                            QUERY PLAN                             
-------------------------------------------------------------------
 Seq Scan on films_test  (cost=0.00..1975.00 rows=100000 width=21)
(1 row)

//строка c годом 2013 редкая
//В таблице film_test 100 000 записей
//В таблице film_genre 200 000 записей

explain SELECT name FROM films_test WHERE year = 2013;
                                   QUERY PLAN                                   
--------------------------------------------------------------------------------
 Bitmap Heap Scan on films_test  (cost=20.28..795.36 rows=1030 width=17)
   Recheck Cond: (year = 2013)
   ->  Bitmap Index Scan on film_year_idx  (cost=0.00..20.02 rows=1030 width=0)
         Index Cond: (year = 2013)

explain SELECT name FROM films_test WHERE year = 2014;
                                    QUERY PLAN                                    
----------------------------------------------------------------------------------
 Bitmap Heap Scan on films_test  (cost=312.50..1244.29 rows=16543 width=17)
   Recheck Cond: (year = 2014)
   ->  Bitmap Index Scan on film_year_idx  (cost=0.00..308.37 rows=16543 width=0)
         Index Cond: (year = 2014)


------------------------------------------------------------------------------


EXPLAIN SELECT films_test.name
FROM films_test
    INNER JOIN film_genre ON films_test.id = film_genre.film_id
    INNER JOIN genres ON film_genre.genre_id = genres.id
WHERE genres.name = 'драма';
                                          QUERY PLAN                                          
----------------------------------------------------------------------------------------------
 Gather  (cost=1013.55..3811.55 rows=768 width=17)
   Workers Planned: 1
   ->  Nested Loop  (cost=13.55..2734.75 rows=452 width=17)
         ->  Hash Join  (cost=13.26..2585.58 rows=452 width=8)
               Hash Cond: (film_genre.genre_id = genres.id)
               ->  Parallel Seq Scan on film_genre  (cost=0.00..2258.47 rows=117647 width=12)
               ->  Hash  (cost=13.25..13.25 rows=1 width=4)
                     ->  Seq Scan on genres  (cost=0.00..13.25 rows=1 width=4)
                           Filter: ((name)::text = 'драма'::text)
         ->  Index Scan using films_test_pk on films_test  (cost=0.29..0.33 rows=1 width=25)
               Index Cond: (id = film_genre.film_id)

//Здесь видно что задействован индекс по первичному ключу films_test_pk, который ссылается на id

------------------------------------------------------------------

//Посчитаем кол-во фильмов в каждом жанре
EXPLAIN SELECT genres.name, COUNT(films_test.name)
FROM films_test
         INNER JOIN film_genre ON films_test.id = film_genre.film_id
         INNER JOIN genres ON film_genre.genre_id = genres.id
GROUP BY 1;


Finalize GroupAggregate  (cost=9986.82..10012.82 rows=200 width=280)
   Group Key: genres.name
   ->  Gather Merge  (cost=9986.82..10009.82 rows=200 width=280)
         Workers Planned: 1
         ->  Sort  (cost=8986.81..8987.31 rows=200 width=280)
               Sort Key: genres.name
               ->  Partial HashAggregate  (cost=8977.17..8979.17 rows=200 width=280)
                     Group Key: genres.name
                     ->  Hash Join  (cost=3674.85..8389.64 rows=117506 width=289)
                           Hash Cond: (film_genre.genre_id = genres.id)
                           ->  Hash Join  (cost=3659.00..8060.31 rows=117506 width=21)
                                 Hash Cond: (film_genre.film_id = films_test.id)
                                 ->  Parallel Seq Scan on film_genre  (cost=0.00..2258.47 rows=117647 width=12)
                                 ->  Hash  (cost=1725.00..1725.00 rows=100000 width=25)
                                       ->  Seq Scan on films_test  (cost=0.00..1725.00 rows=100000 width=25)
                           ->  Hash  (cost=12.60..12.60 rows=260 width=276)
                                 ->  Seq Scan on genres  (cost=0.00..12.60 rows=260 width=276)

боевик	16676
вестерн	16619
детектив	16849
детский	16573
драма	16756
история	16426
комедия	16542
криминал	16602
мелодрама	16812
триллер	16534
ужасы	16734
фантастика	16877


//После создания индекса по жанрам
CREATE INDEX genre_idx ON genres (name);
//Получаем тот же результат, так как жанров всего 12

//Ну и результат кол-во фильмов по кодам - сикуенс скан

EXPLAIN SELECT films_test.year, count(films_test.name)
FROM films_test
GROUP BY 1;

HashAggregate  (cost=2225.00..2225.07 rows=7 width=10)
   Group Key: year
   ->  Seq Scan on films_test  (cost=0.00..1725.00 rows=100000 width=19)

2015	16499
2014	16424
2017	16531
2019	16670
2016	16532
2018	16333
2013	1011

//И составим запрос на кол-во жанров в фильмах, в каждом году

EXPLAIN SELECT genres.name, COUNT(films_test.year), films_test.year
FROM films_test
         INNER JOIN film_genre ON films_test.id = film_genre.film_id
         INNER JOIN genres ON film_genre.genre_id = genres.id
GROUP BY 1,3 ORDER BY 3;

Finalize GroupAggregate  (cost=9973.79..9984.92 rows=84 width=282)
   Group Key: films_test.year, genres.name
   ->  Gather Merge  (cost=9973.79..9983.45 rows=84 width=282)
         Workers Planned: 1
         ->  Sort  (cost=8973.78..8973.99 rows=84 width=282)
               Sort Key: films_test.year, genres.name
               ->  Partial HashAggregate  (cost=8970.26..8971.10 rows=84 width=282)
                     Group Key: films_test.year, genres.name
                     ->  Hash Join  (cost=3465.27..8088.96 rows=117506 width=274)
                           Hash Cond: (film_genre.genre_id = genres.id)
                           ->  Hash Join  (cost=3464.00..7670.31 rows=117506 width=6)
                                 Hash Cond: (film_genre.film_id = films_test.id)
                                 ->  Parallel Seq Scan on film_genre  (cost=0.00..2258.47 rows=117647 width=12)
                                 ->  Hash  (cost=1725.00..1725.00 rows=100000 width=10)
                                       ->  Seq Scan on films_test  (cost=0.00..1725.00 rows=100000 width=10)
                           ->  Hash  (cost=1.12..1.12 rows=12 width=276)
                                 ->  Seq Scan on genres  (cost=0.00..1.12 rows=12 width=276)

боевик	146	2013
вестерн	154	2013
детектив	215	2013
детский	170	2013
драма	181	2013
история	164	2013
комедия	161	2013
криминал	178	2013
мелодрама	177	2013
триллер	135	2013
ужасы	180	2013
фантастика	161	2013
боевик	2824	2014
вестерн	2624	2014
детектив	2798	2014
детский	2751	2014
драма	2671	2014
история	2703	2014
комедия	2797	2014
криминал	2635	2014
мелодрама	2769	2014
триллер	2731	2014
ужасы	2740	2014
фантастика	2805	2014
боевик	2750	2015
вестерн	2770	2015
детектив	2789	2015
детский	2759	2015
драма	2700	2015
история	2768	2015
комедия	2720	2015
криминал	2693	2015
мелодрама	2760	2015
триллер	2716	2015
ужасы	2807	2015
фантастика	2766	2015
боевик	2743	2016
вестерн	2798	2016
детектив	2774	2016
детский	2740	2016
драма	2770	2016
история	2722	2016
комедия	2741	2016
криминал	2756	2016
мелодрама	2798	2016
триллер	2778	2016
ужасы	2714	2016
фантастика	2730	2016
боевик	2750	2017
вестерн	2791	2017
детектив	2851	2017
детский	2748	2017
драма	2835	2017
история	2742	2017
комедия	2681	2017
криминал	2678	2017
мелодрама	2723	2017
триллер	2734	2017
ужасы	2684	2017
фантастика	2845	2017
боевик	2674	2018
вестерн	2688	2018
детектив	2684	2018
детский	2682	2018
драма	2762	2018
история	2649	2018
комедия	2664	2018
криминал	2818	2018
мелодрама	2794	2018
триллер	2645	2018
ужасы	2818	2018
фантастика	2788	2018
боевик	2789	2019
вестерн	2794	2019
детектив	2738	2019
детский	2723	2019
драма	2837	2019
история	2678	2019
комедия	2778	2019
криминал	2844	2019
мелодрама	2791	2019
триллер	2795	2019
ужасы	2791	2019
фантастика	2782	2019

