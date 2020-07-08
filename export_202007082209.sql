-- public.cinemas definition

-- Drop table

-- DROP TABLE public.cinemas;

CREATE TABLE public.cinemas (
	id serial NOT NULL,
	rooms_id varchar(255) NOT NULL,
	"name" varchar(255) NOT NULL,
	CONSTRAINT cinemas_pk PRIMARY KEY (id)
);


-- public.clients definition

-- Drop table

-- DROP TABLE public.clients;

CREATE TABLE public.clients (
	id serial NOT NULL,
	fio varchar(255) NOT NULL,
	CONSTRAINT clients_pk PRIMARY KEY (id)
);


-- public.rooms definition

-- Drop table

-- DROP TABLE public.rooms;

CREATE TABLE public.rooms (
	id serial NOT NULL,
	"name" varchar(255) NOT NULL,
	CONSTRAINT rooms_pk PRIMARY KEY (id)
);


-- public.seans definition

-- Drop table

-- DROP TABLE public.seans;

CREATE TABLE public.seans (
	id serial NOT NULL,
	"name" varchar(255) NOT NULL,
	price float8 NOT NULL,
	CONSTRAINT seans_pk PRIMARY KEY (id)
);


-- public.rooms_seans definition

-- Drop table

-- DROP TABLE public.rooms_seans;

CREATE TABLE public.rooms_seans (
	rooms_id int4 NOT NULL,
	seans_id int4 NOT NULL
);


-- public.seans_clients definition

-- Drop table

-- DROP TABLE public.seans_clients;

CREATE TABLE public.seans_clients (
	seans_id int4 NOT NULL,
	clients_id int4 NOT NULL
);
