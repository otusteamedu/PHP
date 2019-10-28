
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
    realis_number_val numeric(10,0),
    float_number_val double precision,
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


TRUNCATE TABLE
    tickets,
    clients,
    seance,
    hall,
    attributes_value,
    attributes,
    attributes_types,
    film;


ALTER TABLE clients 
    ALTER COLUMN id
        RESTART WITH 1;

ALTER TABLE tickets 
    ALTER COLUMN id
        RESTART WITH 1;

ALTER TABLE seance 
    ALTER COLUMN id
        RESTART WITH 1;

ALTER TABLE hall 
    ALTER COLUMN id
        RESTART WITH 1;

ALTER TABLE attributes_value 
    ALTER COLUMN id
        RESTART WITH 1;

ALTER TABLE attributes
    ALTER COLUMN id
        RESTART WITH 1;

ALTER TABLE attributes_types
    ALTER COLUMN id
        RESTART WITH 1;

ALTER TABLE film
    ALTER COLUMN id
        RESTART WITH 1;


CREATE OR REPLACE FUNCTION random_between(low INT ,high INT)
    RETURNS INT AS
$$
BEGIN
    RETURN floor(random()* (high-low + 1) + low);
END;
$$ language 'plpgsql' STRICT; 

CREATE OR REPLACE FUNCTION random_string() returns text AS
$$
declare
    chars text[] := '{0,1,2,3,4,5,6,7,8,9,A,B,C,D,E,F,G,H,I,J,K,L,M,N,O,P,Q,R,S,T,U,V,W,X,Y,Z,a,b,c,d,e,f,g,h,i,j,k,l,m,n,o,p,q,r,s,t,u,v,w,x,y,z}';
    result text := '';
    i integer := 0;
begin
    for i in 1..10 loop
        result := result || chars[1+random()*(array_length(chars, 1)-1)];
    end loop;
    return result;
end
$$ language plpgsql;



INSERT INTO hall(hall_name)
SELECT
    random_string()
FROM generate_series(1,4);


INSERT INTO film (film_name)
SELECT
    random_string()
FROM generate_series(1,11);


INSERT INTO clients (name)
SELECT
    random_string()
FROM generate_series(1,5000);


INSERT INTO seance (id_film ,id_hall, datetime ,price_seance)
SELECT
    random_between (1, 11),
    random_between (1,4),
    date_trunc('second',LOCALTIMESTAMP(1) + (random() * ( LOCALTIMESTAMP(1)+'90 days' -  LOCALTIMESTAMP(1)))),
    random_between (200, 900)
FROM generate_series(1,55);

INSERT INTO attributes_types(type_name)
SELECT
     random_string()
FROM generate_series(1,10);

INSERT INTO attributes(attr_name,id_type)
SELECT
    random_string(),
    random_between (1,10)
FROM generate_series(1,20);

INSERT INTO attributes_value(id_attributes,id_film,text_val,boolean_val,date_val,realis_number_val,float_number_val)
SELECT
    random_between (1,20),
    random_between (1,11),
    random_string(),
    random()<0.5,
    date_trunc('second',LOCALTIMESTAMP(1) + (random() * ( LOCALTIMESTAMP(1)+'90 days' -  LOCALTIMESTAMP(1)))),
    random_between (1,1000),
    random_between (1,10000000)
FROM generate_series(1,20);

INSERT INTO tickets(id_seance,id_client,price_tickets)
SELECT
    random_between (1,55),
    random_between (1,5000),
    random_between (200, 900)
FROM generate_series(1,10000);





