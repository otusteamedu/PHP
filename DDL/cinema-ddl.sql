DROP SCHEMA public CASCADE ;

CREATE SCHEMA public AUTHORIZATION postgres;

-- public.cinema definition

-- Drop table

-- DROP TABLE public.cinema;

CREATE TABLE public.cinema (
	id serial NOT NULL,
	"name" varchar(255) NOT NULL,
	address varchar(255) NOT NULL,
	CONSTRAINT cinema_id PRIMARY KEY (id)
);

-- public.customer definition

-- Drop table

-- DROP TABLE public.customer;

CREATE TABLE public.customer (
	id serial NOT NULL,
	"name" varchar NOT NULL,
	email varchar NOT NULL,
	CONSTRAINT customer_id PRIMARY KEY (id)
);

-- public.movie definition

-- Drop table

-- DROP TABLE public.movie;

CREATE TABLE public.movie (
	id serial NOT NULL,
	title varchar(255) NOT NULL,
	description varchar(1023) NOT NULL,
	duration int4 NOT NULL,
	CONSTRAINT movie_id PRIMARY KEY (id)
);
-- public.place_category definition

-- Drop table

-- DROP TABLE public.place_category;

CREATE TABLE public.place_category (
	id serial NOT NULL,
	"name" varchar NOT NULL,
	CONSTRAINT place_category_id PRIMARY KEY (id)
);

-- public.hall definition

-- Drop table

-- DROP TABLE public.hall;

CREATE TABLE public.hall (
	id serial NOT NULL,
	"name" varchar NOT NULL,
	id_cinema int4 NOT NULL,
	CONSTRAINT hall_id PRIMARY KEY (id)
);
CREATE INDEX hall_id_cinema ON public.hall USING btree (id_cinema);


-- public.hall foreign keys

ALTER TABLE public.hall ADD CONSTRAINT hall_fk FOREIGN KEY (id_cinema) REFERENCES cinema(id) ON DELETE CASCADE;


-- public.places definition

-- Drop table

-- DROP TABLE public.places;

CREATE TABLE public.places (
	id serial NOT NULL,
	id_place_category int4 NOT NULL,
	id_hall int4 NOT NULL,
	"row_number" int4 NOT NULL,
	place_number int4 NOT NULL,
	CONSTRAINT places_id_idxr PRIMARY KEY (id)
);
CREATE UNIQUE INDEX places_id_hall_idx ON public.places USING btree (id_hall, row_number, place_number);


-- public.places foreign keys

ALTER TABLE public.places ADD CONSTRAINT places_hall_fk FOREIGN KEY (id_hall) REFERENCES hall(id) ON DELETE CASCADE;
ALTER TABLE public.places ADD CONSTRAINT places_id_place_category_fkey FOREIGN KEY (id_place_category) REFERENCES place_category(id) ON DELETE CASCADE;


-- public.schedule definition

-- Drop table

-- DROP TABLE public.schedule;

CREATE TABLE public.schedule (
	id serial NOT NULL,
	id_hall int4 NOT NULL,
	id_movie int4 NOT NULL,
	date_start timestamp NOT NULL,
	date_end timestamp NOT NULL,
	CONSTRAINT schedule_id PRIMARY KEY (id)
);


-- public.schedule foreign keys

ALTER TABLE public.schedule ADD CONSTRAINT schedule_fk_hall FOREIGN KEY (id_hall) REFERENCES hall(id) ON DELETE CASCADE;
ALTER TABLE public.schedule ADD CONSTRAINT schedule_fk_movie FOREIGN KEY (id_movie) REFERENCES movie(id) ON DELETE CASCADE;


-- public.schedule_place_price definition

-- Drop table

-- DROP TABLE public.schedule_place_price;

CREATE TABLE public.schedule_place_price (
	id serial NOT NULL,
	id_schedule int4 NOT NULL,
	id_place_category int4 NOT NULL,
	price money NOT NULL,
	CONSTRAINT schedule_place_price_id PRIMARY KEY (id)
);


-- public.schedule_place_price foreign keys

ALTER TABLE public.schedule_place_price ADD CONSTRAINT schedule_place_price_id_place_category_fkey FOREIGN KEY (id_place_category) REFERENCES place_category(id) ON DELETE CASCADE;
ALTER TABLE public.schedule_place_price ADD CONSTRAINT schedule_place_price_id_schedule_fkey FOREIGN KEY (id_schedule) REFERENCES schedule(id) ON DELETE CASCADE;
-- public.booking definition

-- Drop table

-- DROP TABLE public.booking;

CREATE TABLE public.booking (
	id serial NOT NULL,
	id_schedule int4 NOT NULL,
	id_customer int4 NOT NULL,
	created_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
	updated_at timestamp NOT NULL,
	id_place int4 NOT NULL,
	CONSTRAINT booking_id PRIMARY KEY (id)
);
CREATE UNIQUE INDEX booking_id_schedule_idx ON public.booking USING btree (id_schedule, id_place);


-- public.booking foreign keys

ALTER TABLE public.booking ADD CONSTRAINT booking_fk FOREIGN KEY (id_place) REFERENCES places(id) ON DELETE CASCADE;
ALTER TABLE public.booking ADD CONSTRAINT booking_fk_customer FOREIGN KEY (id_customer) REFERENCES customer(id) ON DELETE CASCADE;
ALTER TABLE public.booking ADD CONSTRAINT booking_fk_schedule FOREIGN KEY (id_schedule) REFERENCES schedule(id) ON DELETE CASCADE;