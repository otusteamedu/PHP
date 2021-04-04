-- DROP SCHEMA public;

CREATE SCHEMA public AUTHORIZATION postgres;

-- DROP SEQUENCE public.clients_id_seq;

CREATE SEQUENCE public.clients_id_seq
	INCREMENT BY 1
	MINVALUE 1
	MAXVALUE 9223372036854775807
	START 1
	CACHE 1
	NO CYCLE;
-- DROP SEQUENCE public.films_id_seq;

CREATE SEQUENCE public.films_id_seq
	INCREMENT BY 1
	MINVALUE 1
	MAXVALUE 9223372036854775807
	START 1
	CACHE 1
	NO CYCLE;
-- DROP SEQUENCE public.halls_id_seq;

CREATE SEQUENCE public.halls_id_seq
	INCREMENT BY 1
	MINVALUE 1
	MAXVALUE 2147483647
	START 1
	CACHE 1
	NO CYCLE;
-- DROP SEQUENCE public.sessions_id_seq;

CREATE SEQUENCE public.sessions_id_seq
	INCREMENT BY 1
	MINVALUE 1
	MAXVALUE 9223372036854775807
	START 1
	CACHE 1
	NO CYCLE;
-- DROP SEQUENCE public.tickets_id_seq;

CREATE SEQUENCE public.tickets_id_seq
	INCREMENT BY 1
	MINVALUE 1
	MAXVALUE 9223372036854775807
	START 1
	CACHE 1
	NO CYCLE;-- public.clients definition

-- Drop table

-- DROP TABLE public.clients;

CREATE TABLE public.clients (
	id bigserial NOT NULL,
	surname varchar NULL,
	"name" varchar NULL,
	patronymic varchar NULL,
	birthday date NULL,
	phone varchar NULL,
	CONSTRAINT clients_pkey PRIMARY KEY (id)
);


-- public.films definition

-- Drop table

-- DROP TABLE public.films;

CREATE TABLE public.films (
	id bigserial NOT NULL,
	"name" varchar NULL,
	duration time NULL,
	CONSTRAINT films_pkey PRIMARY KEY (id)
);


-- public.halls definition

-- Drop table

-- DROP TABLE public.halls;

CREATE TABLE public.halls (
	id serial NOT NULL,
	"name" varchar NULL,
	max_plase int4 NULL,
	CONSTRAINT halls_pkey PRIMARY KEY (id)
);


-- public.sessions definition

-- Drop table

-- DROP TABLE public.sessions;

CREATE TABLE public.sessions (
	id bigserial NOT NULL,
	id_hall int4 NULL,
	id_film int4 NULL,
	"time" time NULL,
	base_price float4 NULL,
	CONSTRAINT sessions_pkey PRIMARY KEY (id),
	CONSTRAINT sessions_fk FOREIGN KEY (id_film) REFERENCES films(id) ON UPDATE CASCADE ON DELETE CASCADE,
	CONSTRAINT sessions_fk_1 FOREIGN KEY (id_hall) REFERENCES halls(id) ON UPDATE CASCADE ON DELETE CASCADE
);


-- public.tickets definition

-- Drop table

-- DROP TABLE public.tickets;

CREATE TABLE public.tickets (
	id bigserial NOT NULL,
	id_client int4 NULL,
	id_session int4 NULL,
	plase int4 NULL,
	"cost" float4 NULL,
	CONSTRAINT tickets_pkey PRIMARY KEY (id),
	CONSTRAINT tickets_fk FOREIGN KEY (id_client) REFERENCES clients(id) ON UPDATE CASCADE ON DELETE CASCADE,
	CONSTRAINT tickets_fk_1 FOREIGN KEY (id_session) REFERENCES sessions(id) ON UPDATE CASCADE ON DELETE CASCADE
);
