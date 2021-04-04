DROP TABLE IF EXISTS
    public.movies,
    public.movie_attrs_values,
    public.movie_attrs,
    public.movie_attrs_types,
    public.seances,
    public.halls,
    public.seats_type,
    public.seats,
    public.seats_price,
    public.tickets,
    public.customers CASCADE;

CREATE TABLE public.movies
(
    id     serial  NOT NULL,
    "name" varchar NOT NULL,
    CONSTRAINT movies_pkey PRIMARY KEY (id)
);

CREATE TABLE public.movie_attrs_types
(
    id     serial  NOT NULL,
    "name" varchar NOT NULL,
    CONSTRAINT movie_attrs_types_name_key UNIQUE (name),
    CONSTRAINT movie_attrs_types_pkey PRIMARY KEY (id)
);

CREATE TABLE public.movie_attrs
(
    id      serial  NOT NULL,
    name    varchar NOT NULL,
    type_id int4    NOT NULL,
    CONSTRAINT movie_attrs_name_key UNIQUE (name),
    CONSTRAINT movie_attrs_pkey PRIMARY KEY (id),
    CONSTRAINT movie_attrs_type_id_fkey FOREIGN KEY (type_id) REFERENCES movie_attrs_types (id) ON DELETE CASCADE
);


CREATE TABLE public.movie_attrs_values
(
    id            serial NOT NULL,
    movie_id      int4   NOT NULL,
    attr_id       int4   NOT NULL,
    text_value    text NULL,
    int_value     int4 NULL,
    date_value    date NULL,
    time_value    time NULL,
    float_value float4 NULL,
    CONSTRAINT movie_attrs_values_pkey PRIMARY KEY (id),
    CONSTRAINT movie_attrs_values_attr_id_fkey FOREIGN KEY (attr_id) REFERENCES movie_attrs (id) ON DELETE CASCADE,
    CONSTRAINT movie_attrs_values_movie_id_fkey FOREIGN KEY (movie_id) REFERENCES movies (id) ON DELETE CASCADE
);


CREATE TABLE public.halls
(
    id     serial         NOT NULL,
    "name" varchar(255) NOT NULL,
    CONSTRAINT halls_pkey PRIMARY KEY (id)
);
CREATE TABLE public.seances
(
    id       serial      NOT NULL,
    start_at timestamp NOT NULL,
    end_at   timestamp NOT NULL,
    movie_id int4      NOT NULL,
    hall_id  int4      NOT NULL,
    CONSTRAINT seances_pkey PRIMARY KEY (id),
    CONSTRAINT seances_hall_id_fkey FOREIGN KEY (hall_id) REFERENCES halls (id),
    CONSTRAINT seances_movie_id_fkey FOREIGN KEY (movie_id) REFERENCES movies (id)
);

CREATE TABLE public.seats_type
(
    id   serial         NOT NULL,
    code varchar(255) NOT NULL,
    CONSTRAINT seats_type_pkey PRIMARY KEY (id)
);


CREATE TABLE public.seats
(
    id       serial NOT NULL,
    "row"    int4 NOT NULL,
    "number" int4 NOT NULL,
    hall_id  int4 NOT NULL,
    type_id  int4 NOT NULL,
    CONSTRAINT seats_pkey PRIMARY KEY (id),
    CONSTRAINT seats_hall_id_fkey FOREIGN KEY (hall_id) REFERENCES halls (id),
    CONSTRAINT seats_type_id_fkey FOREIGN KEY (type_id) REFERENCES seats_type (id)
);

CREATE TABLE public.seats_price
(
    id           serial NOT NULL,
    seance_id    int4 NOT NULL,
    seat_type_id int4 NOT NULL,
    price        int4 NOT NULL,
    CONSTRAINT seats_price_pkey PRIMARY KEY (id),
    CONSTRAINT seats_price_seance_id_fkey FOREIGN KEY (seance_id) REFERENCES seances (id),
    CONSTRAINT seats_price_seat_type_id_fkey FOREIGN KEY (seat_type_id) REFERENCES seats_type (id)
);

CREATE TABLE public.customers
(
    id     serial         NOT NULL,
    "name" varchar(255) NOT NULL,
    CONSTRAINT customers_pkey PRIMARY KEY (id)
);

CREATE TABLE public.tickets
(
    id          serial NOT NULL,
    seat_id     int4 NULL,
    seance_id   int4 NOT NULL,
    customer_id int4 NOT NULL,
    CONSTRAINT tickets_pkey PRIMARY KEY (id),
    CONSTRAINT tickets_customer_id_fkey FOREIGN KEY (customer_id) REFERENCES customers (id),
    CONSTRAINT tickets_seance_id_fkey FOREIGN KEY (seance_id) REFERENCES seances (id),
    CONSTRAINT tickets_seat_id_fkey FOREIGN KEY (seat_id) REFERENCES seats (id)
);



CREATE
    UNIQUE INDEX movie_attrs_values_attr_id_movie_idx ON public.movie_attrs_values (attr_id, movie_id);
CREATE
    INDEX movie_attrs_type_idx ON public.movie_attrs (type_id);