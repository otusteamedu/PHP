-- DROP SCHEMA public;

CREATE SCHEMA public AUTHORIZATION postgres;

COMMENT ON SCHEMA public IS 'standard public schema';

-- DROP TYPE _content;

CREATE TYPE _content (
	INPUT = array_in,
	OUTPUT = array_out,
	RECEIVE = array_recv,
	SEND = array_send,
	ANALYZE = array_typanalyze,
	ALIGNMENT = 8,
	STORAGE = any,
	CATEGORY = A,
	ELEMENT = content,
	DELIMITER = ',');

-- DROP TYPE _hall;

CREATE TYPE _hall (
	INPUT = array_in,
	OUTPUT = array_out,
	RECEIVE = array_recv,
	SEND = array_send,
	ANALYZE = array_typanalyze,
	ALIGNMENT = 8,
	STORAGE = any,
	CATEGORY = A,
	ELEMENT = hall,
	DELIMITER = ',');

-- DROP TYPE _places;

CREATE TYPE _places (
	INPUT = array_in,
	OUTPUT = array_out,
	RECEIVE = array_recv,
	SEND = array_send,
	ANALYZE = array_typanalyze,
	ALIGNMENT = 8,
	STORAGE = any,
	CATEGORY = A,
	ELEMENT = places,
	DELIMITER = ',');

-- DROP TYPE _session;

CREATE TYPE _session (
	INPUT = array_in,
	OUTPUT = array_out,
	RECEIVE = array_recv,
	SEND = array_send,
	ANALYZE = array_typanalyze,
	ALIGNMENT = 8,
	STORAGE = any,
	CATEGORY = A,
	ELEMENT = session,
	DELIMITER = ',');

-- DROP TYPE _ticket_price;

CREATE TYPE _ticket_price (
	INPUT = array_in,
	OUTPUT = array_out,
	RECEIVE = array_recv,
	SEND = array_send,
	ANALYZE = array_typanalyze,
	ALIGNMENT = 8,
	STORAGE = any,
	CATEGORY = A,
	ELEMENT = ticket_price,
	DELIMITER = ',');

-- DROP TYPE _tickets;

CREATE TYPE _tickets (
	INPUT = array_in,
	OUTPUT = array_out,
	RECEIVE = array_recv,
	SEND = array_send,
	ANALYZE = array_typanalyze,
	ALIGNMENT = 8,
	STORAGE = any,
	CATEGORY = A,
	ELEMENT = tickets,
	DELIMITER = ',');

-- DROP TYPE _type_content;

CREATE TYPE _type_content (
	INPUT = array_in,
	OUTPUT = array_out,
	RECEIVE = array_recv,
	SEND = array_send,
	ANALYZE = array_typanalyze,
	ALIGNMENT = 8,
	STORAGE = any,
	CATEGORY = A,
	ELEMENT = type_content,
	DELIMITER = ',');

-- DROP TYPE _type_place;

CREATE TYPE _type_place (
	INPUT = array_in,
	OUTPUT = array_out,
	RECEIVE = array_recv,
	SEND = array_send,
	ANALYZE = array_typanalyze,
	ALIGNMENT = 8,
	STORAGE = any,
	CATEGORY = A,
	ELEMENT = type_place,
	DELIMITER = ',');

-- DROP TYPE content;

CREATE TYPE content AS (
	id int4,
	"name" varchar(250),
	id_type int4,
	duration int2,
	age int2);

-- DROP TYPE hall;

CREATE TYPE hall AS (
	id int4,
	"name" varchar(32));

-- DROP TYPE places;

CREATE TYPE places AS (
	id int4,
	id_hall int4,
	"row_number" int2,
	place_number int2,
	id_type_place int4);

-- DROP TYPE session;

CREATE TYPE session AS (
	id int4,
	id_hall int4,
	id_content int4,
	date_begin int4,
	date_end int4,
	base_price numeric);

-- DROP TYPE ticket_price;

CREATE TYPE ticket_price AS (
	id int4,
	price numeric);

-- DROP TYPE tickets;

CREATE TYPE tickets AS (
	id int4,
	id_client int4,
	id_session int4,
	id_place int4);

-- DROP TYPE type_content;

CREATE TYPE type_content AS (
	id int4,
	"name" varchar(32));

-- DROP TYPE type_place;

CREATE TYPE type_place AS (
	id int4,
	"name" varchar(32),
	"price ratio" numeric);

-- DROP SEQUENCE public.content_id_seq;

CREATE SEQUENCE public.content_id_seq
	INCREMENT BY 1
	MINVALUE 1
	MAXVALUE 2147483647
	START 1
	CACHE 1
	NO CYCLE;
-- DROP SEQUENCE public.hall_id_seq;

CREATE SEQUENCE public.hall_id_seq
	INCREMENT BY 1
	MINVALUE 1
	MAXVALUE 2147483647
	START 1
	CACHE 1
	NO CYCLE;
-- DROP SEQUENCE public.places_id_seq;

CREATE SEQUENCE public.places_id_seq
	INCREMENT BY 1
	MINVALUE 1
	MAXVALUE 2147483647
	START 1
	CACHE 1
	NO CYCLE;
-- DROP SEQUENCE public.session_id_seq;

CREATE SEQUENCE public.session_id_seq
	INCREMENT BY 1
	MINVALUE 1
	MAXVALUE 2147483647
	START 1
	CACHE 1
	NO CYCLE;
-- DROP SEQUENCE public.tickets_id_seq;

CREATE SEQUENCE public.tickets_id_seq
	INCREMENT BY 1
	MINVALUE 1
	MAXVALUE 2147483647
	START 1
	CACHE 1
	NO CYCLE;
-- DROP SEQUENCE public.type_content_id_seq;

CREATE SEQUENCE public.type_content_id_seq
	INCREMENT BY 1
	MINVALUE 1
	MAXVALUE 2147483647
	START 1
	CACHE 1
	NO CYCLE;
-- DROP SEQUENCE public.type_place_id_seq;

CREATE SEQUENCE public.type_place_id_seq
	INCREMENT BY 1
	MINVALUE 1
	MAXVALUE 2147483647
	START 1
	CACHE 1
	NO CYCLE;-- public.hall definition

-- Drop table

-- DROP TABLE public.hall;

CREATE TABLE public.hall (
	id serial NOT NULL,
	"name" varchar(32) NOT NULL,
	CONSTRAINT hall_pk PRIMARY KEY (id)
);


-- public.type_content definition

-- Drop table

-- DROP TABLE public.type_content;

CREATE TABLE public.type_content (
	id serial NOT NULL,
	"name" varchar(32) NOT NULL,
	CONSTRAINT type_content_pk PRIMARY KEY (id)
);


-- public.type_place definition

-- Drop table

-- DROP TABLE public.type_place;

CREATE TABLE public.type_place (
	id serial NOT NULL,
	"name" varchar(32) NOT NULL,
	"price ratio" numeric NOT NULL,
	CONSTRAINT type_place_pk PRIMARY KEY (id)
);


-- public."content" definition

-- Drop table

-- DROP TABLE public."content";

CREATE TABLE public."content" (
	id serial NOT NULL,
	"name" varchar(250) NOT NULL,
	id_type int4 NOT NULL,
	duration int2 NOT NULL,
	age int2 NOT NULL,
	CONSTRAINT content_pk PRIMARY KEY (id),
	CONSTRAINT content_fk FOREIGN KEY (id_type) REFERENCES type_content(id) ON UPDATE CASCADE ON DELETE CASCADE
);


-- public.places definition

-- Drop table

-- DROP TABLE public.places;

CREATE TABLE public.places (
	id serial NOT NULL,
	id_hall int4 NOT NULL,
	"row_number" int2 NOT NULL,
	place_number int2 NOT NULL,
	id_type_place int4 NOT NULL,
	CONSTRAINT places_pk PRIMARY KEY (id),
	CONSTRAINT places_un UNIQUE (id_hall, row_number, place_number),
	CONSTRAINT places_fk FOREIGN KEY (id_type_place) REFERENCES type_place(id) ON UPDATE CASCADE ON DELETE CASCADE,
	CONSTRAINT places_hall_fk FOREIGN KEY (id_hall) REFERENCES hall(id) ON UPDATE CASCADE ON DELETE CASCADE
);


-- public."session" definition

-- Drop table

-- DROP TABLE public."session";

CREATE TABLE public."session" (
	id serial NOT NULL,
	id_hall int4 NOT NULL,
	id_content int4 NOT NULL,
	date_begin int4 NOT NULL,
	date_end int4 NOT NULL,
	base_price numeric NOT NULL,
	CONSTRAINT session_pk PRIMARY KEY (id),
	CONSTRAINT session_fk FOREIGN KEY (id_hall) REFERENCES hall(id) ON UPDATE CASCADE ON DELETE CASCADE,
	CONSTRAINT session_fk_1 FOREIGN KEY (id_content) REFERENCES content(id) ON UPDATE CASCADE ON DELETE CASCADE
);


-- public.tickets definition

-- Drop table

-- DROP TABLE public.tickets;

CREATE TABLE public.tickets (
	id serial NOT NULL,
	id_client int4 NOT NULL,
	id_session int4 NOT NULL,
	id_place int4 NOT NULL,
	CONSTRAINT tickets_pk PRIMARY KEY (id),
	CONSTRAINT tickets_fk FOREIGN KEY (id_session) REFERENCES session(id),
	CONSTRAINT tickets_places_fk FOREIGN KEY (id_place) REFERENCES places(id)
);


-- public.ticket_price source

CREATE OR REPLACE VIEW public.ticket_price
AS SELECT t.id,
    tp."price ratio" * s.base_price AS price
   FROM tickets t
     JOIN places p ON p.id = t.id_place
     JOIN type_place tp ON tp.id = p.id_type_place
     JOIN session s ON s.id = t.id_session;


