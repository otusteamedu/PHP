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
    duration integer
);

CREATE TABLE sessions
(
    id serial primary key,
    hall_id integer REFERENCES halls(id),
    time_from time,
    time_to time
);

CREATE TABLE bullets
(
    id serial primary key,
    session_id integer REFERENCES sessions(id),
    film_id integer REFERENCES films(id),
    price float
);

CREATE TABLE orders
(
    id serial primary key,
    bullet_id integer REFERENCES bullets(id),
    place_id integer REFERENCES places(id),
    customer_id integer REFERENCES customers(id),
    summ float,
    date date
);

-- самый прибыльный фильм
SELECT t.total, films.name FROM (
    SELECT SUM(orders.summ) AS total, b.film_id AS film_id FROM orders
    LEFT JOIN bullets b on orders.bullet_id = b.id
    LEFT JOIN films f on b.film_id = f.id
    GROUP BY b.film_id
) AS t
LEFT JOIN films ON films.id = t.film_id
ORDER BY total DESC
FETCH FIRST 1 ROWS ONLY;





