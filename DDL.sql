CREATE TABLE public.films (
	id serial NOT NULL,
	"name" varchar NULL,
	CONSTRAINT films_pk PRIMARY KEY (id)
);
CREATE UNIQUE INDEX films_id_idx ON public.films USING btree (id);



CREATE TABLE public.halls (
	id serial NOT NULL,
	"name" varchar(100) NULL,
	CONSTRAINT halls_pk PRIMARY KEY (id)
);
CREATE UNIQUE INDEX halls_id_idx ON public.halls USING btree (id);



CREATE TABLE public.seat_types (
	id serial NOT NULL,
	"name" varchar NULL,
	CONSTRAINT seat_types_pk PRIMARY KEY (id)
);



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
CREATE INDEX seances_id_hall_idx ON public.seances USING btree (id_hall);
CREATE UNIQUE INDEX seances_id_idx ON public.seances USING btree (id);



CREATE TABLE public.seats (
	id serial NOT NULL,
	id_hall int4 NULL,
	seat_number int4 NULL,
	"row_number" int4 NULL,
	id_seat_type int4 NULL,
	CONSTRAINT seats_pk PRIMARY KEY (id),
	CONSTRAINT seats_fk FOREIGN KEY (id_hall) REFERENCES halls(id),
	CONSTRAINT seats_fk_2 FOREIGN KEY (id_seat_type) REFERENCES seat_types(id)
);
CREATE INDEX seats_id_hall_idx ON public.seats USING btree (id_hall);
CREATE UNIQUE INDEX seats_id_idx ON public.seats USING btree (id);



CREATE TABLE public.tickets (
	id serial NOT NULL,
	id_seance int4 NOT NULL,
	price numeric NULL,
	is_paid bool NULL DEFAULT false,
	id_seat int4 NOT NULL,
	CONSTRAINT tickets_pk PRIMARY KEY (id),
	CONSTRAINT tickets_fk_1 FOREIGN KEY (id_seance) REFERENCES seances(id),
	CONSTRAINT tickets_fk_3 FOREIGN KEY (id_seat) REFERENCES seats(id)
);
CREATE UNIQUE INDEX tickets_id_idx ON public.tickets USING btree (id);
CREATE INDEX tickets_id_seance_idx ON public.tickets USING btree (id_seance);



CREATE TABLE public.price (
	id_seance int4 NOT NULL,
	id_seat_type int4 NOT NULL,
	price numeric NULL,
	CONSTRAINT price_fk FOREIGN KEY (id_seat_type) REFERENCES seat_types(id),
	CONSTRAINT price_fk_1 FOREIGN KEY (id_seance) REFERENCES seances(id)
);