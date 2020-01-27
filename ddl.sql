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
	price numeric(2) NOT NULL,
	CONSTRAINT session_pkey PRIMARY KEY (session_id),
	CONSTRAINT session_fk FOREIGN KEY (movie_id) REFERENCES movie(movie_id),
	CONSTRAINT session_fk_1 FOREIGN KEY (hall_id) REFERENCES hall(hall_id)
);



CREATE TABLE public.ticket (
	ticket_id serial NOT NULL,
	session_id int4 NULL,
	"row" int4 NULL,
	place int4 NULL,
	CONSTRAINT ticket_pkey PRIMARY KEY (ticket_id),
	CONSTRAINT ticket_fk FOREIGN KEY (session_id) REFERENCES session(session_id)
);

-- самый прибыльный фильм
select movie.movie_name, sum("session".price) as sum from ticket
left join "session" ON "session".session_id = ticket.session_id
left join movie on movie.movie_id = "session".movie_id group by "movie".movie_id;


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

