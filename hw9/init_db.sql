CREATE TABLE public.halls (
    id serial NOT NULL,
    "name" varchar(255) NOT NULL,
    CONSTRAINT halls_pk PRIMARY KEY (id)
);

CREATE UNIQUE INDEX halls_name_idx ON public.halls (lower("name"));

CREATE TABLE public.places (
    id serial NOT NULL,
    hall_id serial NOT NULL,
    place_tariff numeric(6, 2) NOT NULL CHECK (place_tariff >= 0),
    CONSTRAINT places_pk PRIMARY KEY (id),
    CONSTRAINT places_fk FOREIGN KEY (hall_id) REFERENCES halls(id)
);

CREATE TABLE public.movies (
    id serial NOT NULL,
    "name" varchar(255) NOT NULL,
    description varchar(1024) NULL,
    CONSTRAINT movies_pk PRIMARY KEY (id)
);

CREATE TABLE public.sessions (
    id serial NOT NULL,
    hall_id serial NOT NULL,
    movie_id serial NOT NULL,
    session_tariff numeric(6, 2) NOT NULL CHECK (session_tariff >= 0),
    "date" timestamp NOT NULL,
    CONSTRAINT sessions_pk PRIMARY KEY (id),
    CONSTRAINT sessions_fk FOREIGN KEY (hall_id) REFERENCES public.halls(id),
    CONSTRAINT sessions_fk_1 FOREIGN KEY (movie_id) REFERENCES public.movies(id)
);

CREATE TABLE public.tickets (
    id serial NOT NULL,
    place_id serial NOT NULL,
    session_id serial NOT NULL,
    price numeric(6, 2) NOT NULL CHECK (price >= 0),
    CONSTRAINT tickets_pk PRIMARY KEY (id),
    CONSTRAINT tickets_fk FOREIGN KEY (place_id) REFERENCES public.places(id),
    CONSTRAINT tickets_fk_1 FOREIGN KEY (session_id) REFERENCES public.sessions(id)
);

CREATE TABLE public.movies_attr_type (
    id serial NOT NULL,
    "name" varchar(64) NOT NULL,
    CONSTRAINT movies_attr_type_pk PRIMARY KEY (id)
);

CREATE TABLE public.movies_attr (
    id serial NOT NULL,
    type_id serial NOT NULL,
    "name" varchar(255) NOT NULL,
    CONSTRAINT movies_attr_pk PRIMARY KEY (id),
    CONSTRAINT movies_attr_fk FOREIGN KEY (type_id) REFERENCES public.movies_attr_type(id)
);

CREATE UNIQUE INDEX movies_attr_name_idx ON public.movies_attr (lower("name"));

CREATE TABLE public.movies_attr_value (
    id serial NOT NULL,
    movie_id serial NOT NULL,
    movie_attr_id serial NOT NULL,
    value_string varchar NULL,
    value_date timestamp NULL,
    value_bool boolean NULL,
    value_float float NULL,
    value_int int NULL,
    CONSTRAINT movies_attr_value_pk PRIMARY KEY (id),
    CONSTRAINT movies_attr_value_fk FOREIGN KEY (movie_id) REFERENCES public.movies(id),
    CONSTRAINT movies_attr_value_fk_1 FOREIGN KEY (movie_attr_id) REFERENCES public.movies_attr(id)
);