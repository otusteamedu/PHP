DROP TABLE public.halls;

CREATE TABLE public.halls (
    id serial NOT NULL,
    "name" varchar(20) NOT NULL,
    description varchar(255) NULL,
    capacity int2 NOT NULL,
    created_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT halls_pkey PRIMARY KEY (id)
);

DROP TABLE public.films;

CREATE TABLE public.films (
    id serial NOT NULL,
    "name" varchar(100) NOT NULL,
    description varchar(255) NULL,
    age_restrict int2 NOT NULL,
    created_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    duration time NOT NULL,
    CONSTRAINT films_pkey PRIMARY KEY (id)
);

DROP TABLE public.seances;

CREATE TABLE public.seances (
    id serial NOT NULL,
    hall_id int4 NOT NULL,
    film_id int4 NOT NULL,
    show_at timestamp NOT NULL,
    price int4 NOT NULL,
    created_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT seances_pkey PRIMARY KEY (id),
    CONSTRAINT seances_film_id_fkey FOREIGN KEY (film_id) REFERENCES films(id) ON UPDATE CASCADE ON DELETE CASCADE,
    CONSTRAINT seances_hall_id_fkey FOREIGN KEY (hall_id) REFERENCES halls(id) ON UPDATE CASCADE ON DELETE CASCADE
);

DROP TABLE public.tickets;

CREATE TABLE public.tickets (
    id serial NOT NULL,
    seance_id int4 NOT NULL,
    "row" int2 NOT NULL,
    place int2 NOT NULL,
    created_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    price int4 NOT NULL DEFAULT 0,
    CONSTRAINT tickets_pkey PRIMARY KEY (id),
    CONSTRAINT tickets_seance_id_row_place_key UNIQUE (seance_id, "row", place),
    CONSTRAINT tickets_seance_id_fkey FOREIGN KEY (seance_id) REFERENCES seances(id) ON UPDATE CASCADE ON DELETE CASCADE
);

DROP TABLE public.film_attributes;

CREATE TABLE public.film_attributes (
    id serial NOT NULL,
    "name" varchar(100) NOT NULL,
    description varchar(255) NULL,
    created_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    film_attribute_type_id int4 NOT NULL,
    CONSTRAINT film_attributes_pkey PRIMARY KEY (id),
    CONSTRAINT film_attributes_fk FOREIGN KEY (film_attribute_type_id) REFERENCES film_attribute_types(id)
);

DROP TABLE public.film_attribute_types;

CREATE TABLE public.film_attribute_types (
    id serial NOT NULL,
    "name" varchar(100) NOT NULL,
    description varchar(255) NULL,
    created_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT film_attribute_types_pkey PRIMARY KEY (id)
);
CREATE UNIQUE INDEX film_attribute_types_name_idx ON public.film_attribute_types USING btree (name);


DROP TABLE public.film_attribute_values;

CREATE TABLE public.film_attribute_values (
    id serial NOT NULL,
    film_attribute_id int4 NULL,
    film_id int4 NULL,
    text_value text NULL,
    boolean_value bool NULL,
    date_value timestamp NULL,
    created_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    integer_value int4 NULL,
    float_value float8 NULL,
    CONSTRAINT film_attribute_values_pkey PRIMARY KEY (id),
    CONSTRAINT film_attribute_values_film_attribute_id_fkey FOREIGN KEY (film_attribute_id) REFERENCES film_attributes(id) ON UPDATE CASCADE ON DELETE CASCADE,
    CONSTRAINT film_attribute_values_film_id_fkey FOREIGN KEY (film_id) REFERENCES films(id) ON UPDATE CASCADE ON DELETE CASCADE
);
CREATE UNIQUE INDEX film_attribute_values_film_attribute_id_idx ON public.film_attribute_values USING btree (film_attribute_id, film_id);