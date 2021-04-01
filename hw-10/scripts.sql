CREATE DATABASE cinema;

CREATE SCHEMA cinema_storage;

CREATE TABLE cinema
(
    name        VARCHAR(255),
    cinema_hall VARCHAR(255)
);

CREATE TABLE halls
(
    cinema_id     SERIAL PRIMARY KEY,
    name          VARCHAR(255),
    schedule      JSON,
    movie_id      INTEGER
);

CREATE TABLE hall_movie
(
    id        SERIAL PRIMARY KEY,
    cinema_id INTEGER,
    movie_id  INTEGER,
    date_time TIMESTAMP
);

CREATE TABLE movies
(
    id          SERIAL PRIMARY KEY,
    name        VARCHAR(500),
    description TEXT,
    time        NUMERIC(4),
    box_office  NUMERIC(12, 2) NOT NULL
);


CREATE TABLE seats
(
    hall_id INT REFERENCES halls,
    seat_row VARCHAR(4) NOT NULL,
    seat_no VARCHAR(4) NOT NULL,
    PRIMARY KEY (hall_id, seat_row, seat_no)
);

-- SELECT round(random() * 10)
-- FROM generate_series(1,5);

CREATE TABLE session
(
    id            BIGSERIAL PRIMARY KEY,
    movie_id      INTEGER REFERENCES movies,
    hall_movie_id INTEGER REFERENCES hall_movie,
    begin_movie   TIMESTAMP,
    price         NUMERIC(6, 2) NOT NULL
);

CREATE TABLE orders
(
    id            BIGSERIAL PRIMARY KEY,
    order_time    TIMESTAMP,
    total_price   NUMERIC(6)
);

CREATE TABLE ticket
(
    id            BIGSERIAL PRIMARY KEY,
    movie_id      INTEGER,
    hall_id       INTEGER,
    price         NUMERIC(6, 2) NOT NULL,
    seat_no       NUMERIC(3),
    seat_row      NUMERIC(3),
    session_id    BIGINT REFERENCES session,
    order_id      BIGINT REFERENCES orders
);

-- TRUNCATE TABLE ticket;

----------------------------------------------------
--------------------- Demo Data --------------------
----------------------------------------------------

INSERT INTO cinema (name)
VALUES ('Кинотеатр');

INSERT INTO halls(name, schedule, movie_id)
SELECT k + 1, to_json(k ^ 1), k % 2::numeric
FROM generate_series(0, 100) AS k;

INSERT INTO hall_movie(cinema_id, movie_id, date_time)
SELECT k + 1, k ^ 1, now()
FROM generate_series(0, 100) AS k;

INSERT INTO movies (name,
                    description,
                    time,
                    box_office)
SELECT k + 1,
       k ^ 1,
       k % 2::numeric,
       k % 2::numeric
FROM generate_series(0, 10000) AS k;

INSERT INTO seats(hall_id, seat_row, seat_no)
SELECT k + 1, k ^ 1, k % 2
FROM generate_series(0, 100) AS k;

INSERT INTO session(movie_id,
                    hall_movie_id,
                    begin_movie,
                    final_movie,
                    price)
SELECT trunc(random() * 10 + 1),
       k % 2 + 1,
       now(),
       now() + '2 hours',
       generate_series(100, 500)
FROM generate_series(1, 10000) AS k;

INSERT INTO orders(order_time, total_price)
SELECT now(), floor(random() * (1000 - 100 + 1)) + 100
FROM generate_series(1, 10001) as k;

INSERT INTO ticket(movie_id,
                   hall_id,
                   price,
                   seat_no,
                   seat_row,
                   session_id,
                   order_id)
SELECT floor(random() * (1000 - 100 + 1)) + 100,
       floor(random() * (100 - 10 + 1)) + 1,
       floor(random() * (1000 - 100 + 1)) + 100,
       k%1,
       floor(random() * (100 - 10 + 1)) + 1,
       k + 1,
       k + 1
FROM generate_series(1, 10000) as k;

----------------------------------------------------
--------------------- 6 запросов -------------------
----------------------------------------------------

-- Находим сумму всех билетов определённого фильма
SELECT sum(movie_id)
FROM ticket
WHERE movie_id = 647;

-- Средняя стоимость билета
SELECT movie_id,
       round(avg(price), 2)
FROM ticket
GROUP BY movie_id
ORDER BY movie_id ;

-- Средняя стоимость билета определённого фильма по сравнению с текущей стоимостью билета
SELECT movie_id,
       price,
       avg(price) OVER (ORDER BY movie_id)
FROM ticket;

-- Находим название фильма и сумму, которую собрал этот фильм
SELECT movie_id,
       (SELECT name FROM movies m
        WHERE m.id = movie_id),
       sum(price) sum
FROM session
GROUP BY movie_id
ORDER BY sum DESC;

--Вычитаем аренду в размере 50% и смотрим прибыль для каждого зала
CREATE VIEW hall_profit AS
SELECT hall_id,
       sum(price)
FROM ticket
GROUP BY hall_id
ORDER BY hall_id;

SELECT h.hall_id,
       h.sum,
       abs(h.sum * 0.5) profit
FROM hall_profit h
ORDER BY profit DESC;

-- Отображаем зал, фильм, время начала и конца фильма. Задействуем 3 таблицы.
SELECT hall_movie_id,
       s.movie_id,
       (SELECT name
        FROM movies m
        WHERE m.id = s.movie_id),
       s.begin_movie,
       s.final_movie
FROM hall_movie
         INNER JOIN session s on hall_movie.id = s.hall_movie_id