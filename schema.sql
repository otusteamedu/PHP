-- public.cinemas definition

-- Drop table

-- DROP TABLE public.cinemas;

CREATE TABLE public.cinemas (
	id serial NOT NULL,
	"name" varchar(255) NOT NULL,
	CONSTRAINT cinemas_pk PRIMARY KEY (id)
);


-- public.cinemas_rooms definition

-- Drop table

-- DROP TABLE public.cinemas_rooms;

CREATE TABLE public.cinemas_rooms (
	cinema_id int4 NOT NULL,
	room_id int4 NOT NULL
);


-- public.clients definition

-- Drop table

-- DROP TABLE public.clients;

CREATE TABLE public.clients (
	id serial NOT NULL,
	fio varchar(255) NOT NULL,
	CONSTRAINT clients_pk PRIMARY KEY (id)
);


-- public.films definition

-- Drop table

-- DROP TABLE public.films;

CREATE TABLE public.films (
	id serial NOT NULL,
	"name" varchar(255) NOT NULL,
	start_date date NOT NULL,
	end_date date NOT NULL,
	relevant_today bool NOT NULL,
	description text NOT NULL,
	CONSTRAINT films_pk PRIMARY KEY (id)
);


-- public.films_attributes definition

-- Drop table

-- DROP TABLE public.films_attributes;

CREATE TABLE public.films_attributes (
	id serial NOT NULL,
	"name" varchar(255) NOT NULL,
	CONSTRAINT films_attributes_pk PRIMARY KEY (id)
);


-- public.films_important_dates definition

-- Drop table

-- DROP TABLE public.films_important_dates;

CREATE TABLE public.films_important_dates (
	id serial NOT NULL,
	"name" varchar(255) NOT NULL,
	start_date date NOT NULL,
	end_date date NOT NULL,
	film_id int4 NOT NULL,
	CONSTRAINT films_important_dates_pk PRIMARY KEY (id)
);


-- public.films_service_dates definition

-- Drop table

-- DROP TABLE public.films_service_dates;

CREATE TABLE public.films_service_dates (
	id serial NOT NULL,
	film_id int4 NOT NULL,
	"name" varchar(255) NOT NULL,
	start_date date NOT NULL,
	end_date date NOT NULL,
	CONSTRAINT films_service_dates_pk PRIMARY KEY (id)
);


-- public.reviews definition

-- Drop table

-- DROP TABLE public.reviews;

CREATE TABLE public.reviews (
	id serial NOT NULL,
	film_id int4 NOT NULL,
	author varchar(255) NOT NULL,
	"comment" text NOT NULL,
	CONSTRAINT reviews_pk PRIMARY KEY (id)
);


-- public.rooms definition

-- Drop table

-- DROP TABLE public.rooms;

CREATE TABLE public.rooms (
	id serial NOT NULL,
	"name" varchar(255) NOT NULL,
	film varchar(255) NOT NULL,
	date_begin int4 NOT NULL,
	date_end int4 NOT NULL,
	CONSTRAINT rooms_pk PRIMARY KEY (id)
);


-- public.rooms_films_tickets definition

-- Drop table

-- DROP TABLE public.rooms_films_tickets;

CREATE TABLE public.rooms_films_tickets (
	room_id int4 NOT NULL,
	ticket_id int4 NOT NULL,
	film_id int4 NOT NULL
);


-- public.rooms_shemas definition

-- Drop table

-- DROP TABLE public.rooms_shemas;

CREATE TABLE public.rooms_shemas (
	id serial NOT NULL,
	room_id int4 NOT NULL,
	place int4 NOT NULL,
	"row" int4 NOT NULL,
	active bool NOT NULL,
	CONSTRAINT rooms_shemas_pk PRIMARY KEY (id)
);


-- public.tickets definition

-- Drop table

-- DROP TABLE public.tickets;

CREATE TABLE public.tickets (
	id serial NOT NULL,
	"name" varchar(255) NOT NULL,
	price numeric(4,2) NOT NULL,
	place int4 NOT NULL,
	"row" int4 NOT NULL,
	active bool NOT NULL,
	CONSTRAINT tickets_pk PRIMARY KEY (id)
);


-- public.tickets_clients definition

-- Drop table

-- DROP TABLE public.tickets_clients;

CREATE TABLE public.tickets_clients (
	ticket_id int4 NOT NULL,
	client_id int4 NOT NULL
);


-- public.eav definition

-- Drop table

-- DROP TABLE public.eav;

CREATE TABLE public.eav (
	id serial NOT NULL,
	film_id int4 NOT NULL,
	value_text varchar NULL,
	value_integer int4 NULL,
	value_boolean bool NULL,
	value_float float4 NULL,
	value_timestamp timestamp NULL,
	CONSTRAINT eav_pk PRIMARY KEY (id)
);
