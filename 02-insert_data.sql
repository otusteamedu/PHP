insert into cinema (cinema_name, cinema_address ) 
select random_string(20) as cinema_name, random_string(20) as cinema_address from pg_catalog.generate_series(1, 100) as a(n); 

insert into hall (hall_name, cinema_id) 
select random_string(30) as hall_name, cinema.id from cinema;

insert into movie (movie_name, format, duration)
select random_string(30) as movie_name, '2D', round(random()*40) + 80 as duration from pg_catalog.generate_series(1, 100) as a;

insert into session (data, start, hall_id, movie_id, price)
select date(NOW() + (random() * (NOW()+'90 days' - NOW())) + '30 days') as data , 
		time '10:00' as time, 
		round(random() * 100) + 1 as hall_id, movie_id, 
		100 as price
from movie;



-- 10000

insert into cinema (cinema_name, cinema_address ) 
select random_string(20) as cinema_name, random_string(20) as cinema_address from pg_catalog.generate_series(1, 9900) as a(n); 

insert into hall (hall_name, cinema_id) 
select random_string(30) as hall_name, cinema.id from cinema;

insert into movie (movie_name, format, duration)
select random_string(30) as movie_name, '2D', round(random()*40) + 80 as duration from pg_catalog.generate_series(1, 9900) as a;

insert into session (data, start, hall_id, movie_id, price)
select date(NOW() + (random() * (NOW()+'90 days' - NOW())) + '30 days') as data , 
		time '10:00' as time, 
		round(random() * 100) + 1 as hall_id, movie_id, 
		100 as price
from movie;


-- 10000000 - 10000 = 9990000


delete from cinema;
insert into cinema (cinema_name, cinema_address ) 
select random_string(20) as cinema_name, random_string(20) as cinema_address from pg_catalog.generate_series(1, 100000) as a(n); 

delete from hall;
insert into hall (hall_name, cinema_id) 
select random_string(30) as hall_name, cinema.id from cinema;

delete from movie;
insert into movie (movie_name, format, duration)
select random_string(30) as movie_name, '2D', round(random()*40) + 80 as duration from pg_catalog.generate_series(1, 100000) as a;

delete from session;
insert into session (data, start, hall_id, movie_id, price)
select date(NOW() + (random() * (NOW()+'90 days' - NOW())) + '30 days') as data , 
		time '10:00' as time, 
		round(random() * 100000) + 1 as hall_id, movie_id, 
		(round( random() * 300) + 100)::int as price
from movie;