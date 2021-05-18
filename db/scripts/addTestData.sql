Create or replace function random_string(length integer) returns text as
$$
declare
  chars text[] := '{0,1,2,3,4,5,6,7,8,9,A,B,C,D,E,F,G,H,I,J,K,L,M,N,O,P,Q,R,S,T,U,V,W,X,Y,Z,a,b,c,d,e,f,g,h,i,j,k,l,m,n,o,p,q,r,s,t,u,v,w,x,y,z}';
  result text := '';
  i integer := 0;
begin
  if length < 0 then
    raise exception 'Given length cannot be less than 0';
  end if;
  for i in 1..length loop
    result := result || chars[1+random()*(array_length(chars, 1)-1)];
  end loop;
  return result;
end;
$$ language plpgsql;

-- Скрипты для добавления тестовых данных
-- movie_genre
insert into "movie_genre"("name")
  select 
  	random_string((1 + random()*24)::integer)
  from generate_series(1,30) as gs;
 
-- movie
 insert into "movie" ("name", age_limit, movie_genre_id)
 select
  random_string((1 + random()*24)::integer),
  (ARRAY['дети до 6 лет','дети до 12 лет','дети до 16 лет', 'дети до 18 лет'])[(random()*3)+1],
  (1 + random()*29)::integer
 from generate_series(1,100) as gs;

-- room_schema 
insert into room_schema ("row", "number", "room_id", "seat_id")
  select
    ((gs.id % 1000) / 50)::int +1,
    gs.id % 50 + 1,    
    (gs.id / 1000  + 1),
  	(ARRAY[1,2,3,4])[(random()*3)+1]
  from generate_series(0,3999) as gs(id);
 
 --schedule
insert into schedule (session_start , session_end , cost_base , movie_id, room_id)
  select
    gs::timestamp,
    gs::timestamp + interval '90' minute,
    (ARRAY[200,350,500,700])[(random()*3)+1],
    (10 + random()*9990)::integer,
    (ARRAY[1,2,3,4])[(extract(hour from gs)::int % 2) * 2 + extract(minute from gs)::int / 30 + 1]
 from generate_series('2021-01-01 00:00:00', '2021-12-31 23:59:59', interval '30 minute') as gs;

-- ticket
insert into ticket (schedule_id, room_schema_id, "cost")
select
 gs / 1000,
 gs % 4000 +1,
 (select cost_base from schedule s2 where id = gs/1000) *
 (select s.cost_factor from room_schema rs
   left join seat s on s.id = rs.seat_id where rs.id = gs % 4000 +1)
from generate_series(1000,17520000) as gs

-- Скрипты тестирования данных

-- 3 простых

-- выборка всех проданных билетов
explain (analyse, buffers) select * from ticket;
-- выборка всех билетов больше 1000
explain (analyse, buffers) select * from ticket where cost > 1000;
-- выборка все билетов на сеансы в промежутке
explain (analyse, buffers) select * from ticket where schedule_id between 1000 AND 2000;

-- 3 сложных

-- поиск суммы билетов стоимостью больше 1000, проданных на конкретный фильм
select m2.name, sum(t2.cost) from ticket t2 
left join schedule s2 on s2.id = t2.schedule_id
left join movie m2 on m2.id = s2.movie_id
where m2.id = 2137 and t2.cost > 1000
group by m2.id;
-- поиск фильмов где сборы перевалили за 5 млн
select m2."name", sum(t2.cost) as total_sum  from ticket t2 
left join schedule s2 on s2.id = t2.schedule_id 
left join movie m2 on s2.movie_id = m2.id 
group by m2.id
having sum(t2.cost) > 5000000
order by total_sum desc;

-- поиск самого кассового фильма
select movie.name,
       sum(ticket.cost) as total_sum from movie
                                              left join schedule on schedule.movie_id = movie.id
                                              left join ticket on ticket.schedule_id = schedule.id
where ticket.id is not null group by movie.id order by total_sum desc limit 1;

-- Вывод объектов базы данных
SELECT nspname || '.' || relname AS "relation",
    pg_size_pretty(pg_relation_size(C.oid)) AS "size"
  FROM pg_class C
  LEFT JOIN pg_namespace N ON (N.oid = C.relnamespace)
  WHERE nspname NOT IN ('pg_catalog', 'information_schema')
  ORDER BY pg_relation_size(C.oid) desc limit 15;
 
-- выводит информацию  об индексах
 select * from pg_stat_all_indexes where schemaname <> 'pg_catalog';

-- вспомогательные скрипты
delete from ticket;
ALTER SEQUENCE ticket_id_seq RESTART WITH 1;

delete from room_schema;
ALTER SEQUENCE room_schema_id_seq RESTART WITH 1;

delete from schedule;
ALTER SEQUENCE schedule_id_seq RESTART WITH 1;

 SELECT * FROM movie_genre;
 SELECT * FROM movie where id = 1;
 SELECT * FROM room where id = 1;
 SELECT * FROM seat;
 SELECT * FROM room_schema where id > 2;
 SELECT * FROM schedule order by id;
 SELECT * FROM ticket;
