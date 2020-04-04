-- public.films definition

-- Drop table

-- DROP TABLE public.films;

CREATE TABLE public.films (
	id serial NOT NULL,
	"name" varchar NULL,
	CONSTRAINT films_pk PRIMARY KEY (id)
);
CREATE UNIQUE INDEX films_id_idx ON public.films USING btree (id);


-- public.halls definition

-- Drop table

-- DROP TABLE public.halls;

CREATE TABLE public.halls (
	id serial NOT NULL,
	"name" varchar(100) NULL,
	CONSTRAINT holls_pk PRIMARY KEY (id)
);
CREATE UNIQUE INDEX holls_id_idx ON public.halls USING btree (id);


-- public.seat_types definition

-- Drop table

-- DROP TABLE public.seat_types;

CREATE TABLE public.seat_types (
	id serial NOT NULL,
	"name" varchar NULL,
	CONSTRAINT seat_types_pk PRIMARY KEY (id)
);


-- public.film_attribute_types definition

-- Drop table

-- DROP TABLE public.film_attribute_types;

CREATE TABLE public.film_attribute_types (
	id serial NOT NULL,
	"type" varchar NULL,
	CONSTRAINT film_attribute_types_pk PRIMARY KEY (id)
);


-- public.seances definition

-- Drop table

-- DROP TABLE public.seances;

CREATE TABLE public.seances (
	id serial NOT NULL,
	id_film int4 NULL,
	id_hall int4 NULL,
	"time" time NULL,
	CONSTRAINT seances_pk PRIMARY KEY (id),
	CONSTRAINT seances_fk FOREIGN KEY (id_film) REFERENCES films(id),
	CONSTRAINT seances_fk_1 FOREIGN KEY (id_hall) REFERENCES halls(id)
);
CREATE INDEX seances_id_film_idx ON public.seances USING btree (id_film);
CREATE INDEX seances_id_holl_idx ON public.seances USING btree (id_hall);
CREATE UNIQUE INDEX seances_id_idx ON public.seances USING btree (id);


-- public.seats definition

-- Drop table

-- DROP TABLE public.seats;

CREATE TABLE public.seats (
	id_hall int4 NULL,
	seat_number int4 NULL,
	"row_number" int4 NULL,
	id serial NOT NULL,
	id_seat_type int4 NULL,
	id_price int4 NULL,
	CONSTRAINT seats_pk PRIMARY KEY (id),
	CONSTRAINT seats_fk FOREIGN KEY (id_hall) REFERENCES halls(id),
	CONSTRAINT seats_fk_2 FOREIGN KEY (id_seat_type) REFERENCES seat_types(id),
	CONSTRAINT seats_fk_price FOREIGN KEY (id_price) REFERENCES price(id)
);
CREATE INDEX seats_id_holl_idx ON public.seats USING btree (id_hall);
CREATE UNIQUE INDEX seats_id_idx ON public.seats USING btree (id);


-- public.tickets definition

-- Drop table

-- DROP TABLE public.tickets;

CREATE TABLE public.tickets (
	id serial NOT NULL,
	id_seance int4 NOT NULL,
	price numeric NULL,
	is_paid bool NULL DEFAULT false,
	id_seat int4 NOT NULL,
	CONSTRAINT tickets_pk PRIMARY KEY (id),
	CONSTRAINT tickets_fk_3 FOREIGN KEY (id_seat) REFERENCES seats(id)
);
CREATE UNIQUE INDEX tickets_id_idx ON public.tickets USING btree (id);


-- public.film_attributes definition

-- Drop table

-- DROP TABLE public.film_attributes;

CREATE TABLE public.film_attributes (
	id serial NOT NULL,
	id_type int4 NULL,
	"name" varchar NULL,
	CONSTRAINT film_attributes_pk PRIMARY KEY (id),
	CONSTRAINT film_attributes_fk FOREIGN KEY (id_type) REFERENCES film_attribute_types(id)
);


-- public.film_attribute_values definition

-- Drop table

-- DROP TABLE public.film_attribute_values;

CREATE TABLE public.film_attribute_values (
	id serial NOT NULL,
	id_attribute int4 NULL,
	id_film int4 NULL,
	val_int int4 NULL,
	val_date date NULL,
	val_float numeric NULL,
	val_bool bool NULL,
	val_text text NULL,
	CONSTRAINT film_attribute_values_pk PRIMARY KEY (id),
	CONSTRAINT film_attribute_values_fk FOREIGN KEY (id_film) REFERENCES films(id),
	CONSTRAINT film_attribute_values_fk_1 FOREIGN KEY (id_attribute) REFERENCES film_attributes(id)
);


-- public.price definition

-- Drop table

-- DROP TABLE public.price;

CREATE TABLE public.price (
	price numeric NULL,
	id serial NOT NULL,
	description varchar(50) NULL,
	CONSTRAINT price_pk PRIMARY KEY (id)
);