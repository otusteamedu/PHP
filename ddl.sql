DROP TABLE IF exists public.customer CASCADE;
CREATE TABLE public.customer (
    id serial NOT NULL,
    name varchar(255),
    CONSTRAINT customer_pk PRIMARY KEY (id)
);

DROP TABLE IF exists public.film CASCADE;
CREATE TABLE public.film (
    id serial NOT NULL,
    name varchar(255),
    CONSTRAINT film_pk PRIMARY KEY (id)
);

DROP TABLE IF exists public.hall CASCADE;
CREATE TABLE public.hall (
	id serial NOT NULL,
	name varchar(255) NOT NULL,
	CONSTRAINT hall_pk PRIMARY KEY (id)
);

DROP TABLE IF exists public.film_session CASCADE;
CREATE TABLE public.film_session (
	id serial NOT NULL,
	film_id int NOT NULL,
	hall_id int NOT NULL,
	session_date date,
	price float,
	CONSTRAINT film_session_pk PRIMARY KEY (id),
	CONSTRAINT film_session_film_fk FOREIGN KEY (film_id) REFERENCES film(id),
	CONSTRAINT film_session_hall_fk FOREIGN KEY (hall_id) REFERENCES hall(id)
);

DROP TABLE IF exists public.place_type;
CREATE TABLE public.place_type (
    id serial NOT null UNIQUE,
    price_percent float DEFAULT 1
);

DROP TABLE IF exists public.place CASCADE;
CREATE TABLE public.place (
    id serial NOT NULL UNIQUE,
    hall_id int NOT NULL,
    row int NOT NULL,
    seat int NOT NULL,
    place_type_id int NOT NULL,
    CONSTRAINT place_hall_fk FOREIGN KEY (hall_id) REFERENCES hall(id),
    CONSTRAINT place_place_type_fk FOREIGN KEY (place_type_id) REFERENCES place_type(id)
);

DROP TABLE IF exists public.ticket CASCADE;
CREATE TABLE public.ticket (
	id serial NOT NULL,
    film_session_id int NOT NULL,
    customer_id int NOT NULL,
    place_id int NOT NULL,
    sale_date date,
    CONSTRAINT ticket_pk PRIMARY KEY (id),
    CONSTRAINT ticket_film_session_fk FOREIGN KEY (film_session_id) REFERENCES film_session(id),
    CONSTRAINT ticket_customer_fk FOREIGN KEY (customer_id) REFERENCES customer(id),
    CONSTRAINT ticket_place_fk FOREIGN KEY (place_id) REFERENCES place(id)
);
