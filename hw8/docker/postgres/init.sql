create table if not exists cinema
(
	id serial not null
		constraint cinema_pk
			primary key,
	name varchar(128) not null,
	address varchar
);

create table if not exists halls
(
	id serial not null
		constraint halls_pk
			primary key,
	name varchar(128) not null,
	cinema_id integer not null
		constraint halls_cinema_id_fk
			references cinema,
	capacity integer not null
);

create unique index if not exists halls_name_uindex
	on halls (name);

create table if not exists films
(
	id serial not null
		constraint films_pk
			primary key,
	name varchar(255) not null,
	duration integer not null
);

create table if not exists sessions
(
	id serial not null
		constraint sessions_pk
			primary key,
	hall_id integer not null
		constraint sessions_halls_id_fk
			references halls,
	film_id integer not null
		constraint sessions_films_id_fk
			references films,
	datetime timestamp not null,
	price integer not null
);

create table if not exists clients
(
    id serial  not null
        constraint clients_pk
            primary key,
    fio varchar not null,
    session_id integer not null
        constraint clients_sessions_id_fk
            references sessions
);

INSERT INTO public.cinema (id, name, address) VALUES (1, 'Кинотеатр 1', null);

INSERT INTO public.halls (id, name, cinema_id, capacity) VALUES (1, 'Зал1', 1, 50);
INSERT INTO public.halls (id, name, cinema_id, capacity) VALUES (2, 'Зал2', 1, 60);
INSERT INTO public.halls (id, name, cinema_id, capacity) VALUES (3, 'Зал3', 1, 100);

INSERT INTO public.films (id, name, duration) VALUES (1, 'Фильм1', 90);
INSERT INTO public.films (id, name, duration) VALUES (2, 'Фильм2', 100);
INSERT INTO public.films (id, name, duration) VALUES (3, 'Фильм3', 85);
INSERT INTO public.films (id, name, duration) VALUES (4, 'Фильм4', 110);
INSERT INTO public.films (id, name, duration) VALUES (5, 'Фильм5', 95);

INSERT INTO public.sessions (id, hall_id, film_id, datetime, price) VALUES (1, 1, 1, '2020-06-24 13:00:00.000000', 100);
INSERT INTO public.sessions (id, hall_id, film_id, datetime, price) VALUES (2, 1, 2, '2020-06-24 17:00:00.000000', 110);
INSERT INTO public.sessions (id, hall_id, film_id, datetime, price) VALUES (3, 1, 1, '2020-06-24 15:00:00.000000', 100);
INSERT INTO public.sessions (id, hall_id, film_id, datetime, price) VALUES (4, 2, 3, '2020-06-24 13:00:00.000000', 150);
INSERT INTO public.sessions (id, hall_id, film_id, datetime, price) VALUES (5, 3, 4, '2020-06-24 13:00:00.000000', 100);
INSERT INTO public.sessions (id, hall_id, film_id, datetime, price) VALUES (6, 1, 5, '2020-06-24 13:00:00.000000', 100);

INSERT INTO public.clients (id, fio, session_id) VALUES (1, 'Клиент1', 1);
INSERT INTO public.clients (id, fio, session_id) VALUES (2, 'Клиент2', 1);
INSERT INTO public.clients (id, fio, session_id) VALUES (3, 'Клиент3', 1);
INSERT INTO public.clients (id, fio, session_id) VALUES (4, 'Клиент4', 3);
INSERT INTO public.clients (id, fio, session_id) VALUES (5, 'Клиент5', 3);
INSERT INTO public.clients (id, fio, session_id) VALUES (6, 'Клиент6', 2);
INSERT INTO public.clients (id, fio, session_id) VALUES (7, 'Клиент7', 4);
INSERT INTO public.clients (id, fio, session_id) VALUES (8, 'Клиент8', 5);
INSERT INTO public.clients (id, fio, session_id) VALUES (9, 'Клиент9', 6);
INSERT INTO public.clients (id, fio, session_id) VALUES (10, 'Клиент10', 6);