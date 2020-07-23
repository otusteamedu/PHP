CREATE SCHEMA public AUTHORIZATION postgres;
-- CINEMA
CREATE TABLE public.cinema (
	id serial NOT NULL,
	"name" varchar(255) NOT NULL,
	address varchar(255) NOT NULL,
	CONSTRAINT cinema_id PRIMARY KEY (id)
);

-- HALL

CREATE TABLE public.hall (
	id serial NOT NULL,
	"name" varchar NOT NULL,
	id_cinema int4 NOT NULL,
	place_count int4 NOT NULL,
	CONSTRAINT hall_id PRIMARY KEY (id)
);
CREATE INDEX hall_id_cinema ON public.hall USING btree (id_cinema);
ALTER TABLE public.hall ADD CONSTRAINT hall_fk FOREIGN KEY (id_cinema) REFERENCES cinema(id) ON DELETE CASCADE;

-- MOVIE
CREATE TABLE public.movie (
	id serial NOT NULL,
	title varchar(255) NOT NULL,
	description varchar(1023) NOT NULL,
	duration int4 NOT NULL,
	CONSTRAINT movie_id PRIMARY KEY (id)
);

-- CUSTOMER 
CREATE TABLE public.customer (
	id serial NOT NULL,
	"name" varchar NOT NULL,
	email varchar NOT NULL,
	CONSTRAINT customer_id PRIMARY KEY (id)
);

-- SCHEDULE
CREATE TABLE public.schedule (
	id serial NOT NULL,
	id_hall int4 NOT NULL,
	id_movie int4 NOT NULL,
	price money NOT NULL,
	date_start timestamp NOT NULL,
	date_end timestamp NOT NULL,
	CONSTRAINT schedule_id PRIMARY KEY (id)
);
ALTER TABLE public.schedule ADD CONSTRAINT schedule_id_hall_fkey FOREIGN KEY (id_hall) REFERENCES hall(id) ON DELETE CASCADE;
ALTER TABLE public.schedule ADD CONSTRAINT schedule_id_movie_fkey FOREIGN KEY (id_movie) REFERENCES movie(id) ON DELETE CASCADE;


-- BOOKING 
CREATE TABLE public.booking (
	id serial NOT NULL,
	id_schedule int4 NOT NULL,
	id_customer int4 NOT NULL,
	created_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
	updated_at timestamp NOT NULL,
	CONSTRAINT booking_id PRIMARY KEY (id)
);
ALTER TABLE public.booking ADD CONSTRAINT booking_id_customer_fkey FOREIGN KEY (id_customer) REFERENCES customer(id) ON DELETE CASCADE;
ALTER TABLE public.booking ADD CONSTRAINT booking_id_schedule_fkey FOREIGN KEY (id_schedule) REFERENCES schedule(id) ON DELETE CASCADE;