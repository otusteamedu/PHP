-- 100 rows in cinema
-- without indexes



explain select * from cinema;
-- 100
-- Seq Scan on cinema  (cost=0.00..2.00 rows=100 width=46)

-- 10000
-- Seq Scan on cinema  (cost=0.00..194.00 rows=10000 width=46)

-- 100000
-- Seq Scan on cinema  (cost=0.00..1935.00 rows=100000 width=46)






explain select * from cinema order by cinema_name;

-- 100
-- Sort  (cost=5.32..5.57 rows=100 width=46)
--   Sort Key: cinema_name
--   ->  Seq Scan on cinema  (cost=0.00..2.00 rows=100 width=46)

-- 10000
-- Sort  (cost=858.39..883.39 rows=10000 width=46)
--   Sort Key: cinema_name
--   ->  Seq Scan on cinema  (cost=0.00..194.00 rows=10000 width=46)

-- 100000
-- Sort  (cost=10239.82..10489.82 rows=100000 width=46)
--   Sort Key: cinema_name
--   ->  Seq Scan on cinema  (cost=0.00..1935.00 rows=100000 width=46)





explain select * from cinema order by cinema_name, cinema_address desc;
-- 100
-- Sort  (cost=5.32..5.57 rows=100 width=46)
--   Sort Key: cinema_name, cinema_address DESC
--   ->  Seq Scan on cinema  (cost=0.00..2.00 rows=100 width=46)

-- 10000
-- Sort  (cost=858.39..883.39 rows=10000 width=46)
--   Sort Key: cinema_name, cinema_address DESC
--   ->  Seq Scan on cinema  (cost=0.00..194.00 rows=10000 width=46)

-- 100000
-- Sort  (cost=10239.82..10489.82 rows=100000 width=46)
--   Sort Key: cinema_name, cinema_address DESC
--   ->  Seq Scan on cinema  (cost=0.00..1935.00 rows=100000 width=46)



explain select * from movie left join session on session.movie_id = movie.movie_id ;
-- 100
-- Hash Right Join  (cost=3.25..5.52 rows=100 width=74)
--   Hash Cond: (session.movie_id = movie.movie_id)
--   ->  Seq Scan on session  (cost=0.00..2.00 rows=100 width=32)
--   ->  Hash  (cost=2.00..2.00 rows=100 width=42)
--         ->  Seq Scan on movie  (cost=0.00..2.00 rows=100 width=42)
-- 10000
-- Hash Right Join  (cost=319.00..521.52 rows=10100 width=74)
--   Hash Cond: (session.movie_id = movie.movie_id)
--   ->  Seq Scan on session  (cost=0.00..176.00 rows=10100 width=32)
--   ->  Hash  (cost=194.00..194.00 rows=10000 width=42)
--         ->  Seq Scan on movie  (cost=0.00..194.00 rows=10000 width=42)

-- 100000
-- Hash Right Join  (cost=3279.00..5277.51 rows=100000 width=74)
--   Hash Cond: (session.movie_id = movie.movie_id)
--   ->  Seq Scan on session  (cost=0.00..1736.00 rows=100000 width=32)
--   ->  Hash  (cost=2029.00..2029.00 rows=100000 width=42)
--         ->  Seq Scan on movie  (cost=0.00..2029.00 rows=100000 width=42)



explain 
select * from movie 
left join session on session.movie_id = movie.movie_id 
left join hall on hall.hall_id = session.hall_id;

-- Hash Left Join  (cost=6.50..9.05 rows=100 width=113)
--   Hash Cond: (session.hall_id = hall.hall_id)
--   ->  Hash Right Join  (cost=3.25..5.52 rows=100 width=74)
--         Hash Cond: (session.movie_id = movie.movie_id)
--         ->  Seq Scan on session  (cost=0.00..2.00 rows=100 width=32)
--         ->  Hash  (cost=2.00..2.00 rows=100 width=42)
--               ->  Seq Scan on movie  (cost=0.00..2.00 rows=100 width=42)
--   ->  Hash  (cost=2.00..2.00 rows=100 width=39)
--         ->  Seq Scan on hall  (cost=0.00..2.00 rows=100 width=39)

-- 10000
-- Hash Left Join  (cost=631.25..860.30 rows=10100 width=113)
--   Hash Cond: (session.hall_id = hall.hall_id)
--   ->  Hash Right Join  (cost=319.00..521.52 rows=10100 width=74)
--         Hash Cond: (session.movie_id = movie.movie_id)
--         ->  Seq Scan on session  (cost=0.00..176.00 rows=10100 width=32)
--         ->  Hash  (cost=194.00..194.00 rows=10000 width=42)
--               ->  Seq Scan on movie  (cost=0.00..194.00 rows=10000 width=42)
--   ->  Hash  (cost=186.00..186.00 rows=10100 width=39)
--         ->  Seq Scan on hall  (cost=0.00..186.00 rows=10100 width=39)


-- 100000
-- Hash Left Join  (cost=6447.00..8708.02 rows=100000 width=113)
--   Hash Cond: (session.hall_id = hall.hall_id)
--   ->  Hash Right Join  (cost=3279.00..5277.51 rows=100000 width=74)
--         Hash Cond: (session.movie_id = movie.movie_id)
--         ->  Seq Scan on session  (cost=0.00..1736.00 rows=100000 width=32)
--         ->  Hash  (cost=2029.00..2029.00 rows=100000 width=42)
--               ->  Seq Scan on movie  (cost=0.00..2029.00 rows=100000 width=42)
--   ->  Hash  (cost=1918.00..1918.00 rows=100000 width=39)
--         ->  Seq Scan on hall  (cost=0.00..1918.00 rows=100000 width=39)



explain select * from movie 
left join session on session.movie_id = movie.movie_id 
left join hall on hall.hall_id = session.hall_id order by movie.movie_name ;

-- Sort  (cost=12.37..12.62 rows=100 width=144)
--   Sort Key: movie.movie_name
--   ->  Hash Left Join  (cost=6.50..9.05 rows=100 width=144)
--         Hash Cond: (session.hall_id = hall.hall_id)
--         ->  Hash Right Join  (cost=3.25..5.52 rows=100 width=74)
--               Hash Cond: (session.movie_id = movie.movie_id)
--               ->  Seq Scan on session  (cost=0.00..2.00 rows=100 width=32)
--               ->  Hash  (cost=2.00..2.00 rows=100 width=42)
--                     ->  Seq Scan on movie  (cost=0.00..2.00 rows=100 width=42)
--         ->  Hash  (cost=2.00..2.00 rows=100 width=39)
--               ->  Seq Scan on hall  (cost=0.00..2.00 rows=100 width=39)

-- 10000
-- Sort  (cost=1532.05..1557.30 rows=10100 width=144)
--   Sort Key: movie.movie_name
--   ->  Hash Left Join  (cost=631.25..860.30 rows=10100 width=144)
--         Hash Cond: (session.hall_id = hall.hall_id)
--         ->  Hash Right Join  (cost=319.00..521.52 rows=10100 width=74)
--               Hash Cond: (session.movie_id = movie.movie_id)
--               ->  Seq Scan on session  (cost=0.00..176.00 rows=10100 width=32)
--               ->  Hash  (cost=194.00..194.00 rows=10000 width=42)
--                     ->  Seq Scan on movie  (cost=0.00..194.00 rows=10000 width=42)
--         ->  Hash  (cost=186.00..186.00 rows=10100 width=39)
--               ->  Seq Scan on hall  (cost=0.00..186.00 rows=10100 width=39)

-- 100000
-- Sort  (cost=17012.84..17262.84 rows=100000 width=144)
--   Sort Key: movie.movie_name
--   ->  Hash Left Join  (cost=6447.00..8708.02 rows=100000 width=144)
--         Hash Cond: (session.hall_id = hall.hall_id)
--         ->  Hash Right Join  (cost=3279.00..5277.51 rows=100000 width=74)
--               Hash Cond: (session.movie_id = movie.movie_id)
--               ->  Seq Scan on session  (cost=0.00..1736.00 rows=100000 width=32)
--               ->  Hash  (cost=2029.00..2029.00 rows=100000 width=42)
--                     ->  Seq Scan on movie  (cost=0.00..2029.00 rows=100000 width=42)
--         ->  Hash  (cost=1918.00..1918.00 rows=100000 width=39)
--               ->  Seq Scan on hall  (cost=0.00..1918.00 rows=100000 width=39)


-- получить все фильмы с ценой больше 200 рублей. 
-- как видим ничего практически не меняется.

explain 
select * from movie 
left join session on session.movie_id = movie.movie_id 
left join hall on hall.hall_id = session.hall_id 
where session.price > (200)::money
order by movie.movie_name ;

-- 100000

-- Sort  (cost=14346.75..14512.66 rows=66366 width=144)
--   Sort Key: movie.movie_name
--   ->  Hash Left Join  (cost=6447.00..9031.44 rows=66366 width=144)
--         Hash Cond: (session.hall_id = hall.hall_id)
--         ->  Hash Join  (cost=3279.00..5689.22 rows=66366 width=74)
--               Hash Cond: (session.movie_id = movie.movie_id)
--               ->  Seq Scan on session  (cost=0.00..2236.00 rows=66366 width=32)
--                     Filter: (price > (200)::money)
--               ->  Hash  (cost=2029.00..2029.00 rows=100000 width=42)
--                     ->  Seq Scan on movie  (cost=0.00..2029.00 rows=100000 width=42)
--         ->  Hash  (cost=1918.00..1918.00 rows=100000 width=39)
--               ->  Seq Scan on hall  (cost=0.00..1918.00 rows=100000 width=39)



-- с индексом на movie_name
explain select * from movie m  where m.movie_name = 'sdSAMp2q2zawXcdz7oVg';

-- Seq Scan on cinema c  (cost=0.00..2185.00 rows=1 width=46)
--   Filter: ((cinema_name)::text = 'sdSAMp2q2zawXcdz7oVg'::text)

explain select * from cinema c  where c.cinema_address = 'eLWUCITdhGi9orRSnrA4';
-- Seq Scan on cinema c  (cost=0.00..2185.00 rows=1 width=46)
--   Filter: ((cinema_address)::text = 'eLWUCITdhGi9orRSnrA4'::text)

create index c_name on cinema using btree (cinema_name);

explain select * from cinema order by cinema_name;
-- Index Scan using c_name on cinema  (cost=0.42..7236.38 rows=100000 width=46)

explain select * from cinema order by cinema_name, cinema_address desc;
-- Sort  (cost=10239.82..10489.82 rows=100000 width=46)
--   Sort Key: cinema_name, cinema_address DESC
--   ->  Seq Scan on cinema  (cost=0.00..1935.00 rows=100000 width=46)

create index c_adr on cinema using btree (cinema_address);

-- Sort  (cost=10239.82..10489.82 rows=100000 width=46)
--   Sort Key: cinema_name, cinema_address DESC
--   ->  Seq Scan on cinema  (cost=0.00..1935.00 rows=100000 width=46)

create index c_adr_name on cinema using btree (cinema_name, cinema_address desc);

-- Index Scan using c_adr_name on cinema  (cost=0.42..8564.39 rows=100000 width=46)

create index s_price on session using btree (price);

explain 
select * from movie 
left join session on session.movie_id = movie.movie_id 
left join hall on hall.hall_id = session.hall_id 
where session.price > (200)::money
order by movie.movie_name ;

-- Sort  (cost=14346.75..14512.66 rows=66366 width=144)
--   Sort Key: movie.movie_name
--   ->  Hash Left Join  (cost=6447.00..9031.44 rows=66366 width=144)
--         Hash Cond: (session.hall_id = hall.hall_id)
--         ->  Hash Join  (cost=3279.00..5689.22 rows=66366 width=74)
--               Hash Cond: (session.movie_id = movie.movie_id)
--               ->  Seq Scan on session  (cost=0.00..2236.00 rows=66366 width=32)
--                     Filter: (price > (200)::money)
--               ->  Hash  (cost=2029.00..2029.00 rows=100000 width=42)
--                     ->  Seq Scan on movie  (cost=0.00..2029.00 rows=100000 width=42)
--         ->  Hash  (cost=1918.00..1918.00 rows=100000 width=39)
--               ->  Seq Scan on hall  (cost=0.00..1918.00 rows=100000 width=39)

select * from session
left join movie on movie.movie_id = session.movie_id
left join hall on hall.hall_id = session.hall_id;

-- Hash Left Join  (cost=6447.00..8708.02 rows=100000 width=113)
--   Hash Cond: (session.hall_id = hall.hall_id)
--   ->  Hash Left Join  (cost=3279.00..5277.51 rows=100000 width=74)
--         Hash Cond: (session.movie_id = movie.movie_id)
--         ->  Seq Scan on session  (cost=0.00..1736.00 rows=100000 width=32)
--         ->  Hash  (cost=2029.00..2029.00 rows=100000 width=42)
--               ->  Seq Scan on movie  (cost=0.00..2029.00 rows=100000 width=42)
--   ->  Hash  (cost=1918.00..1918.00 rows=100000 width=39)
--         ->  Seq Scan on hall  (cost=0.00..1918.00 rows=100000 width=39)

select * from session
left join movie on movie.movie_id = session.movie_id
left join hall on hall.hall_id = session.hall_id
where session.price > (200)::money;

-- Hash Left Join  (cost=6447.00..9031.44 rows=66366 width=113)
--   Hash Cond: (session.hall_id = hall.hall_id)
--   ->  Hash Left Join  (cost=3279.00..5689.22 rows=66366 width=74)
--         Hash Cond: (session.movie_id = movie.movie_id)
--         ->  Seq Scan on session  (cost=0.00..2236.00 rows=66366 width=32)
--               Filter: (price > (200)::money)
--         ->  Hash  (cost=2029.00..2029.00 rows=100000 width=42)
--               ->  Seq Scan on movie  (cost=0.00..2029.00 rows=100000 width=42)
--   ->  Hash  (cost=1918.00..1918.00 rows=100000 width=39)
--         ->  Seq Scan on hall  (cost=0.00..1918.00 rows=100000 width=39)


select * from session
left join movie on movie.movie_id = session.movie_id
left join hall on hall.hall_id = session.hall_id
where movie.movie_name = 'sdSAMp2q2zawXcdz7oVg';

-- Nested Loop Left Join  (cost=8.74..2007.32 rows=1 width=113)
--   ->  Hash Join  (cost=8.45..2006.96 rows=1 width=74)
--         Hash Cond: (session.movie_id = movie.movie_id)
--         ->  Seq Scan on session  (cost=0.00..1736.00 rows=100000 width=32)
--         ->  Hash  (cost=8.44..8.44 rows=1 width=42)
--               ->  Index Scan using m_n on movie  (cost=0.42..8.44 rows=1 width=42)
--                     Index Cond: ((movie_name)::text = 'w9TD3GSDXlvW398jqeTd6Tjq0pbWaK'::text)
--   ->  Index Scan using hall_pkey on hall  (cost=0.29..0.36 rows=1 width=39)
--         Index Cond: (hall_id = session.hall_id)