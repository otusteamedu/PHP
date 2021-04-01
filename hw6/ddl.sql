CREATE TABLE public.hall (
    id SMALLINT NOT NULL GENERATED ALWAYS AS IDENTITY,
    "name" VARCHAR(32) NOT NULL,
    PRIMARY KEY (id),
    UNIQUE (id)
);

CREATE INDEX hall_id_idx ON public.hall USING btree (id);


CREATE TABLE public.hall_place (
    id SMALLINT NOT NULL GENERATED ALWAYS AS IDENTITY,
    hall_id SMALLINT NOT NULL REFERENCES public.hall (id) ON DELETE CASCADE ON UPDATE CASCADE,
    "row" SMALLINT NOT NULL,
    seat_number SMALLINT NOT NULL,
    cost_factor DECIMAL(2,1) NOT NULL,
    PRIMARY KEY (id),
    UNIQUE (id)
);

CREATE INDEX hall_place_id_idx ON public.hall_place USING btree (id);


CREATE TABLE public.movie (
    id INT NOT NULL GENERATED ALWAYS AS IDENTITY,
    "name" VARCHAR(32) NOT NULL,
    PRIMARY KEY (id),
    UNIQUE (id)
);

CREATE INDEX movie_id_idx ON public.movie USING btree (id);


CREATE TABLE public."session" (
    id INT NOT NULL GENERATED ALWAYS AS IDENTITY,
    movie_id INT NOT NULL REFERENCES public.movie (id) ON DELETE CASCADE ON UPDATE CASCADE,
    hall_id SMALLINT NOT NULL REFERENCES public.hall (id) ON DELETE CASCADE ON UPDATE CASCADE,
    session_start TIMESTAMP(0) NOT NULL,
    session_end TIMESTAMP(0) NOT NULL,
    base_cost MONEY NOT NULL,
    PRIMARY KEY (id),
    UNIQUE (id)
);

CREATE INDEX session_id_idx ON public."session" USING btree (id);


CREATE TABLE public.ticket (
    id INT NOT NULL GENERATED ALWAYS AS IDENTITY,
    session_id INT NOT NULL REFERENCES public."session" (id) ON DELETE CASCADE ON UPDATE CASCADE,
    hall_place_id SMALLINT NOT NULL REFERENCES public.hall_place (id) ON DELETE CASCADE ON UPDATE CASCADE,
    "cost" MONEY NOT NULL,
    PRIMARY KEY (id),
    UNIQUE (id)
);

CREATE INDEX ticket_id_idx ON public.ticket USING btree (id);