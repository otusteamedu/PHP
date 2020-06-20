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


-- public."session" definition

-- Drop table

-- DROP TABLE public."session";

CREATE TABLE public."session" (
	id int4 NOT NULL GENERATED ALWAYS AS IDENTITY,
	hall_id int2 NOT NULL,
	movie_id int4 NOT NULL,
	"date" date NOT NULL,
	price numeric(10,2) NOT NULL,
	"time" time NOT NULL,
	CONSTRAINT session_pk PRIMARY KEY (id),
	CONSTRAINT session_fk FOREIGN KEY (hall_id) REFERENCES hall(id) ON UPDATE RESTRICT ON DELETE RESTRICT,
	CONSTRAINT session_movie_fk FOREIGN KEY (movie_id) REFERENCES movie(id) ON UPDATE RESTRICT ON DELETE RESTRICT
);
CREATE INDEX session_hall_id_idx ON public.session USING btree (hall_id);
CREATE INDEX session_movie_id_idx ON public.session USING btree (movie_id);


-- public.ticket definition

-- Drop table

-- DROP TABLE public.ticket;

CREATE TABLE public.ticket (
	id int4 NOT NULL GENERATED ALWAYS AS IDENTITY,
	session_id int4 NOT NULL,
	client_id int4 NOT NULL,
	CONSTRAINT ticket_pk PRIMARY KEY (id),
	CONSTRAINT ticket_fk FOREIGN KEY (session_id) REFERENCES session(id) ON UPDATE RESTRICT ON DELETE RESTRICT,
	CONSTRAINT ticket_fk_1 FOREIGN KEY (client_id) REFERENCES client(id) ON UPDATE RESTRICT ON DELETE RESTRICT
);
CREATE INDEX ticket_client_id_idx ON public.ticket USING btree (client_id);
CREATE INDEX ticket_session_id_idx ON public.ticket USING btree (session_id);