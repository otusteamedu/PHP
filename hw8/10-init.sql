CREATE TABLE public.halls (
    hall_id SERIAL,
    hall    VARCHAR(256) NOT NULL,
    CONSTRAINT halls_pk PRIMARY KEY (hall_id)
);

CREATE TABLE public.movies (
    movie_id SERIAL,
    movie    VARCHAR(256) NOT NULL,
    CONSTRAINT movies_pk PRIMARY KEY (movie_id)
);

CREATE TABLE public.sessions (
    session_id SERIAL,
    hall_id    INTEGER NOT NULL,
    movie_id   INTEGER NOT NULL,
    price      MONEY NOT NULL,
    CONSTRAINT sessions_pk PRIMARY KEY (session_id),
    CONSTRAINT sessions_fk_halls FOREIGN KEY (hall_id) REFERENCES public.halls(hall_id),
    CONSTRAINT sessions_fk_movies FOREIGN KEY (movie_id) REFERENCES public.movies(movie_id)
);

CREATE TABLE public.clients (
    client_id SERIAL,
    fio       VARCHAR(256) NOT NULL,
    CONSTRAINT clients_pk PRIMARY KEY (client_id)
);

CREATE TABLE public.orders (
    order_id   SERIAL,
    client_id  INTEGER NOT NULL,
    session_id INTEGER NOT NULL,
    CONSTRAINT orders_pk PRIMARY KEY (order_id),
    CONSTRAINT orders_fk_clients FOREIGN KEY (client_id) REFERENCES public.clients(client_id),
    CONSTRAINT orders_fk_sessions FOREIGN KEY (session_id) REFERENCES public.sessions(session_id)
);