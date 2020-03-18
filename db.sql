-- Фильмы
CREATE TABLE public.films (
	film_id serial NOT NULL CONSTRAINT film_id_pk PRIMARY KEY,
    name text,
	duration int4 NOT NULL
);
CREATE INDEX films_film_id_index ON public.films (film_id);


-- Кинозалы
CREATE TABLE public.halls (
	hall_id serial NOT NULL CONSTRAINT hall_id_pk PRIMARY KEY,
    name text
);
CREATE INDEX halls_hall_id_index ON public.halls (hall_id);


-- Места в кинозалах
CREATE TABLE public.places (
	place_id serial NOT NULL CONSTRAINT place_id_pk PRIMARY KEY,
    hall_id int4 NOT NULL CONSTRAINT hall_id_halls_places_fk REFERENCES public.halls,
    place_row int4 NOT NULL,
    place_col int4 NOT NULL
);
CREATE INDEX places_place_id_index ON public.places (place_id);


-- Расписание
CREATE TABLE public.timetables (
	timetable_id serial NOT NULL CONSTRAINT timetable_id_pk PRIMARY KEY,
	hall_id int4 NOT NULL CONSTRAINT hall_id_halls_timetables_fk REFERENCES public.halls,
	film_id int4 NOT NULL CONSTRAINT film_id_films_timetables_fk REFERENCES public.films,
    date_start timestamp,
    date_end timestamp
);
CREATE INDEX timetables_timetable_id_index ON public.timetables (timetable_id);


-- Билеты
CREATE TABLE public.tickets (
	ticket_id serial NOT NULL CONSTRAINT ticket_id_pk PRIMARY KEY,
	timetable_id int4 NOT NULL CONSTRAINT timetable_id_timetables_tickets_fk REFERENCES public.timetables,
	place_id int4 NOT NULL CONSTRAINT place_id_places_fk REFERENCES public.places,
	price numeric(10,2) NOT NULL
);
CREATE INDEX tickets_ticket_id_index ON public.tickets (ticket_id);


-- Тестовые данные

