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
	cinemas_id int4 NOT NULL,
	rooms_id int4 NOT NULL
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
	max_cells int4 NOT NULL DEFAULT 300,
	CONSTRAINT rooms_pk PRIMARY KEY (id)
);


-- public.rooms_tickets definition

-- Drop table

-- DROP TABLE public.rooms_tickets;

CREATE TABLE public.rooms_tickets (
	rooms_id int4 NOT NULL,
	tickets_id int4 NOT NULL
);


-- public.tickets definition

-- Drop table

-- DROP TABLE public.tickets;

CREATE TABLE public.tickets (
	id serial NOT NULL,
	"name" varchar(255) NOT NULL,
	price numeric(4,2) NOT NULL,
	CONSTRAINT tickets_pk PRIMARY KEY (id)
);


-- public.tickets_clients definition

-- Drop table

-- DROP TABLE public.tickets_clients;

CREATE TABLE public.tickets_clients (
	ticket_id int4 NOT NULL,
	clients_id int4 NOT NULL
);
