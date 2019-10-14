CREATE DATABASE cinema
    WITH 
    OWNER = postgres
    ENCODING = 'UTF8'
    LC_COLLATE = 'Russian_Russia.1251'
    LC_CTYPE = 'Russian_Russia.1251'
    TABLESPACE = pg_default
    CONNECTION LIMIT = -1;

CREATE TABLE public.cashier
(
    id integer NOT NULL GENERATED ALWAYS AS IDENTITY ( INCREMENT 1 START 1 MINVALUE 1 MAXVALUE 2147483647 CACHE 1 ),
    id_ticket integer,
    price numeric(10,0),
    CONSTRAINT cashier_pkey PRIMARY KEY (id),
    CONSTRAINT foreign_key_1 FOREIGN KEY (id_ticket)
        REFERENCES public.tickets (id) MATCH SIMPLE
        ON UPDATE CASCADE
        ON DELETE CASCADE
)
CREATE TABLE public.clients
(
    id integer NOT NULL GENERATED ALWAYS AS IDENTITY ( INCREMENT 1 START 1 MINVALUE 1 MAXVALUE 2147483647 CACHE 1 ),
    name character(10) COLLATE pg_catalog."default",
    CONSTRAINT clients_pkey PRIMARY KEY (id)
)

CREATE TABLE public.film
(
    id integer NOT NULL GENERATED ALWAYS AS IDENTITY ( INCREMENT 1 START 1 MINVALUE 1 MAXVALUE 2147483647 CACHE 1 ),
    name character(10) COLLATE pg_catalog."default",
    CONSTRAINT film_pkey PRIMARY KEY (id)
)

CREATE TABLE public.hall
(
    id integer NOT NULL GENERATED ALWAYS AS IDENTITY ( INCREMENT 1 START 1 MINVALUE 1 MAXVALUE 2147483647 CACHE 1 ),
    name character(10) COLLATE pg_catalog."default" NOT NULL,
    CONSTRAINT hall_pkey PRIMARY KEY (id)
)
CREATE TABLE public.seance
(
    id integer NOT NULL GENERATED ALWAYS AS IDENTITY ( INCREMENT 1 START 1 MINVALUE 1 MAXVALUE 2147483647 CACHE 1 ),
    id_film integer,
    id_hall integer,
    datetime timestamp without time zone,
    CONSTRAINT seance_pkey PRIMARY KEY (id),
    CONSTRAINT foreign_key_1 FOREIGN KEY (id_film)
        REFERENCES public.film (id) MATCH SIMPLE
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT foreign_key_2 FOREIGN KEY (id_hall)
        REFERENCES public.hall (id) MATCH SIMPLE
        ON UPDATE CASCADE
        ON DELETE CASCADE
)

CREATE TABLE public.tickets
(
    id integer NOT NULL GENERATED ALWAYS AS IDENTITY ( INCREMENT 1 START 1 MINVALUE 1 MAXVALUE 2147483647 CACHE 1 ),
    id_seance integer,
    id_client integer,
    CONSTRAINT tickets_pkey PRIMARY KEY (id),
    CONSTRAINT "Foregin key_6" FOREIGN KEY (id_client)
        REFERENCES public.clients (id) MATCH SIMPLE
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT "Foreign key_1" FOREIGN KEY (id_seance)
        REFERENCES public.seance (id) MATCH SIMPLE
        ON UPDATE CASCADE
        ON DELETE CASCADE
        NOT VALID
)