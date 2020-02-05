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

DROP TABLE IF exists public.ticket CASCADE;
CREATE TABLE public.ticket (
	id serial NOT NULL,
    film_session_id int NOT NULL,
    customer_id int NOT NULL,
    CONSTRAINT ticket_pk PRIMARY KEY (id),
    CONSTRAINT ticket_film_session_fk FOREIGN KEY (film_session_id) REFERENCES film_session(id),
    CONSTRAINT ticket_customer_fk FOREIGN KEY (customer_id) REFERENCES customer(id)
);
