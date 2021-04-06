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

-- Permissions

ALTER SEQUENCE public.clients_id_seq OWNER TO postgres;
GRANT ALL ON SEQUENCE public.clients_id_seq TO postgres;

-- DROP SEQUENCE public.films_id_seq;

CREATE SEQUENCE public.films_id_seq
	INCREMENT BY 1
	MINVALUE 1
	MAXVALUE 9223372036854775807
	START 1
	CACHE 1
	NO CYCLE;

-- Permissions

ALTER SEQUENCE public.films_id_seq OWNER TO postgres;
GRANT ALL ON SEQUENCE public.films_id_seq TO postgres;

-- DROP SEQUENCE public.halls_id_seq;

CREATE SEQUENCE public.halls_id_seq
	INCREMENT BY 1
	MINVALUE 1
	MAXVALUE 2147483647
	START 1
	CACHE 1
	NO CYCLE;

-- Permissions

ALTER SEQUENCE public.halls_id_seq OWNER TO postgres;
GRANT ALL ON SEQUENCE public.halls_id_seq TO postgres;

-- DROP SEQUENCE public.place_types_id_seq;

CREATE SEQUENCE public.place_types_id_seq
	INCREMENT BY 1
	MINVALUE 1
	MAXVALUE 2147483647
	START 1
	CACHE 1
	NO CYCLE;

-- Permissions

ALTER SEQUENCE public.place_types_id_seq OWNER TO postgres;
GRANT ALL ON SEQUENCE public.place_types_id_seq TO postgres;

-- DROP SEQUENCE public.places_id_seq;

CREATE SEQUENCE public.places_id_seq
	INCREMENT BY 1
	MINVALUE 1
	MAXVALUE 2147483647
	START 1
	CACHE 1
	NO CYCLE;

-- Permissions

ALTER SEQUENCE public.places_id_seq OWNER TO postgres;
GRANT ALL ON SEQUENCE public.places_id_seq TO postgres;

-- DROP SEQUENCE public.sessions_id_seq;

CREATE SEQUENCE public.sessions_id_seq
	INCREMENT BY 1
	MINVALUE 1
	MAXVALUE 9223372036854775807
	START 1
	CACHE 1
	NO CYCLE;

-- Permissions

ALTER SEQUENCE public.sessions_id_seq OWNER TO postgres;
GRANT ALL ON SEQUENCE public.sessions_id_seq TO postgres;

-- DROP SEQUENCE public.tickets_id_seq;

CREATE SEQUENCE public.tickets_id_seq
	INCREMENT BY 1
	MINVALUE 1
	MAXVALUE 9223372036854775807
	START 1
	CACHE 1
	NO CYCLE;

-- Permissions

ALTER SEQUENCE public.tickets_id_seq OWNER TO postgres;
GRANT ALL ON SEQUENCE public.tickets_id_seq TO postgres;
-- public.clients definition

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

-- Permissions

ALTER TABLE public.clients OWNER TO postgres;
GRANT ALL ON TABLE public.clients TO postgres;


-- public.films definition

-- Drop table

-- DROP TABLE public.films;

CREATE TABLE public.films (
	id bigserial NOT NULL,
	"name" varchar NULL,
	duration time NULL,
	CONSTRAINT films_pkey PRIMARY KEY (id)
);

-- Permissions

ALTER TABLE public.films OWNER TO postgres;
GRANT ALL ON TABLE public.films TO postgres;


-- public.halls definition

-- Drop table

-- DROP TABLE public.halls;

CREATE TABLE public.halls (
	id serial NOT NULL,
	"name" varchar NULL,
	max_plase int4 NULL,
	CONSTRAINT halls_pkey PRIMARY KEY (id)
);

-- Permissions

ALTER TABLE public.halls OWNER TO postgres;
GRANT ALL ON TABLE public.halls TO postgres;


-- public.place_types definition

-- Drop table

-- DROP TABLE public.place_types;

CREATE TABLE public.place_types (
	id serial NOT NULL,
	"name" varchar NULL,
	price_difference float8 NULL,
	CONSTRAINT place_types_pk PRIMARY KEY (id)
);

-- Permissions

ALTER TABLE public.place_types OWNER TO postgres;
GRANT ALL ON TABLE public.place_types TO postgres;


-- public.places definition

-- Drop table

-- DROP TABLE public.places;

CREATE TABLE public.places (
	id serial NOT NULL,
	id_hall int4 NULL,
	number_place int4 NULL,
	"row" int4 NULL,
	id_type int4 NULL,
	CONSTRAINT places_pk PRIMARY KEY (id),
	CONSTRAINT places_fk FOREIGN KEY (id_hall) REFERENCES halls(id) ON UPDATE CASCADE ON DELETE CASCADE,
	CONSTRAINT places_fk_1 FOREIGN KEY (id_type) REFERENCES place_types(id) ON UPDATE CASCADE ON DELETE CASCADE
);

-- Permissions

ALTER TABLE public.places OWNER TO postgres;
GRANT ALL ON TABLE public.places TO postgres;


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

-- Permissions

ALTER TABLE public.sessions OWNER TO postgres;
GRANT ALL ON TABLE public.sessions TO postgres;


-- public.tickets definition

-- Drop table

-- DROP TABLE public.tickets;

CREATE TABLE public.tickets (
	id bigserial NOT NULL,
	id_client int4 NULL,
	id_session int4 NULL,
	id_place int4 NULL,
	"cost" float4 NULL,
	CONSTRAINT tickets_pkey PRIMARY KEY (id),
	CONSTRAINT tickets_fk FOREIGN KEY (id_client) REFERENCES clients(id) ON UPDATE CASCADE ON DELETE CASCADE,
	CONSTRAINT tickets_fk_1 FOREIGN KEY (id_session) REFERENCES sessions(id) ON UPDATE CASCADE ON DELETE CASCADE,
	CONSTRAINT tickets_fk_2 FOREIGN KEY (id_place) REFERENCES places(id) ON UPDATE CASCADE ON DELETE CASCADE
);

-- Permissions

ALTER TABLE public.tickets OWNER TO postgres;
GRANT ALL ON TABLE public.tickets TO postgres;


-- public.max_price source

CREATE OR REPLACE VIEW public.max_price
AS SELECT m.maxname,
    m.maxsum
   FROM ( SELECT films.name AS maxname,
            sum(tickets.cost) AS maxsum
           FROM tickets
             JOIN sessions ON tickets.id_session = sessions.id
             JOIN films ON sessions.id_film = films.id
          GROUP BY films.id
          ORDER BY (sum(tickets.cost)) DESC
         LIMIT 1) m;

-- Permissions

ALTER TABLE public.max_price OWNER TO postgres;
GRANT ALL ON TABLE public.max_price TO postgres;




-- Permissions

GRANT ALL ON SCHEMA public TO postgres;
GRANT ALL ON SCHEMA public TO public;
