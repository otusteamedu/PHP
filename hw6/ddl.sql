CREATE TABLE public.hall (
    id int2 NOT NULL GENERATED ALWAYS AS IDENTITY,
    "name" varchar(32) NOT NULL,
    CONSTRAINT hall_primary_key PRIMARY KEY (id)
);

CREATE INDEX hall_id ON public.hall USING btree (id);


CREATE TABLE public.movie (
    id int4 NOT NULL GENERATED ALWAYS AS IDENTITY,
    "name" varchar(32) NOT NULL,
    CONSTRAINT movie_primary_key PRIMARY KEY (id)
);

CREATE INDEX movie_id ON public.movie USING btree (id);


CREATE TABLE public."session" (
    id int4 NOT NULL GENERATED ALWAYS AS IDENTITY,
    movie_id int4 NOT NULL REFERENCES public.movie (id) ON DELETE CASCADE ON UPDATE CASCADE,
    hall_id int2 NOT NULL REFERENCES public.hall (id) ON DELETE CASCADE ON UPDATE CASCADE,
    "date" timestamptz(0) NOT NULL,
    CONSTRAINT session_primary_key PRIMARY KEY (id)
);

CREATE INDEX session_id ON public."session" USING btree (id);


CREATE TABLE public.ticket (
    id int4 NOT NULL GENERATED ALWAYS AS IDENTITY,
    session_id int4 NOT NULL REFERENCES public."session" (id) ON DELETE CASCADE ON UPDATE CASCADE,
    "row" int2 NOT NULL,
    place int2 NOT NULL,
    price money NOT NULL,
    sold boolean DEFAULT false NOT NULL,
    CONSTRAINT ticket_primary_key PRIMARY KEY (id)
);

CREATE INDEX ticket_id ON public.ticket USINg btree (id);