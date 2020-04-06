-- Фильмы
CREATE TABLE public.films (
	film_id serial NOT NULL CONSTRAINT film_id_pk PRIMARY KEY,
    name text NOT NULL
);
-- CREATE INDEX films_film_id_index ON public.films (film_id);
-- CREATE INDEX films_name_index ON public.films (name);


-- Генерируем данные (1,10000; 10001,1000000)

INSERT INTO public.films (film_id, name)
SELECT
    gs.id,
    random_string((1+random()*40)::integer)
FROM generate_series(1,10000) as gs(id);


INSERT INTO public.films (film_id, name)
SELECT
    gs.id,
    random_string((1+random()*40)::integer)
FROM generate_series(10001,1000000) as gs(id);


-- ///////////////////////////////////////////////////////////////
-- ///////////////////////////////////////////////////////////////
-- ///////////////////////////////////////////////////////////////


-- Типы данных атрибутов
CREATE TABLE public.types (
	type_id serial NOT NULL CONSTRAINT type_id_pk PRIMARY KEY,
    name text NOT NULL,
	comment text
);
-- CREATE INDEX types_type_id_index ON public.types (type_id);
-- CREATE INDEX types_name_index ON public.types (name);
-- CREATE INDEX types_comment_index ON public.types (comment);

-- Генерируем данные (типов данных будет 1-5)

INSERT INTO public.types (type_id, name, comment)
SELECT
    gs.id,
    random_string((1+random()*40)::integer),
    random_string((1+random()*40)::integer)
FROM generate_series(1,5) as gs(id);


-- ///////////////////////////////////////////////////////////////
-- ///////////////////////////////////////////////////////////////
-- ///////////////////////////////////////////////////////////////


-- Типы значений атрибутов для фильмов
CREATE TABLE public.filmsattrs (
	attr_id serial NOT NULL CONSTRAINT attr_id_pk PRIMARY KEY,
	type_id int4 NOT NULL CONSTRAINT type_id_types_filmsAttrs_fk REFERENCES public.types,
	name text
);


-- CREATE INDEX filmsattrs_attr_id_index ON public.filmsattrs (attr_id);
-- CREATE INDEX filmsattrs_type_id_index ON public.filmsattrs (type_id);
-- CREATE INDEX filmsattrs_name_index ON public.filmsattrs (name);


-- Генерируем данные (1,10000; 10001,1000000)

INSERT INTO public.filmsattrs (attr_id, type_id, name)
SELECT
    gs.id,
    ((1+random()*4)::integer),
    random_string((1+random()*40)::integer)
FROM generate_series(1,10000) as gs(id);

INSERT INTO public.filmsattrs (attr_id, type_id, name)
SELECT
    gs.id,
    ((1+random()*4)::integer),
    random_string((1+random()*40)::integer)
FROM generate_series(10001,1000000) as gs(id);


-- ///////////////////////////////////////////////////////////////
-- ///////////////////////////////////////////////////////////////
-- ///////////////////////////////////////////////////////////////


-- Значения атрибутов для фильмов
CREATE TABLE public.filmsvalues (
	value_id serial NOT NULL CONSTRAINT value_id_pk PRIMARY KEY,
	film_id int4 NOT NULL CONSTRAINT film_id_films_filmsvalues_fk REFERENCES public.films,
	attr_id int4 NOT NULL CONSTRAINT attr_id_filmsattrs_filmsvalues_fk REFERENCES public.filmsattrs,
	val_date date,
	val_text text,
	val_float decimal,
	val_int integer,
	val_bool boolean
);
-- CREATE INDEX filmsvalues_value_id_index ON public.filmsvalues (value_id);
-- CREATE INDEX filmsvalues_film_id_index ON public.filmsvalues (film_id);
-- CREATE INDEX filmsvalues_attr_id_index ON public.filmsvalues (attr_id);
-- CREATE INDEX filmsvalues_val_date_index ON public.filmsvalues (val_date);
-- CREATE INDEX filmsvalues_val_text_index ON public.filmsvalues (val_text);
-- CREATE INDEX filmsvalues_val_float_index ON public.filmsvalues (val_float);
-- CREATE INDEX filmsvalues_val_int_index ON public.filmsvalues (val_int);
-- CREATE INDEX filmsvalues_val_bool_index ON public.filmsvalues (val_bool);

-- Генерируем данные (1,10000)

INSERT INTO public.filmsvalues (value_id, film_id, attr_id, val_date, val_text, val_float, val_int, val_bool)
SELECT
    gs.id,
    ((1 + random()*9999)::integer),
	((1 + random()*9999)::integer),
	date(now() + (text(round(random()*365)-120)||' day')::interval),
	null, null, null, null
FROM generate_series(1,2000) as gs(id);

INSERT INTO public.filmsvalues (value_id, film_id, attr_id, val_date, val_text, val_float, val_int, val_bool)
SELECT
    gs.id,
    ((1 + random()*9999)::integer),
	((1 + random()*9999)::integer),
	null,
	random_string((1+random()*40)::integer),
	null, null, null
FROM generate_series(2001,4000) as gs(id);

INSERT INTO public.filmsvalues (value_id, film_id, attr_id, val_date, val_text, val_float, val_int, val_bool)
SELECT
    gs.id,
    ((1 + random()*9999)::integer),
	((1 + random()*9999)::integer),
	null, null,
	(random()*1000),
	null, null
FROM generate_series(4001,6000) as gs(id);

INSERT INTO public.filmsvalues (value_id, film_id, attr_id, val_date, val_text, val_float, val_int, val_bool)
SELECT
    gs.id,
    ((1 + random()*9999)::integer),
	((1 + random()*9999)::integer),
	null, null, null,
	round(random()*1000),
	null
FROM generate_series(6001,8000) as gs(id);

INSERT INTO public.filmsvalues (value_id, film_id, attr_id, val_date, val_text, val_float, val_int, val_bool)
SELECT
    gs.id,
    ((1 + random()*9999)::integer),
	((1 + random()*9999)::integer),
	null, null, null,  null,
	(random() < 0.5)
FROM generate_series(8001,10000) as gs(id);

-- Генерируем данные (10001,1000000)

INSERT INTO public.filmsvalues (value_id, film_id, attr_id, val_date, val_text, val_float, val_int, val_bool)
SELECT
    gs.id,
    ((1 + random()*999999)::integer),
	((1 + random()*999999)::integer),
	date(now() + (text(round(random()*365)-120)||' day')::interval),
	null, null, null, null
FROM generate_series(10001,200000) as gs(id);

INSERT INTO public.filmsvalues (value_id, film_id, attr_id, val_date, val_text, val_float, val_int, val_bool)
SELECT
    gs.id,
    ((1 + random()*999999)::integer),
	((1 + random()*999999)::integer),
	null,
	random_string((1+random()*40)::integer),
	null, null, null
FROM generate_series(200001,400000) as gs(id);

INSERT INTO public.filmsvalues (value_id, film_id, attr_id, val_date, val_text, val_float, val_int, val_bool)
SELECT
    gs.id,
    ((1 + random()*999999)::integer),
	((1 + random()*999999)::integer),
	null, null,
	(random()*1000),
	null, null
FROM generate_series(400001,600000) as gs(id);

INSERT INTO public.filmsvalues (value_id, film_id, attr_id, val_date, val_text, val_float, val_int, val_bool)
SELECT
    gs.id,
    ((1 + random()*999999)::integer),
	((1 + random()*999999)::integer),
	null, null, null,
	round(random()*1000),
	null
FROM generate_series(600001,800000) as gs(id);

INSERT INTO public.filmsvalues (value_id, film_id, attr_id, val_date, val_text, val_float, val_int, val_bool)
SELECT
    gs.id,
    ((1 + random()*999999)::integer),
	((1 + random()*999999)::integer),
	null, null, null,  null,
	(random() < 0.5)
FROM generate_series(800001,1000000) as gs(id);


-- ///////////////////////////////////////////////////////////////
-- ///////////////////////////////////////////////////////////////
-- ///////////////////////////////////////////////////////////////

-- Кинозалы
CREATE TABLE public.halls (
	hall_id serial NOT NULL CONSTRAINT hall_id_pk PRIMARY KEY,
    name text
);
-- CREATE INDEX halls_hall_id_index ON public.halls (hall_id);
-- CREATE INDEX halls_name_index ON public.halls (name);

-- Генерируем данные (кинозалов будет 1-100)

INSERT INTO public.halls (hall_id, name)
SELECT
    gs.id,
    random_string((1+random()*40)::integer)
FROM generate_series(1,100) as gs(id);

-- ///////////////////////////////////////////////////////////////
-- ///////////////////////////////////////////////////////////////
-- ///////////////////////////////////////////////////////////////

-- Места в кинозалах
CREATE TABLE public.places (
	place_id serial NOT NULL CONSTRAINT place_id_pk PRIMARY KEY,
    hall_id int4 NOT NULL CONSTRAINT hall_id_halls_places_fk REFERENCES public.halls,
    -- place_row int4 NOT NULL,
    -- place_col int4 NOT NULL
	glogal_place_num int4 NOT NULL
);
-- CREATE INDEX places_place_id_index ON public.places (place_id);
-- CREATE INDEX places_hall_id_index ON public.places (hall_id);
-- CREATE INDEX places_place_row_index ON public.places (place_row);
-- CREATE INDEX places_place_col_index ON public.places (place_col);

-- Генерируем данные (мест в кинозалах будет 1-2000)

INSERT INTO public.places (place_id, hall_id, glogal_place_num)
SELECT
    gs.id,
	((1 + random()*99)::integer),
	gs.id
FROM generate_series(1,2000) as gs(id);

-- ///////////////////////////////////////////////////////////////
-- ///////////////////////////////////////////////////////////////
-- ///////////////////////////////////////////////////////////////


-- Расписание
CREATE TABLE public.timetables (
	timetable_id serial NOT NULL CONSTRAINT timetable_id_pk PRIMARY KEY,
	hall_id int4 NOT NULL CONSTRAINT hall_id_halls_timetables_fk REFERENCES public.halls,
	film_id int4 NOT NULL CONSTRAINT film_id_films_timetables_fk REFERENCES public.films,
    date_show date,
	price numeric(6,2) NOT NULL
);
-- CREATE INDEX timetables_timetable_id_index ON public.timetables (timetable_id);
-- CREATE INDEX timetables_hall_id_index ON public.timetables (hall_id);
-- CREATE INDEX timetables_film_id_index ON public.timetables (film_id);
-- CREATE INDEX timetables_date_show_index ON public.timetables (date_show);
-- CREATE INDEX timetables_price_index ON public.timetables (price);

-- Генерируем данные (1,10000; 10001,1000000)

INSERT INTO public.timetables (timetable_id, hall_id, film_id, date_show, price)
SELECT
    gs.id,
	((1 + random()*99)::integer),
	((1 + random()*9999)::integer),
	date(now() + (text(round(random()*365)-120)||' day')::interval),
    (200+random()*500)
FROM generate_series(1,10000) as gs(id);

INSERT INTO public.timetables (timetable_id, hall_id, film_id, date_show, price)
SELECT
    gs.id,
	((1 + random()*99)::integer),
	((1 + random()*999999)::integer),
	date(now() + (text(round(random()*365)-120)||' day')::interval),
    (200+random()*500)
FROM generate_series(10001,1000000) as gs(id);


-- ///////////////////////////////////////////////////////////////
-- ///////////////////////////////////////////////////////////////
-- ///////////////////////////////////////////////////////////////


-- Билеты
CREATE TABLE public.tickets (
	ticket_id serial NOT NULL CONSTRAINT ticket_id_pk PRIMARY KEY,
	client_id int4 NOT NULL CONSTRAINT client_id_clients_timetables_fk REFERENCES public.clients,
	timetable_id int4 NOT NULL CONSTRAINT timetable_id_timetables_tickets_fk REFERENCES public.timetables,
	place_id int4 NOT NULL CONSTRAINT place_id_places_fk REFERENCES public.places,
    date_buy date,
    price numeric(6,2) NOT NULL
);
-- CREATE INDEX tickets_ticket_id_index ON public.tickets (ticket_id);
-- CREATE INDEX tickets_client_id_index ON public.tickets (client_id);
-- CREATE INDEX tickets_timetable_id_index ON public.tickets (timetable_id);
-- CREATE INDEX tickets_place_id_index ON public.tickets (place_id);
-- CREATE INDEX tickets_date_buy_index ON public.tickets (date_buy);
-- CREATE INDEX tickets_price_index ON public.tickets (price);

-- Генерируем данные (1,10000; 10001,1000000)

INSERT INTO public.tickets (ticket_id, client_id, timetable_id, place_id, date_buy, price)
SELECT
    gs.id,
    ((1 + random()*9999)::integer),
	((1 + random()*9999)::integer),
	((1 + random()*1999)::integer),
	date(now() + (text(round(random()*365)-120)||' day')::interval),
    (200+random()*500)
FROM generate_series(1,10000) as gs(id);

INSERT INTO public.tickets (ticket_id, client_id, timetable_id, place_id, date_buy, price)
SELECT
    gs.id,
    ((1 + random()*999999)::integer),
	((1 + random()*999999)::integer),
	((1 + random()*1999)::integer),
	date(now() + (text(round(random()*365)-120)||' day')::interval),
    (200+random()*500)
FROM generate_series(10001,1000000) as gs(id);

-- ///////////////////////////////////////////////////////////////
-- ///////////////////////////////////////////////////////////////
-- ///////////////////////////////////////////////////////////////

-- Клиенты
CREATE TABLE public.clients (
	client_id serial NOT NULL CONSTRAINT client_id_pk PRIMARY KEY,
	name text NOT NULL,
	email text NOT NULL
);
-- CREATE INDEX clients_client_id_index ON public.clients (client_id);
-- CREATE INDEX clients_name_index ON public.clients (name);
-- CREATE INDEX clients_email_index ON public.clients (email);

-- Генерируем данные (1,10000; 10001,1000000)

INSERT INTO public.clients (client_id, name, email)
SELECT
    gs.id,
    random_string((1+random()*80)::integer),
	random_string((10+random()*40)::integer)
FROM generate_series(1,10000) as gs(id);

INSERT INTO public.clients (client_id, name, email)
SELECT
    gs.id,
    random_string((1+random()*80)::integer),
	random_string((10+random()*40)::integer)
FROM generate_series(10001,1000000) as gs(id);
