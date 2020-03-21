CREATE TABLE halls
(
    id SERIAL PRIMARY KEY,
    name VARCHAR(15),
    num_places integer
);

CREATE TABLE places
(
    id SERIAL PRIMARY KEY,
    hall_id integer REFERENCES halls(id),
    num_row integer,
    num_col integer
);

CREATE TABLE customers
(
    id serial primary key,
    name varchar(127),
    phone varchar(10)
);

CREATE TABLE films
(
    id serial primary key,
    name varchar(127),
    duration integer,
    price float
);

CREATE TABLE sessions
(
    id serial primary key,
    hall_id integer REFERENCES halls(id),
    time_from time,
    time_to time
);

CREATE TABLE offers
(
    id serial primary key,
    session_id integer REFERENCES sessions(id),
    film_id integer REFERENCES films(id)
);

CREATE TABLE tickets
(
    id serial primary key,
    offer_id integer REFERENCES offers(id),
    place_id integer REFERENCES places(id),
    customer_id integer REFERENCES customers(id),
    date date
);

-- самый прибыльный фильм
SELECT SUM(films.price) AS total, films.name AS film_id
FROM tickets
LEFT JOIN offers ON tickets.offer_id = offers.id
LEFT JOIN films on offers.film_id = films.id
GROUP BY films.id
ORDER BY total DESC
FETCH FIRST 1 ROWS ONLY;
