
CREATE TABLE public.attributes
(
    id integer NOT NULL GENERATED ALWAYS AS IDENTITY ( INCREMENT 1 START 1 MINVALUE 1 MAXVALUE 2147483647 CACHE 1 ),
    attr_name character varying(100) COLLATE pg_catalog."default",
    id_type integer,
    CONSTRAINT attributes_pkey PRIMARY KEY (id),
    CONSTRAINT foreign_key_2 FOREIGN KEY (id_type)
        REFERENCES public.attributes_types (id) MATCH SIMPLE
        ON UPDATE CASCADE
        ON DELETE CASCADE
)

CREATE TABLE public.attributes_types
(
    id integer NOT NULL GENERATED ALWAYS AS IDENTITY ( INCREMENT 1 START 1 MINVALUE 1 MAXVALUE 2147483647 CACHE 1 ),
    type_name character varying(100) COLLATE pg_catalog."default",
    CONSTRAINT attributes_types_pkey PRIMARY KEY (id)
)
CREATE TABLE public.attributes_value
(
    id integer NOT NULL GENERATED ALWAYS AS IDENTITY ( INCREMENT 1 START 1 MINVALUE 1 MAXVALUE 2147483647 CACHE 1 ),
    id_attributes integer NOT NULL,
    id_film integer,
    text_val text COLLATE pg_catalog."default",
    boolean_val boolean,
    date_val timestamp(6) without time zone,
    CONSTRAINT attributes_value_pkey PRIMARY KEY (id),
    CONSTRAINT foreign_key_1 FOREIGN KEY (id_attributes)
        REFERENCES public.attributes (id) MATCH SIMPLE
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT foreign_key_2 FOREIGN KEY (id_film)
        REFERENCES public.film (id) MATCH SIMPLE
        ON UPDATE CASCADE
        ON DELETE CASCADE
)
CREATE TABLE public.clients
(
    id integer NOT NULL GENERATED ALWAYS AS IDENTITY ( INCREMENT 1 START 1 MINVALUE 1 MAXVALUE 2147483647 CACHE 1 ),
    name character varying(100) COLLATE pg_catalog."default",
    CONSTRAINT clients_pkey PRIMARY KEY (id)
)

CREATE TABLE public.film
(
    id integer NOT NULL GENERATED ALWAYS AS IDENTITY ( INCREMENT 1 START 1 MINVALUE 1 MAXVALUE 2147483647 CACHE 1 ),
    film_name character varying(100) COLLATE pg_catalog."default",
    CONSTRAINT film_pkey PRIMARY KEY (id)
)

CREATE TABLE public.hall
(
    id integer NOT NULL GENERATED ALWAYS AS IDENTITY ( INCREMENT 1 START 1 MINVALUE 1 MAXVALUE 2147483647 CACHE 1 ),
    hall_name character varying(100) COLLATE pg_catalog."default" NOT NULL,
    CONSTRAINT hall_pkey PRIMARY KEY (id)
)

CREATE TABLE public.seance
(
    id integer NOT NULL GENERATED ALWAYS AS IDENTITY ( INCREMENT 1 START 1 MINVALUE 1 MAXVALUE 2147483647 CACHE 1 ),
    id_film integer,
    id_hall integer,
    datetime timestamp without time zone,
    price_seance numeric(10,0),
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
    price_tickets numeric(10,0),
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