-- public.client definition

-- Drop table

-- DROP TABLE public.client;

CREATE TABLE public.client (
	id int4 NOT NULL GENERATED ALWAYS AS IDENTITY,
	"name" varchar(255) NOT NULL,
	CONSTRAINT client_pk PRIMARY KEY (id)
);


-- public.hall definition

-- Drop table

-- DROP TABLE public.hall;

CREATE TABLE public.hall (
	id int2 NOT NULL GENERATED ALWAYS AS IDENTITY,
	"name" varchar(255) NOT NULL,
	CONSTRAINT hall_pk PRIMARY KEY (id)
);


-- public.movie definition

-- Drop table

-- DROP TABLE public.movie;

CREATE TABLE public.movie (
	id int4 NOT NULL GENERATED ALWAYS AS IDENTITY,
	"name" varchar(255) NOT NULL,
	CONSTRAINT movie_pk PRIMARY KEY (id)
);


-- public.movie_eav_attribute_type definition

-- Drop table

-- DROP TABLE public.movie_eav_attribute_type;

CREATE TABLE public.movie_eav_attribute_type (
	id int2 NOT NULL GENERATED ALWAYS AS IDENTITY,
	"name" varchar(255) NOT NULL,
	CONSTRAINT movie_eav_attribute_type_pk PRIMARY KEY (id)
);


-- public.seat_type definition

-- Drop table

-- DROP TABLE public.seat_type;

CREATE TABLE public.seat_type (
	id int2 NOT NULL GENERATED ALWAYS AS IDENTITY,
	"name" varchar(255) NOT NULL,
	CONSTRAINT seat_type_pk PRIMARY KEY (id)
);


-- public.movie_eav_attribute definition

-- Drop table

-- DROP TABLE public.movie_eav_attribute;

CREATE TABLE public.movie_eav_attribute (
	id int2 NOT NULL GENERATED ALWAYS AS IDENTITY,
	attribute_type_id int2 NOT NULL,
	"name" varchar(255) NOT NULL,
	CONSTRAINT movie_eav_attribute_pk PRIMARY KEY (id),
	CONSTRAINT movie_eav_attribute_fk FOREIGN KEY (attribute_type_id) REFERENCES movie_eav_attribute_type(id) ON UPDATE RESTRICT ON DELETE RESTRICT
);
CREATE INDEX movie_eav_attribute_attribute_type_id_idx ON public.movie_eav_attribute USING btree (attribute_type_id);


-- public.movie_eav_value definition

-- Drop table

-- DROP TABLE public.movie_eav_value;

CREATE TABLE public.movie_eav_value (
	id int4 NOT NULL GENERATED ALWAYS AS IDENTITY,
	movie_id int2 NOT NULL,
	attribute_id int2 NOT NULL,
	integer_value int4 NULL,
	text_value text NULL,
	short_text_value varchar(255) NULL,
	boolean_value bool NULL,
	decimal_value float4 NULL,
	datetime_value timestamp NULL,
	CONSTRAINT movie_eav_value_pk PRIMARY KEY (id),
	CONSTRAINT movie_eav_value_fk FOREIGN KEY (movie_id) REFERENCES movie(id) ON UPDATE RESTRICT ON DELETE RESTRICT,
	CONSTRAINT movie_eav_value_fk_1 FOREIGN KEY (attribute_id) REFERENCES movie_eav_attribute(id) ON UPDATE RESTRICT ON DELETE RESTRICT
);
CREATE INDEX movie_eav_value_attribute_id_idx ON public.movie_eav_value USING btree (attribute_id);
CREATE INDEX movie_eav_value_movie_id_idx ON public.movie_eav_value USING btree (movie_id);


-- public.seats definition

-- Drop table

-- DROP TABLE public.seats;

CREATE TABLE public.seats (
	id int2 NOT NULL GENERATED ALWAYS AS IDENTITY,
	hall_id int2 NOT NULL,
	seat_type_id int2 NOT NULL,
	quantity int2 NOT NULL,
	CONSTRAINT seats_pk PRIMARY KEY (id),
	CONSTRAINT seats_hall_fk FOREIGN KEY (hall_id) REFERENCES hall(id),
	CONSTRAINT seats_type_fk FOREIGN KEY (seat_type_id) REFERENCES seat_type(id)
);
CREATE INDEX seats_hall_id_idx ON public.seats USING btree (hall_id);
CREATE INDEX seats_seat_type_id_idx ON public.seats USING btree (seat_type_id);


-- public."session" definition

-- Drop table

-- DROP TABLE public."session";

CREATE TABLE public."session" (
	id int4 NOT NULL GENERATED ALWAYS AS IDENTITY,
	hall_id int2 NOT NULL,
	movie_id int4 NOT NULL,
	"date" timestamp NOT NULL,
	CONSTRAINT session_pk PRIMARY KEY (id),
	CONSTRAINT session_fk FOREIGN KEY (hall_id) REFERENCES hall(id) ON UPDATE RESTRICT ON DELETE RESTRICT,
	CONSTRAINT session_movie_fk FOREIGN KEY (movie_id) REFERENCES movie(id) ON UPDATE RESTRICT ON DELETE RESTRICT
);
CREATE INDEX session_hall_id_idx ON public.session USING btree (hall_id);
CREATE INDEX session_movie_id_idx ON public.session USING btree (movie_id);


-- public.place definition

-- Drop table

-- DROP TABLE public.place;

CREATE TABLE public.place (
	id int4 NOT NULL GENERATED ALWAYS AS IDENTITY,
	session_id int4 NOT NULL,
	seats_id int2 NOT NULL,
	price numeric(10,2) NOT NULL,
	CONSTRAINT ticket_price_pk PRIMARY KEY (id),
	CONSTRAINT ticket_price_fk FOREIGN KEY (session_id) REFERENCES session(id),
	CONSTRAINT ticket_price_fk_1 FOREIGN KEY (seats_id) REFERENCES seats(id)
);
CREATE INDEX ticket_price_seats_id_idx ON public.place USING btree (seats_id);
CREATE INDEX ticket_price_session_id_idx ON public.place USING btree (session_id);


-- public.ticket definition

-- Drop table

-- DROP TABLE public.ticket;

CREATE TABLE public.ticket (
	id int4 NOT NULL GENERATED ALWAYS AS IDENTITY,
	client_id int4 NOT NULL,
	paid numeric(10,2) NOT NULL,
	place_id int4 NOT NULL,
	seat_number int2 NOT NULL,
	CONSTRAINT ticket_pk PRIMARY KEY (id),
	CONSTRAINT ticket_fk FOREIGN KEY (place_id) REFERENCES place(id),
	CONSTRAINT ticket_fk_1 FOREIGN KEY (client_id) REFERENCES client(id) ON UPDATE RESTRICT ON DELETE RESTRICT
);
CREATE INDEX ticket_client_id_idx ON public.ticket USING btree (client_id);
CREATE INDEX ticket_place_id_idx ON public.ticket USING btree (place_id);


-- public.service_task source

CREATE OR REPLACE VIEW public.service_task
AS SELECT max(m.name::text) AS movie,
    string_agg(
        CASE
            WHEN mev.datetime_value = CURRENT_DATE THEN mea.name
            ELSE NULL::character varying
        END::text, ', '::text) AS today,
    string_agg(
        CASE
            WHEN mev.datetime_value = (CURRENT_DATE + '20 days'::interval) THEN mea.name
            ELSE NULL::character varying
        END::text, ', '::text) AS after_20_days
   FROM movie m
     JOIN movie_eav_value mev ON mev.movie_id = m.id
     JOIN movie_eav_attribute mea ON mea.id = mev.attribute_id
  WHERE mea.attribute_type_id = 3
  GROUP BY m.id;

-- public.marketing_data source

CREATE OR REPLACE VIEW public.marketing_data
AS SELECT m.name AS movie,
    meat.name AS type,
    mea.name AS attribute,
        CASE
            WHEN mea.attribute_type_id = 1 THEN mev.integer_value::text
            WHEN mea.attribute_type_id = 2 THEN mev.text_value
            WHEN mea.attribute_type_id = 3 THEN mev.datetime_value::text
            WHEN mea.attribute_type_id = 4 THEN mev.short_text_value::text
            WHEN mea.attribute_type_id = 5 THEN mev.boolean_value::text
            WHEN mea.attribute_type_id = 6 THEN mev.decimal_value::text
            ELSE NULL::text
        END AS value
   FROM movie m
     JOIN movie_eav_value mev ON mev.movie_id = m.id
     JOIN movie_eav_attribute mea ON mea.id = mev.attribute_id
     JOIN movie_eav_attribute_type meat ON meat.id = mea.attribute_type_id;