CREATE TABLE public.cinema (
	id serial NOT NULL,
	cinema_name varchar(255) NOT NULL,
	cinema_address varchar(255) NOT NULL,
	CONSTRAINT cinema_pkey PRIMARY KEY (id)
);

CREATE TABLE public.hall (
	hall_id serial NOT NULL,
	hall_name varchar(255) NULL,
	cinema_id int4 NULL,
	CONSTRAINT hall_pkey PRIMARY KEY (hall_id),
	CONSTRAINT hall_fk FOREIGN KEY (cinema_id) REFERENCES cinema(id)
);

CREATE TABLE public.movie (
	movie_id serial NOT NULL,
	movie_name varchar(255) NULL,
	format varchar(2) NOT NULL,
	duration int4 NOT NULL,
	CONSTRAINT movie_pkey PRIMARY KEY (movie_id)
);

CREATE TABLE public."session" (
	session_id serial NOT NULL,
	"data" date NULL,
	"start" time NULL,
	hall_id int4 NULL,
	movie_id int4 NULL,
	price money NOT NULL,
	CONSTRAINT session_pkey PRIMARY KEY (session_id),
	CONSTRAINT session_fk FOREIGN KEY (movie_id) REFERENCES movie(movie_id),
	CONSTRAINT session_fk_1 FOREIGN KEY (hall_id) REFERENCES hall(hall_id)
);




CREATE TABLE public.ticket (
	ticket_id serial NOT NULL,
	session_id int4 NULL,
	hall_row int4 NULL,
	hall_place int4 NULL,
	price money NOT NULL DEFAULT 0,
	CONSTRAINT ticket_pkey PRIMARY KEY (ticket_id),
	CONSTRAINT ticket_fk FOREIGN KEY (session_id) REFERENCES session(session_id)
);

-- самый прибыльный фильм
select movie.movie_name, sum("session".price) as sum from ticket
left join "session" ON "session".session_id = ticket.session_id
left join movie on movie.movie_id = "session".movie_id group by "movie".movie_id order by sum desc limit 1;

-- Добавление EAV для фильмов

CREATE TYPE movie_attributes AS ENUM (
	'string',
	'int',
	'date',
	'float',
	'boolean',
	'array');


CREATE TABLE public.movie_attr (
	ma_id serial NOT NULL,
	attr_name varchar(255) NOT NULL,
	attr_type movie_attributes NULL,
	CONSTRAINT movie_attr_pkey PRIMARY KEY (ma_id)
);

CREATE INDEX movie_attr_attr_type_idx ON public.movie_attr USING btree (attr_type);

CREATE TABLE public.movie_attr_value (
	mav_id serial NOT NULL,
	m_id int4 NOT NULL,
	ma_id int4 NOT NULL,
	attr_value text NULL,
	CONSTRAINT movie_attr_value_pkey PRIMARY KEY (mav_id),
	CONSTRAINT movie_attr_value_fk FOREIGN KEY (ma_id) REFERENCES movie_attr(ma_id),
	CONSTRAINT movie_attr_value_fk_1 FOREIGN KEY (m_id) REFERENCES movie(movie_id)
);

CREATE INDEX movie_attr_value_m_id_idx ON public.movie_attr_value USING btree (m_id, ma_id);

-- работаем примерно так.
insert into movie_attr (attr_name, attr_type) values ('Премьера', 'date');
insert into movie_attr (attr_name, attr_type) values ('Режисеры', 'array');
insert into movie_attr (attr_name, attr_type) values ('Актеры', 'array');


alter type movie_attributes add value 'array';

select * from movie;

select * from movie_attr;


insert into movie_attr_value (m_id, ma_id, attr_value ) values (1, 1, '2019-12-26');
insert into movie_attr_value (m_id, ma_id, attr_value ) values (1, 2, 'Клим Алексеевич Шипенко');

insert into movie_attr_value (m_id, ma_id, attr_value ) values (1, 3, 'Клим Шипенко,Милош Бикович,Александра Бортич,Александр Самойленко,Иван Охлобыстин,Мария Миронова,Олег Комаров,Ольга Дибцева,Кирилл Нагиев,Сергей Соцердотский');

-- выборка данных в таком формате, поле attr_type скажет коду, в каком формате обрабатывать данные. например array ->    $actors = explode(",", $actors); получаем список актеров.
select movie_name, attr_name, attr_value, attr_type from movie left join movie_attr_value mav on mav.m_id = movie.movie_id
left join movie_attr ma on ma.ma_id = mav.ma_id 
where movie.movie_id = 1;

-- расширяем функциональность EAV

alter table public.movie_attr_value add column attr_value_id int4 null;

delete from movie_attr_value;

alter table public.movie_attr_value add column attr_value_id int4 null;

delete from movie_attr_value;

insert into movie_attr (attr_name, attr_type) values ('Жанры', 'array');
insert into movie_attr (attr_name, attr_type) values ('Постеры', 'array');

drop INDEX movie_attr_value_m_id_idx;

CREATE UNIQUE INDEX movie_attr_value_m_id_idx2 ON public.movie_attr_value (m_id,ma_id,attr_value);

insert into movie_attr_value (m_id, ma_id, attr_value ) values (1, 1, '2019-12-26');
insert into movie_attr_value (m_id, ma_id, attr_value, attr_value_id ) values (1, 2, 'Клим Алексеевич Шипенко', 8170244);
insert into movie_attr_value (m_id, ma_id, attr_value, attr_value_id ) values (1, 3, 'Милош Бикович', 8326160);
insert into movie_attr_value (m_id, ma_id, attr_value, attr_value_id ) values (1, 3, 'Иван Охлобыстин', 8090093);
insert into movie_attr_value (m_id, ma_id, attr_value, attr_value_id ) values (1, 3, 'Александра Бортич', 8322161);
insert into movie_attr_value (m_id, ma_id, attr_value, attr_value_id ) values (1, 3, 'Кирилл Нагиев', 8353018);

insert into movie_attr_value (m_id, ma_id, attr_value) values (1, 4, 'комедия');

insert into movie_attr_value (m_id, ma_id, attr_value, attr_value_id ) values (1, 5, 'https://static.kinoafisha.info/k/movie_shots/canvas/600x400/upload/movie_shots/8/1/4/8330418/68e7a1415e36c35bd7f7ca0016e41f80.jpeg', 117823);
insert into movie_attr_value (m_id, ma_id, attr_value, attr_value_id ) values (1, 5, 'https://static.kinoafisha.info/k/movie_shots/canvas/600x400/upload/movie_shots/8/1/4/8330418/031361e60ad777573f033b2a0113b4ed.jpeg', 117920);

select movie_name, attr_name, attr_type, attr_value, attr_value_id from movie left join movie_attr_value mav on mav.m_id = movie.movie_id
left join movie_attr ma on ma.ma_id = mav.ma_id 
where movie.movie_id = 1;

-- получаем красивую таблицу со списком значений, которая кроме того имеет ID внешних объектов, названия таблиц можно добавить в таблицу movie_attr и по ней запрашивать уже дополнительные свойства по их ID