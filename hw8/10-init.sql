CREATE TABLE public.halls (
    hall_id SERIAL,
    hall    VARCHAR(256) NOT NULL,
    CONSTRAINT halls_pk PRIMARY KEY (hall_id)
);

CREATE TABLE public.seats (
    seat_yd    SMALLSERIAL,
    seat       VARCHAR(256) NOT NULL,
    CONSTRAINT seats_pk PRIMARY KEY (seat_yd)
);

CREATE TABLE public.halls_seats (
    hall_id    INTEGER NOT NULL,
    seat_id    INTEGER NOT NULL,
    seat_yd    SMALLINT NOT NULL,
    CONSTRAINT halls_seats_pk PRIMARY KEY (hall_id, seat_id),
    CONSTRAINT halls_seats_fk_seats FOREIGN KEY (seat_yd) REFERENCES public.seats(seat_yd),
    CONSTRAINT halls_seats_fk_halls FOREIGN KEY (hall_id) REFERENCES public.halls(hall_id)
);

CREATE TABLE public.movies (
    movie_id   SERIAL,
    movie      VARCHAR(256) NOT NULL,
    CONSTRAINT movies_pk PRIMARY KEY (movie_id)
);

CREATE TABLE public.sessions (
    session_id SERIAL,
    hall_id    INTEGER NOT NULL,
    movie_id   INTEGER NOT NULL,
    start_time TIMESTAMP NOT NULL,
    CONSTRAINT sessions_pk PRIMARY KEY (session_id),
    CONSTRAINT sessions_fk_halls FOREIGN KEY (hall_id) REFERENCES public.halls(hall_id),
    CONSTRAINT sessions_fk_movies FOREIGN KEY (movie_id) REFERENCES public.movies(movie_id)
);

CREATE TABLE public.sessions_prices (
    session_id INTEGER NOT NULL,
    seat_yd    SMALLINT NOT NULL,
    price      MONEY,
    CONSTRAINT sessions_prices_pk PRIMARY KEY (session_id, seat_yd),
    CONSTRAINT sessions_prices_fk_sessions FOREIGN KEY (session_id) REFERENCES public.sessions(session_id),
    CONSTRAINT sessions_prices_fk_seats FOREIGN KEY (seat_yd) REFERENCES public.seats(seat_yd)
);

CREATE TABLE public.clients (
    client_id SERIAL,
    fio       VARCHAR(256) NOT NULL,
    CONSTRAINT clients_pk PRIMARY KEY (client_id)
);

CREATE TABLE public.orders (
    order_id   SERIAL,
    client_id  INTEGER NOT NULL,
    CONSTRAINT orders_pk PRIMARY KEY (order_id),
    CONSTRAINT orders_fk_clients FOREIGN KEY (client_id) REFERENCES public.clients(client_id)
);

CREATE TABLE public.orders_tickets (
    order_id   INTEGER NOT NULL,
    ticket_id  INTEGER NOT NULL,
    session_id INTEGER NOT NULL,
    seat_id    INTEGER NOT NULL,
    CONSTRAINT orders_tickets_pk PRIMARY KEY (order_id, ticket_id),
    CONSTRAINT orders_tickets_fk_orders FOREIGN KEY (order_id) REFERENCES public.orders(order_id),
    CONSTRAINT orders_tickets_fk_sessions FOREIGN KEY (session_id) REFERENCES public.sessions(session_id),
    CONSTRAINT orders_tickets_uk_session_id_seat_id UNIQUE (session_id, seat_id)
);

CREATE VIEW public.unoccupied_seats AS
SELECT ss.session_id
     , ss.movie_id
     , hs.hall_id
     , hs.seat_id
     , sp.price
  FROM public.sessions AS ss
 INNER JOIN public.halls_seats AS hs
    ON hs.hall_id = ss.hall_id
 INNER JOIN public.sessions_prices AS sp
    ON sp.session_id = ss.session_id
   AND sp.seat_yd = hs.seat_yd
  LEFT JOIN public.orders_tickets AS ot
    ON ot.session_id = ss.session_id
   AND ot.seat_id = hs.seat_id
 WHERE ot.order_id IS NULL;