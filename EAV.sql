-- add attr type table
CREATE TABLE public.movie_attr_type
(
    id        serial       NOT NULL,
    name      varchar(255) NOT NULL,
    "comment" varchar      NULL,
    CONSTRAINT movie_attr_type_pk PRIMARY KEY (id)
);

-- add attr table
CREATE TABLE public.movie_attr
(
    id      serial       NOT NULL,
    id_type int          NOT NULL,
    "name"  varchar(255) NOT NULL,
    CONSTRAINT movie_attr_pk PRIMARY KEY (id),
    CONSTRAINT movie_attr_fk FOREIGN KEY (id_type) REFERENCES public.movie_attr_type (id) ON DELETE CASCADE
);
CREATE INDEX movie_attr_id_type_idx ON public.movie_attr (id_type);

-- add attr val table
CREATE TABLE public.movie_attr_value
(
    id            serial         NOT NULL,
    id_attr       int            NOT NULL,
    id_movie      int            NOT NULL,
    value_text    varchar        NULL,
    value_int     int            NULL,
    value_double  numeric(10, 2) NULL,
    value_date    date           NULL,
    value_boolean bool           NULL,
    CONSTRAINT movie_attr_value_pk PRIMARY KEY (id),
    CONSTRAINT movie_attr_value_fk_1 FOREIGN KEY (id_attr) REFERENCES public.movie_attr (id) ON DELETE CASCADE,
    CONSTRAINT movie_attr_value_fk FOREIGN KEY (id_movie) REFERENCES public.movie (id) ON DELETE CASCADE
);
CREATE UNIQUE INDEX movie_attr_value_id_movie_id_attr_idx ON public.movie_attr_value (id_attr, id_movie);
CREATE INDEX movie_attr_value_attr_idx ON public.movie_attr_value (id_attr);
CREATE INDEX movie_attr_value_id_movie_idx ON public.movie_attr_value (id_movie);



