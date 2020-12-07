CREATE TABLE public.halls (
	id smallserial NOT NULL,
	"name" varchar(255) NOT NULL,
	CONSTRAINT halls_pk PRIMARY KEY (id)
);

CREATE TABLE public."content" (
	id bigserial NOT NULL,
	"name" varchar(255) NOT NULL,
	id_genre int2 NOT NULL,
	age_limit int4 NOT NULL,
	movie_length int4 NOT NULL,
	CONSTRAINT content_pk PRIMARY KEY (id),
	CONSTRAINT content_fk FOREIGN KEY (id_genre) REFERENCES genre(id)
);

CREATE TABLE public.seance (
	id bigserial NOT NULL,
	time_begin int4 NOT NULL,
	time_end int4 NOT NULL,
	id_content int4 NOT NULL,
	id_hall int4 NOT NULL,
	price money NOT NULL,
	CONSTRAINT seance_pk PRIMARY KEY (id),
	CONSTRAINT seance_fk FOREIGN KEY (id_content) REFERENCES content(id),
	CONSTRAINT seance_fk_1 FOREIGN KEY (id_hall) REFERENCES halls(id)
);

CREATE TABLE public.tickets (
	id bigserial NOT NULL,
	cusomer_id int4 NOT NULL,
	id_seance int4 NOT NULL,
	id_place int4 NOT NULL,
	CONSTRAINT tickets_pk PRIMARY KEY (id),
	CONSTRAINT tickets_fk FOREIGN KEY (id_seance) REFERENCES seance(id),
	CONSTRAINT tickets_fk_1 FOREIGN KEY (id_place) REFERENCES places(id)
);
CREATE UNIQUE INDEX tickets_id_seance_idx ON public.tickets USING btree (id_seance, id_place);

CREATE TABLE public.places (
	id smallserial NOT NULL,
	"row" int4 NOT NULL,
	place_number int4 NOT NULL,
	id_hall int4 NOT NULL,
	price_coefficient numeric NOT NULL,
	CONSTRAINT places_pk PRIMARY KEY (id),
	CONSTRAINT places_fk FOREIGN KEY (id_hall) REFERENCES halls(id)
);
CREATE UNIQUE INDEX places_place_number_idx ON public.places USING btree (place_number, "row", id_hall);

CREATE OR REPLACE VIEW public.tickets_price
AS SELECT t.id,
    s.price * p.price_coefficient::double precision AS price
   FROM tickets t
     JOIN seance s ON t.id_seance = s.id
     JOIN places p ON t.id_place = p.id;
