-- Drop table

-- DROP TABLE public.hall;

CREATE TABLE public.hall (
	id int2 NOT NULL GENERATED ALWAYS AS IDENTITY,
	"name" varchar(20) NOT NULL,
	CONSTRAINT hall_pk PRIMARY KEY (id)
);
CREATE INDEX hall_id_idx ON public.hall USING btree (id);
-- Drop table

-- DROP TABLE public."location";

CREATE TABLE public."location" (
	id int4 NOT NULL GENERATED ALWAYS AS IDENTITY,
	hall_id int2 NOT NULL,
	place int2 NOT NULL,
	"row" int2 NOT NULL,
	CONSTRAINT location_pk PRIMARY KEY (id),
	CONSTRAINT location_fk FOREIGN KEY (id) REFERENCES hall(id)
);
CREATE INDEX location_id_idx ON public.location USING btree (id);
-- Drop table

-- DROP TABLE public.movie;

CREATE TABLE public.movie (
	id int4 NOT NULL GENERATED ALWAYS AS IDENTITY,
	"name" varchar(40) NOT NULL,
	CONSTRAINT movie_pk PRIMARY KEY (id)
);
CREATE INDEX movie_id_idx ON public.movie USING btree (id);
-- Drop table

-- DROP TABLE public."session";

CREATE TABLE public."session" (
	id int4 NOT NULL GENERATED ALWAYS AS IDENTITY,
	movie_id int4 NOT NULL,
	"date" timestamptz(0) NOT NULL,
	CONSTRAINT session_pk PRIMARY KEY (id),
	CONSTRAINT session_fk FOREIGN KEY (movie_id) REFERENCES movie(id) ON UPDATE CASCADE ON DELETE CASCADE
);
-- Drop table

-- DROP TABLE public.ticket;

CREATE TABLE public.ticket (
	session_id int4 NOT NULL,
	location_id int4 NOT NULL,
	is_bought int2 NOT NULL DEFAULT 0,
	price money NOT NULL,
	CONSTRAINT ticket_pk PRIMARY KEY (session_id, location_id),
	CONSTRAINT ticket_fk FOREIGN KEY (session_id) REFERENCES session(id),
	CONSTRAINT ticket_fk_1 FOREIGN KEY (location_id) REFERENCES location(id)
);

