CREATE SEQUENCE public.id_seq
    INCREMENT 1
    START 14
    MINVALUE 1
    MAXVALUE 9223372036854775807
    CACHE 1;

ALTER SEQUENCE public.id_seq

CREATE TABLE public.buy_ticket
(
    id integer NOT NULL DEFAULT nextval('id_seq'::regclass),
    id_ticket integer NOT NULL,
    id_client integer NOT NULL,
    CONSTRAINT buy_ticket_pkey PRIMARY KEY (id),
    CONSTRAINT "Foreign_key_2" FOREIGN KEY (id_client)
        REFERENCES public.clients (id) MATCH SIMPLE
        ON UPDATE CASCADE
        ON DELETE CASCADE
        NOT VALID,
    CONSTRAINT foreign_key_1 FOREIGN KEY (id_ticket)
        REFERENCES public.tickets (id) MATCH SIMPLE
        ON UPDATE CASCADE
        ON DELETE CASCADE
        NOT VALID
)

CREATE TABLE public.clients
(
    id integer NOT NULL DEFAULT nextval('id_seq'::regclass),
    name character(10) COLLATE pg_catalog."default" NOT NULL,
    CONSTRAINT clients_pkey PRIMARY KEY (id)
)

CREATE TABLE public.film
(
    id integer NOT NULL DEFAULT nextval('id_seq'::regclass),
    name character(10) COLLATE pg_catalog."default",
    price_basic integer,
    CONSTRAINT film_pkey PRIMARY KEY (id)
)

CREATE TABLE public.hall
(
    id integer NOT NULL DEFAULT nextval('id_seq'::regclass),
    name character(10) COLLATE pg_catalog."default" NOT NULL,
    CONSTRAINT hall_pkey PRIMARY KEY (id)
)


CREATE TABLE public.seance
(
    id integer NOT NULL DEFAULT nextval('id_seq'::regclass),
    "time" time(6) without time zone NOT NULL,
    price_increase integer NOT NULL,
    CONSTRAINT seance_pkey PRIMARY KEY (id)
)

CREATE TABLE public.tickets
(
    id integer NOT NULL DEFAULT nextval('id_seq'::regclass),
    id_seance integer NOT NULL,
    id_hall integer NOT NULL,
    id_films integer NOT NULL,
    CONSTRAINT tickets_pkey PRIMARY KEY (id),
    CONSTRAINT "Foreign key_1" FOREIGN KEY (id_seance)
        REFERENCES public.seance (id) MATCH SIMPLE
        ON UPDATE CASCADE
        ON DELETE CASCADE
        NOT VALID,
    CONSTRAINT "Foreign key_2" FOREIGN KEY (id_hall)
        REFERENCES public.hall (id) MATCH SIMPLE
        ON UPDATE CASCADE
        ON DELETE CASCADE
        NOT VALID,
    CONSTRAINT "Foreign key_3" FOREIGN KEY (id_films)
        REFERENCES public.film (id) MATCH SIMPLE
        ON UPDATE CASCADE
        ON DELETE CASCADE
        NOT VALID
)