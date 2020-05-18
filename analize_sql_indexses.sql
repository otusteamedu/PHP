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

drop table if exists cinema;

CREATE TABLE public.cinema (
	id serial NOT NULL,
	cinema_name varchar(255) NOT NULL,
	cinema_address varchar(255) NOT NULL
);

insert into cinema (cinema_name, cinema_address)
select random_string(10), random_string(10) from pg_catalog.generate_series(1, 1000000);

-- работаем в один поток.
SET max_parallel_workers_per_gather TO 0;

explain
select * from cinema where id = 1;

-- Seq Scan on cinema  (cost=0.00..19853.00 rows=1 width=26)
--   Filter: (id = 1)

-- мы видим что у нас очень высокая стоимость, в зависимости от того где будет этот индекс, так как его будут искать последовательно.
-- он может быть вначале, тогда стоимость 0, может в конце.


-- создадим индекс для ID
create index cinema_id on cinema (id);
-- повторяем процедуру

explain
select * from cinema where id = 1;
-- Index Scan using cinema_id on cinema  (cost=0.42..8.44 rows=1 width=26)
--   Index Cond: (id = 1)
-- используется для поиска индекс с именем cinema_id
-- мы видим что стоимость упала очень сильно, начальная стоиморсть 0.42, вместо 0, потому что использование индексов операция не бесплатная.

explain
select * from cinema where id > 500000;
-- Index Scan using cinema_id on cinema  (cost=0.42..17724.62 rows=494468 width=26)
--   Index Cond: (id > 500000)
-- точно так же используется индекс.

explain
select * from cinema where id > 0;
-- если мы выполним такой запрос, то умный Postgres сравнит стоимости и предпочтет последовательный поиск.
-- потому что начальная стоимость в этом случае 0.

-- Seq Scan on cinema  (cost=0.00..19853.00 rows=999990 width=26)
--   Filter: (id > 10)

-- найдем какой нибудь кинотеатр например командой:
select * from cinema where id = 600000;

-- 600000	hatxW7AaTC	yMPrMjJIJh
-- и будем искать по названию и адресу, дабы понять чего нам это будет стоить.

select * from cinema where cinema_name = 'hatxW7AaTC';
-- интересно то, что результат получен за 263мс.

explain
select * from cinema where cinema_name = 'hatxW7AaTC';
-- Seq Scan on cinema  (cost=0.00..19853.00 rows=1 width=26)
--   Filter: ((cinema_name)::text = 'hatxW7AaTC'::text)

-- в принципе мы имеем такую же стоимость как и при поиске ID т.е. числа.
explain
select * from cinema where cinema_name = 'ha%';

-- Seq Scan on cinema  (cost=0.00..19853.00 rows=1 width=26)
--   Filter: ((cinema_name)::text = 'ha%'::text)

-- создаем индекс 
create index idx_cinema_name on cinema (cinema_name);
-- и повторяем запрос
explain
select * from cinema where cinema_name = 'ha%';

-- Index Scan using idx_cinema_name on cinema  (cost=0.42..8.44 rows=1 width=26)
--   Index Cond: ((cinema_name)::text = 'ha%'::text)
-- и тут я понимаю что ошибся, потому что надо использовать LIKE
-- дропаем индекс, переписываем все запросы
drop index idx_cinema_name;

explain
select * from cinema where cinema_name LIKE 'ha%';

-- Seq Scan on cinema  (cost=0.00..19853.00 rows=100 width=26)
--   Filter: ((cinema_name)::text ~~ 'ha%'::text)
-- получаем ту же максимальную стоимость изза обычного перебора записей. видим что по нашему запросу возвращается 100 записей.
-- а давайте их выведем!

select * from cinema where cinema_name LIKE 'ha%';
-- получены за 266мс, PostgreSQL молодец, я думал будет сильно дольше.

-- создаем индекс
create index idx_cinema_name on cinema (cinema_name);
-- и пробуем еще раз.
explain
select * from cinema where cinema_name LIKE 'ha%';
-- Seq Scan on cinema  (cost=0.00..19853.00 rows=100 width=26)
--   Filter: ((cinema_name)::text ~~ 'ha%'::text)
-- Postgresql предпочел обычный перебор
-- подключим сюда поле адреса.

explain
select * from cinema where cinema_name LIKE 'hab%' and cinema_address like 'ha%';

-- Seq Scan on cinema  (cost=0.00..22353.00 rows=1 width=26)
--   Filter: (((cinema_name)::text ~~ 'hab%'::text) AND ((cinema_address)::text ~~ 'ha%'::text))
-- сильно выросла стоимость.

explain
select * from cinema where cinema_name LIKE 'hab%' or cinema_address like 'ha%';
-- Seq Scan on cinema  (cost=0.00..22353.00 rows=200 width=26)
--   Filter: (((cinema_name)::text ~~ 'hab%'::text) OR ((cinema_address)::text ~~ 'ha%'::text))
-- OR или AND стоимость не меняют. Что будет если мы создадим индекс и для адреса.
create index idx_cinema_address on cinema (cinema_address);

-- Seq Scan on cinema  (cost=0.00..22353.00 rows=200 width=26)
--   Filter: (((cinema_name)::text ~~ 'hab%'::text) OR ((cinema_address)::text ~~ 'ha%'::text))

select * from cinema where id = 40000 or id = 700000;
-- берем две строки и будем искать с теми же условиями только точные наименования
-- 40000	Un7ZrkVU7H	V5JddlI4Gz
-- 700000	cEpW2sKXpi	135PNvodSe

explain
select * from cinema where cinema_name = 'Un7ZrkVU7H' and cinema_address = '135PNvodSe';
-- Index Scan using idx_cinema_address on cinema  (cost=0.42..8.45 rows=1 width=26)
--   Index Cond: ((cinema_address)::text = '135PNvodSe'::text)
--   Filter: ((cinema_name)::text = 'Un7ZrkVU7H'::text)
-- верхняя граница стоимости сменилась с 8.44 для одного значения на 8.45 для двух значений.
-- так как тут AND действие, он должен найти все cinema_name и сравнить address тот же что в условии или нет, поэтому
-- стоимость не увеличивается сильно.

explain
select * from cinema where cinema_name = 'Un7ZrkVU7H' or cinema_address = '135PNvodSe';
-- Bitmap Heap Scan on cinema  (cost=8.87..16.80 rows=2 width=26)
--   Recheck Cond: (((cinema_name)::text = 'Un7ZrkVU7H'::text) OR ((cinema_address)::text = '135PNvodSe'::text))
--   ->  BitmapOr  (cost=8.87..8.87 rows=2 width=0)
--         ->  Bitmap Index Scan on idx_cinema_name  (cost=0.00..4.43 rows=1 width=0)
--               Index Cond: ((cinema_name)::text = 'Un7ZrkVU7H'::text)
--         ->  Bitmap Index Scan on idx_cinema_address  (cost=0.00..4.43 rows=1 width=0)
--               Index Cond: ((cinema_address)::text = '135PNvodSe'::text)
-- тут логично что стоимость увеличивается в два раза, потому что ему надо пройтись по записям два раза сначала для одного столбца,
-- потом для другого и вернуть и те и другие

-- посмотрим сколько по времени это занимает.
select * from cinema where cinema_name = 'Un7ZrkVU7H' or cinema_address = '135PNvodSe';
-- это занимает 32мс.
drop index idx_cinema_name;
drop index idx_cinema_address;

select * from cinema where cinema_name = 'Un7ZrkVU7H' or cinema_address = '135PNvodSe';
-- без индексов это занимает 297мс, практически в 10 раз больше времени.

-- сделаем составной индекс
create index idx_cinema_name_address on cinema (cinema_name, cinema_address);

select * from cinema where cinema_name = 'Un7ZrkVU7H' or cinema_address = '135PNvodSe';
-- запрос выполняется за 336мс.
-- понимаем что он будет работать только в том случае когда у нас выполняется запрос с выражением AND

explain
select * from cinema where cinema_name = 'Un7ZrkVU7H' or cinema_address = '135PNvodSe';
-- Seq Scan on cinema  (cost=0.00..22353.00 rows=2 width=26)
--   Filter: (((cinema_name)::text = 'Un7ZrkVU7H'::text) OR ((cinema_address)::text = '135PNvodSe'::text))
-- что и подтверждает наш Explain будет выполнен последовательный поиск, индекс не используется.





CREATE TABLE public.hall (
	hall_id serial NOT NULL,
	hall_name varchar(255) NULL,
	cinema_id int4 NULL
);

-- добавляем значения
insert into hall (hall_name, cinema_id) select random_string(10) as hall_name, id as cinema_id from cinema;

select * from cinema left join hall on hall.cinema_id = cinema.id;
-- запрос выполняется за 632мс.

explain
select * from cinema left join hall on hall.cinema_id = cinema.id;

-- Hash Left Join  (cost=34730.00..85365.00 rows=1000000 width=45)
--   Hash Cond: (cinema.id = hall.cinema_id)
--   ->  Seq Scan on cinema  (cost=0.00..17353.00 rows=1000000 width=26)
--   ->  Hash  (cost=16370.00..16370.00 rows=1000000 width=19)
--         ->  Seq Scan on hall  (cost=0.00..16370.00 rows=1000000 width=19)

-- видим просто ужасные цифры для стоимости.
-- добавим индекс для hall.hall_id
create index idx_hall_id on hall(hall_id);

select * from cinema left join hall on hall.cinema_id = cinema.id;
-- запрос выполняется за 482мс, уже лучше, но не фонтан

-- Hash Left Join  (cost=34730.00..85365.00 rows=1000000 width=45)
--   Hash Cond: (cinema.id = hall.cinema_id)
--   ->  Seq Scan on cinema  (cost=0.00..17353.00 rows=1000000 width=26)
--   ->  Hash  (cost=16370.00..16370.00 rows=1000000 width=19)
--         ->  Seq Scan on hall  (cost=0.00..16370.00 rows=1000000 width=19)

-- но, тут я понял что ошибся, все равно для всей таблицы он будет собирать всю таблицу, стоимость не поменяется.
drop index idx_hall_id;
-- дропаем индес. и пробуем выполнить условие.
select * from cinema left join hall on hall.cinema_id = cinema.id 
where cinema_name = 'Un7ZrkVU7H';
-- выполняется за 253мс.
explain
select * from cinema left join hall on hall.cinema_id = cinema.id 
where cinema_name = 'Un7ZrkVU7H';
-- Hash Right Join  (cost=8.46..20128.47 rows=1 width=45)
--   Hash Cond: (hall.cinema_id = cinema.id)
--   ->  Seq Scan on hall  (cost=0.00..16370.00 rows=1000000 width=19)
--   ->  Hash  (cost=8.44..8.44 rows=1 width=26)
--         ->  Index Scan using idx_cinema_name_address on cinema  (cost=0.42..8.44 rows=1 width=26)
--               Index Cond: ((cinema_name)::text = 'Un7ZrkVU7H'::text)
-- тут у нас название кинотеатра ищется через индекс, а вот присоединяется таблица hall через последовательный поиск hall_id
-- еще раз создаем индекс 
create index idx_hall_id on hall(hall_id);
-- и видим
explain
select * from cinema left join hall on hall.cinema_id = cinema.id 
where cinema_name = 'Un7ZrkVU7H';
-- Hash Right Join  (cost=8.46..20128.47 rows=1 width=45)
--   Hash Cond: (hall.cinema_id = cinema.id)
--   ->  Seq Scan on hall  (cost=0.00..16370.00 rows=1000000 width=19)
--   ->  Hash  (cost=8.44..8.44 rows=1 width=26)
--         ->  Index Scan using idx_cinema_name_address on cinema  (cost=0.42..8.44 rows=1 width=26)
--               Index Cond: ((cinema_name)::text = 'Un7ZrkVU7H'::text)
-- и видим то же самое, понимаем что очень поздно и понимаем что начинаем сильно тупить :))))))))))
-- индекс повесил не на hall.cinema_id через который подключаюсь к этой таблице а к hall_id, что в этом случае бесполезно
-- делаем новый индекс
create index idx_hall_cinema_id on hall(cinema_id);
-- повторяем запрос
explain
select * from cinema left join hall on hall.cinema_id = cinema.id 
where cinema_name = 'Un7ZrkVU7H';
-- Nested Loop Left Join  (cost=0.85..16.90 rows=1 width=45)
--   ->  Index Scan using idx_cinema_name_address on cinema  (cost=0.42..8.44 rows=1 width=26)
--         Index Cond: ((cinema_name)::text = 'Un7ZrkVU7H'::text)
--   ->  Index Scan using idx_hall_cinema_id on hall  (cost=0.42..8.44 rows=1 width=19)
--         Index Cond: (cinema_id = cinema.id)
-- и там и там используется индекс, стоимость которого ничтожна по сравнению с последовательным обходом записей.





