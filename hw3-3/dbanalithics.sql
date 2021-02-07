/*CREATE TABLE cinema (
	id serial NOT NULL ,
    cinema_name varchar(255),
    total_placement smallint,
    PRIMARY KEY (id)
) ;

 CREATE TABLE cinema_hall (
	id serial NOT NULL ,
	hall_name varchar(255),
	placement smallint,
    cinema_id smallint ,
    PRIMARY KEY (id),
    FOREIGN KEY (cinema_id) REFERENCES cinema(id) ON DELETE cascade ON 
UPDATE cascade
    
);

CREATE TABLE movie (
	id serial NOT NULL ,
    title varchar(255),
    description varchar(255),
	PRIMARY KEY (id)
);


CREATE TABLE movie_attr_type (
    id serial NOT NULL  PRIMARY KEY ,
    name varchar(255) ,
    comment text 
);


CREATE TABLE movie_attr (
    id serial NOT NULL  PRIMARY KEY ,
    name varchar(255),
    movie_attr_type_id integer NOT NULL
);



CREATE TABLE movie_attr_values (
    id serial NOT NULL  PRIMARY KEY,
    attr_id integer NOT NULL,
    val_date date,
    val_text varchar(255),
    val_num numeric(10,10),
    movie_id integer NOT NULL
);

CREATE TABLE session_type (
	id serial NOT NULL  ,
	type_name varchar(255),
    PRIMARY KEY (id)
);

CREATE TABLE movie_session (
	id serial NOT NULL ,
	time_start timestamp,
    time_end timestamp,
	movie_id integer,
    hall_id smallint ,
    session_type_id integer,
    FOREIGN KEY (session_type_id) REFERENCES session_type(id) ON DELETE 
cascade ON UPDATE cascade,
    PRIMARY KEY (id)
);

CREATE TABLE seat_type (
	id serial NOT NULL ,
	type_name varchar(255),
    PRIMARY KEY (id)
);

CREATE TABLE price_rule (
	id serial NOT NULL ,
	session_id integer,
    seat_type_id integer,
    price integer,
	FOREIGN KEY (session_id) REFERENCES movie_session(id) ON DELETE 
cascade ON UPDATE cascade,
    FOREIGN KEY (seat_type_id) REFERENCES seat_type(id) ON DELETE 
cascade ON UPDATE cascade,
	PRIMARY KEY (id)
);

CREATE TABLE seat (
	id serial NOT NULL ,
	hall_id smallint,
    seat_type_id integer,
    FOREIGN KEY (seat_type_id) REFERENCES seat_type(id) ON DELETE 
cascade ON UPDATE cascade,
    PRIMARY KEY (id)
);


CREATE TABLE ticket (
	id serial NOT NULL ,
    price_rule_id integer,
    seat_id integer,
    FOREIGN KEY (price_rule_id) REFERENCES price_rule(id),
	PRIMARY KEY (id)
);

insert into cinema(cinema_name,total_placement) values 
('the_only_cinema_in_town',400);

insert into cinema_hall(hall_name,placement,cinema_id) values 
('blue',100,3);
insert into cinema_hall(hall_name,placement,cinema_id) values 
('red',100,3);
insert into cinema_hall(hall_name,placement,cinema_id) values 
('yellow',200,3);

insert into movie(title,description) 
values ('hobbit1','the good one');
insert into movie(title,description) 
values ('hobbit2','not the good one');
insert into movie(title,description) 
values ('hobbit3','the bad one');
insert into movie(title,description) 
values ('matrix1','the good one');
insert into movie(title,description) 
values ('matrix2','not the good one');
insert into movie(title,description) 
values ('matrix3','the bad one');

insert into session_type(type_name) values ('day');
insert into session_type(type_name) values ('night');*/

/*insert into 
movie_session(time_start,time_end,movie_id,hall_id,session_type_id) 
values ('2011-10-10 21:00:00','2011-10-10 23:00:00',1,1,3);
insert into 
movie_session(time_start,time_end,movie_id,hall_id,session_type_id) 
values ('2011-01-10 11:00:00','2011-10-10 13:00:00',1,3,4);
insert into 
movie_session(time_start,time_end,movie_id,hall_id,session_type_id) 
values ('2015-10-09 11:00:00','2015-10-10 13:00:00',2,1,3);
insert into 
movie_session(time_start,time_end,movie_id,hall_id,session_type_id) 
values ('2016-10-10 21:00:00','2016-10-10 23:00:00',2,1,4);
insert into 
movie_session(time_start,time_end,movie_id,hall_id,session_type_id) 
values ('2015-10-10 21:00:00','2015-10-10 23:00:00',3,1,3);
insert into 
movie_session(time_start,time_end,movie_id,hall_id,session_type_id) 
values ('2016-02-10 21:00:00','2016-02-10 23:00:00',4,1,4);
insert into 
movie_session(time_start,time_end,movie_id,hall_id,session_type_id) 
values ('2017-10-10 11:00:00','2017-10-10 13:00:00',5,1,3);
insert into 
movie_session(time_start,time_end,movie_id,hall_id,session_type_id) 
values ('2017-10-10 21:00:00','2017-10-10 23:00:00',5,2,3);
insert into 
movie_session(time_start,time_end,movie_id,hall_id,session_type_id) 
values ('2017-10-10 21:00:00','2017-10-10 23:00:00',5,3,3);
insert into 
movie_session(time_start,time_end,movie_id,hall_id,session_type_id) 
values ('2018-10-10 21:00:00','2018-10-10 23:00:00',6,1,3);
insert into 
movie_session(time_start,time_end,movie_id,hall_id,session_type_id) 
values ('2018-10-10 21:00:00','2018-10-10 23:00:00',6,1,4);


insert into seat_type(type_name) values ('normal');
insert into seat_type(type_name) values ('luxury');

insert into price_rule(seat_type_id,session_id,price) values 
('23','48',100);
insert into price_rule(seat_type_id,session_id,price) values 
('23','49',200);
insert into price_rule(seat_type_id,session_id,price) values 
('23','50',120);
insert into price_rule(seat_type_id,session_id,price) values 
('23','51',100);
insert into price_rule(seat_type_id,session_id,price) values 
('23','52',150);
insert into price_rule(seat_type_id,session_id,price) values 
('23','53',220);
insert into price_rule(seat_type_id,session_id,price) values 
('23','54',250);
insert into price_rule(seat_type_id,session_id,price) values 
('23','55',260);
insert into price_rule(seat_type_id,session_id,price) values 
('23','56',290);
insert into price_rule(seat_type_id,session_id,price) values 
('23','57',100);
insert into price_rule(seat_type_id,session_id,price) values 
('23','58',90);
insert into price_rule(seat_type_id,session_id,price) values 
('24','58',190);
insert into price_rule(seat_type_id,session_id,price) values 
('24','58',90);
*/


/*Create or replace function set_seats() returns text as
$$
declare
  
  result text := '';
  i integer := 0;
begin
  
  for i in 1..100 loop
     insert into seat(hall_id,seat_type_id) values ('7', FLOOR( 23 + random( ) * 2 ));
  end loop;
  for i in 1..100 loop
     insert into seat(hall_id,seat_type_id) values ('8', FLOOR( 23 + random( ) * 2 ));
  end loop;
  for i in 1..200 loop
     insert into seat(hall_id,seat_type_id) values ('9', FLOOR( 23 + random( ) * 2 ));
  end loop;
  return result;
end;
$$ language plpgsql;

select set_seats();

insert into ticket(price_rule_id,seat_id) values ('12',2);
insert into ticket(price_rule_id,seat_id)  values ('2',3);
insert into ticket(price_rule_id,seat_id)  values ('3',8);
insert into ticket(price_rule_id,seat_id)  values ('4',330);
insert into ticket(price_rule_id,seat_id)  values ('5',150);
insert into ticket(price_rule_id,seat_id)  values ('6',220);
insert into ticket(price_rule_id,seat_id)  values ('7',250);
insert into ticket(price_rule_id,seat_id)  values ('8',260);
insert into ticket(price_rule_id,seat_id)  values ('9',290);
insert into ticket(price_rule_id,seat_id)  values ('10',100);
insert into ticket(price_rule_id,seat_id)  values ('11',90);



select SUM(price_rule.price),  movie_session.movie_id  
from ticket 
left join price_rule on ticket.price_rule_id = price_rule.id
left join movie_session on price_rule.session_id = movie_session.id 
group by movie_session.movie_id order by SUM(price_rule.price) desc 
limit 1;*/

-- запрос на увеличение таблицы до 10К записей
/*

Create or replace function set_tickets() returns text as 
$$
declare
  result text := '';
  i integer := 0;
begin
  for i in 1..10000 loop
     insert into ticket(price_rule_id,seat_id) values (FLOOR( 2 + random( ) * 13 ), FLOOR( 1 + random( ) * 400 ));
  end loop;
  return result;
end;
$$ language plpgsql;

select set_tickets();*/

-- запросы к бд 

--SELECT  * from ticket WHERE seat_id = 123;
--SELECT * FROM ticket WHERE price_rule_id = 10 ORDER BY id;
--SELECT * FROM movie_session WHERE movie_id = 3 AND hall_id = 1 ORDER BY time_start;

/*SELECT count (ti.id) AS count_luxury_seats FROM ticket ti
JOIN price_rule pr ON pr.id = ti.price_rule_id
JOIN seat_type st ON st.id = pr.seat_type_id
WHERE pr.seat_type_id = 24;*/


/*select SUM(price_rule.price),  movie_session.movie_id  
from ticket 
left join price_rule on ticket.price_rule_id = price_rule.id
left join movie_session on price_rule.session_id = movie_session.id 
group by movie_session.movie_id order by SUM(price_rule.price) desc 
limit 5;*/

/*SELECT count(ti.id) AS count_day_session_sels FROM ticket ti
left JOIN price_rule pr ON pr.id = ti.price_rule_id
left JOIN movie_session ms ON ms.id = pr.session_id
left JOIN session_type st ON st.id = ms.session_type_id
WHERE st.type_name = 'day';*/


-- план выполнения запросов к таблице на 10К строк

--explain SELECT * FROM movie_session WHERE movie_id = 3 AND hall_id = 1 ORDER BY time_start;

--"Sort  (cost=1.13..1.14 rows=1 width=30)"
--"  Sort Key: time_start"
--"  ->  Seq Scan on movie_session  (cost=0.00..1.12 rows=1 width=30)"
--"        Filter: ((movie_id = 3) AND (hall_id = 1))"


/*explain SELECT count (ti.id) AS count_luxury_seats FROM ticket ti
JOIN price_rule pr ON pr.id = ti.price_rule_id
JOIN seat_type st ON st.id = pr.seat_type_id
WHERE pr.seat_type_id = 24;*/

/*"Aggregate  (cost=223.32..223.33 rows=1 width=8)"
"  ->  Nested Loop  (cost=33.38..223.20 rows=49 width=4)"
"        ->  Index Only Scan using seat_type_pkey on seat_type st  (cost=0.14..8.16 rows=1 width=4)"
"              Index Cond: (id = 24)"
"        ->  Hash Join  (cost=33.24..214.54 rows=49 width=8)"
"              Hash Cond: (ti.price_rule_id = pr.id)"
"              ->  Seq Scan on ticket ti  (cost=0.00..155.00 rows=10000 width=8)"
"              ->  Hash  (cost=33.12..33.12 rows=9 width=8)"
"                    ->  Seq Scan on price_rule pr  (cost=0.00..33.12 rows=9 width=8)"
"                          Filter: (seat_type_id = 24)"*/

-- увеличиваем количество записей до 100К


/*Create or replace function set_tickets_100k() returns text as 
$$
declare
  result text := '';
  i integer := 0;
begin
  for i in 1..90000 loop
     insert into ticket(price_rule_id,seat_id) values (FLOOR( 2 + random( ) * 13 ), FLOOR( 1 + random( ) * 400 ));
  end loop;
  return result;
end;
$$ language plpgsql;

select set_tickets_100k();*/

-- план выполнения запросов к таблице на 100К строк

--explain SELECT * FROM movie_session WHERE movie_id = 3 AND hall_id = 1 ORDER BY time_start;

/*"Sort  (cost=1.13..1.14 rows=1 width=30)"
"  Sort Key: time_start"
"  ->  Seq Scan on movie_session  (cost=0.00..1.12 rows=1 width=30)"
"        Filter: ((movie_id = 3) AND (hall_id = 1))"*/

/*explain SELECT count (ti.id) AS count_luxury_seats FROM ticket ti
JOIN price_rule pr ON pr.id = ti.price_rule_id
JOIN seat_type st ON st.id = pr.seat_type_id
WHERE pr.seat_type_id = 24;


"Aggregate  (cost=1851.58..1851.59 rows=1 width=8)"
"  ->  Nested Loop  (cost=33.38..1850.36 rows=486 width=4)"
"        ->  Index Only Scan using seat_type_pkey on seat_type st  (cost=0.14..8.16 rows=1 width=4)"
"              Index Cond: (id = 24)"
"        ->  Hash Join  (cost=33.24..1837.34 rows=486 width=8)"
"              Hash Cond: (ti.price_rule_id = pr.id)"
"              ->  Seq Scan on ticket ti  (cost=0.00..1541.00 rows=100000 width=8)"
"              ->  Hash  (cost=33.12..33.12 rows=9 width=8)"*/

--АНАЛИЗ ЗАПРОСА С ИНДЕКСАМИ И БЕЗ

--добавим индекс

--create index "luxury" on price_rule (seat_type_id) ;

-- выполним запрос

/*explain SELECT count (ti.id) AS count_luxury_seats FROM ticket ti
JOIN price_rule pr ON pr.id = ti.price_rule_id
JOIN seat_type st ON st.id = pr.seat_type_id
WHERE pr.seat_type_id = 24;

"Aggregate  (cost=890.67..890.68 rows=1 width=8)"
"  ->  Nested Loop  (cost=148.18..871.44 rows=7692 width=4)"
"        ->  Nested Loop  (cost=0.14..9.33 rows=1 width=4)"
"              ->  Seq Scan on price_rule pr  (cost=0.00..1.16 rows=1 width=8)"
"                    Filter: (seat_type_id = 24)"
"              ->  Index Only Scan using seat_type_pkey on seat_type st  (cost=0.14..8.16 rows=1 width=4)"
"                    Index Cond: (id = 24)"
"        ->  Bitmap Heap Scan on ticket ti  (cost=148.03..785.18 rows=7692 width=8)"
"              Recheck Cond: (price_rule_id = pr.id)"
"              ->  Bitmap Index Scan on luxury  (cost=0.00..146.11 rows=7692 width=0)"
"                    Index Cond: (price_rule_id = pr.id)" */


-- имеем значительный прирост производительности



--часто используемые

/*select indexrelname AS index_name, stat.idx_scan AS index_scans_count
from pg_stat_user_indexes AS stat
join pg_indexes as pgi on indexrelname = indexname AND stat.schemaname = pgi.schemaname
join pg_stat_user_tables AS tabstat on stat.relid = tabstat.relid
ORDER by stat.idx_scan DESC limit 5

"price_rule_pkey"	110030
"seat_type_pkey"	430
"session_type_pkey"	58
"cinema_pkey"	9
"movie_pkey"	3 */

--редко используемые

/*select indexrelname AS index_name, stat.idx_scan AS index_scans_count
from pg_stat_user_indexes AS stat
join pg_indexes as pgi on indexrelname = indexname AND stat.schemaname = pgi.schemaname
join pg_stat_user_tables AS tabstat on stat.relid = tabstat.relid
ORDER by stat.idx_scan asc limit 5  

"cinema_hall_pkey"	0
"movie_attr_values_pkey"	0
"movie_attr_type_pkey"	0
"movie_attr_pkey"	0
"seat_pkey"	0    */


--массивные объекты бд

/*SELECT c.relname as "Name",
  CASE c.relkind WHEN 'r' THEN 'table' WHEN 'v' THEN 'view' WHEN 'm' THEN 'materialized view' WHEN 'i' THEN 'index' WHEN 'S' THEN 'sequence' WHEN 's' THEN 'special' WHEN 'f' THEN 'foreign table' WHEN 'p' THEN 'table' WHEN 'I' THEN 'index' END as "Type",
  pg_catalog.pg_get_userbyid(c.relowner) as "Owner",
  pg_catalog.pg_table_size(c.oid) as "Size"
FROM pg_catalog.pg_class c
     LEFT JOIN pg_catalog.pg_namespace n ON n.oid = c.relnamespace
     LEFT JOIN pg_catalog.pg_index i ON i.indexrelid = c.oid
     LEFT JOIN pg_catalog.pg_class c2 ON i.indrelid = c2.oid
WHERE c.relkind IN ('r','p','v','m','S','s','f','i','I','')
      AND n.nspname !~ '^pg_toast'
      AND n.nspname = 'public'
ORDER BY "Size" DESC
LIMIT 15


"ticket"	"table"	"testuser"	4456448
"luxury"	"index"	"testuser"	2277376
"ticket_pkey"	"index"	"testuser"	2260992
"seat"	"table"	"testuser"	49152
"cinema_pkey"	"index"	"testuser"	16384
"test"	"index"	"testuser"	16384
"seat_type_pkey"	"index"	"testuser"	16384
"movie_pkey"	"index"	"testuser"	16384
"cinema_hall_pkey"	"index"	"testuser"	16384
"movie_session_pkey"	"index"	"testuser"	16384
"movie"	"table"	"testuser"	16384
"seat_pkey"	"index"	"testuser"	16384
"session_type_pkey"	"index"	"testuser"	16384
"price_rule_pkey"	"index"	"testuser"	16384
"movie_attr_pkey"	"index"	"testuser"	8192


*/