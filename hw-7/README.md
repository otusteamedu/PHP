```SQL
CREATE DATABASE cinema;

CREATE SCHEMA cinema_storage;


CREATE TABLE cinema (
    name VARCHAR(255),
    cinema_hall VARCHAR(255)
);

CREATE TABLE halls (
    cinema_id SERIAL PRIMARY KEY ,
    name VARCHAR(255),
    schedule JSON,
    current_movie VARCHAR(500)
);

CREATE TABLE hall_movie (
    id SERIAL PRIMARY KEY ,
    cinema_id INTEGER,
    movie_id INTEGER,
    date_time TIMESTAMP
);

CREATE TABLE movies (
    id SERIAL PRIMARY KEY ,
    name VARCHAR(500),
    description TEXT,
    time TIME,
    box_office FLOAT
);

CREATE TABLE seats
(
    hall_id INT REFERENCES halls,
    seat_no VARCHAR(4) NOT NULL,
    PRIMARY KEY (hall_id, seat_no)
);

CREATE TABLE session
(
    id BIGSERIAL PRIMARY KEY ,
    movie_id INTEGER REFERENCES movies,
    hall_movie_id INTEGER REFERENCES hall_movie,
    begin_movie TIMESTAMP,
    final_movie TIMESTAMP
);

CREATE TABLE ticket
(
    id            BIGSERIAL PRIMARY KEY,
    customer_name VARCHAR(255),
    movie_id      INTEGER,
    hall_id       INTEGER,
    price         NUMERIC(6, 2) NOT NULL ,
    seat_no       VARCHAR (4),
    session_id    BIGINT REFERENCES session
);


INSERT INTO ticket (customer_name, movie_id, hall_id, price, seat_no)
VALUES ('Ivan', 1, 2, 200, '1|8'),
       ('Ivan', 2, 2, 300, '2|12'),
       ('Ivan', 3, 2, 400, '3|8'),
       ('Ivan', 2, 2, 500, '4|4'),
       ('Ivan', 4, 2, 500, '5|22'),
       ('Ivan', 2, 2, 300, '1|10');



SELECT t.movie_id,
       sum(t.price) sum
FROM ticket t
GROUP BY t.movie_id
ORDER BY sum DESC
LIMIT 1;```