DROP TABLE IF EXISTS orders;
DROP TABLE IF EXISTS order_statuses;
DROP TABLE IF EXISTS events;
DROP TABLE IF EXISTS places;
DROP TABLE IF EXISTS halls;
DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS films;

CREATE TABLE IF NOT EXISTS films (
                                     id SERIAL PRIMARY KEY,
                                     title varchar(50) UNIQUE NOT NULL
);

CREATE TABLE IF NOT EXISTS users (
                                     id SERIAL PRIMARY KEY,
                                     username varchar(50) UNIQUE NOT NULL,
                                     password varchar(50) NOT NULL,
                                     email varchar(255) UNIQUE NOT NULL,
                                     created_on timestamp NOT NULL,
                                     last_login timestamp
);

CREATE TABLE IF NOT EXISTS halls (
                                     id SERIAL PRIMARY KEY,
                                     title varchar(50) UNIQUE NOT NULL
);

CREATE TABLE IF NOT EXISTS places (
                                      id SERIAL PRIMARY KEY,
                                      number smallint NOT NULL,
                                      hall_id smallint NOT NULL REFERENCES halls,
                                      UNIQUE (number, hall_id)
);

CREATE TABLE IF NOT EXISTS events (
                                      id SERIAL PRIMARY KEY,
                                      hall_id smallint NOT NULL REFERENCES halls,
                                      film_id integer NOT NULL REFERENCES films,
                                      datetime timestamp NOT NULL,
                                      price numeric(6, 2) NULL CHECK (price >= 0),
                                      UNIQUE (hall_id, datetime)
);

CREATE TABLE IF NOT EXISTS order_statuses (
                                              id SERIAL PRIMARY KEY,
                                              title varchar(50) UNIQUE NOT NULL
);

CREATE TABLE IF NOT EXISTS orders (
                                      id SERIAL PRIMARY KEY,
                                      event_id integer NOT NULL REFERENCES events,
                                      place_id integer NULL REFERENCES places,
                                      order_status_id integer NOT NULL REFERENCES order_statuses,
                                      user_id integer NULL REFERENCES users,
                                      datetime timestamp NOT NULL,
                                      UNIQUE (event_id, place_id)
);

INSERT INTO films (id, title) VALUES (1, 'Rocky');
INSERT INTO films (id, title) VALUES (2, 'Rocky 2');
INSERT INTO films (id, title) VALUES (3, 'Rocky 3');
INSERT INTO films (id, title) VALUES (4, 'Terminator');
INSERT INTO films (id, title) VALUES (5, 'Terminator 2');

INSERT INTO users (id, username, password,email, created_on, last_login)
VALUES (1, 'user1', 'password1', 'user1@gmail.com', '2020-01-04', '2020-12-01');
INSERT INTO users (id, username, password,email, created_on, last_login)
VALUES (2, 'user2', 'password2', 'user2@gmail.com', '2020-02-04', '2020-12-02');
INSERT INTO users (id, username, password,email, created_on, last_login)
VALUES (3, 'user3', 'password3', 'user3@gmail.com', '2020-03-04', '2020-12-03');

INSERT INTO halls (id, title) VALUES (1, 'Madrid-hall');
INSERT INTO halls (id, title) VALUES (2, 'Moscow-hall');
INSERT INTO halls (id, title) VALUES (3, 'Minsk-hall');

INSERT INTO places (id, number, hall_id) VALUES (1, 1, 1);
INSERT INTO places (id, number, hall_id) VALUES (2, 2, 1);
INSERT INTO places (id, number, hall_id) VALUES (3, 3, 1);
INSERT INTO places (id, number, hall_id) VALUES (4, 4, 1);
INSERT INTO places (id, number, hall_id) VALUES (5, 5, 1);
INSERT INTO places (id, number, hall_id) VALUES (6, 1, 2);
INSERT INTO places (id, number, hall_id) VALUES (7, 2, 2);
INSERT INTO places (id, number, hall_id) VALUES (8, 3, 2);
INSERT INTO places (id, number, hall_id) VALUES (9, 1, 3);
INSERT INTO places (id, number, hall_id) VALUES (10, 2, 3);
INSERT INTO places (id, number, hall_id) VALUES (11, 3, 3);

INSERT INTO events (id, hall_id, film_id, datetime, price) VALUES (1, 1, 1, '2021-01-13 17:00', 200.10);
INSERT INTO events (id, hall_id, film_id, datetime, price) VALUES (2, 1, 2, '2021-01-13 19:00', 300.50);
INSERT INTO events (id, hall_id, film_id, datetime, price) VALUES (3, 1, 3, '2021-01-14 17:00', 200.50);
INSERT INTO events (id, hall_id, film_id, datetime, price) VALUES (4, 1, 4, '2021-01-14 19:00', 300.00);
INSERT INTO events (id, hall_id, film_id, datetime, price) VALUES (5, 2, 5, '2021-01-13 17:00', 300.00);
INSERT INTO events (id, hall_id, film_id, datetime, price) VALUES (6, 2, 1, '2021-01-13 19:00', 250.50);
INSERT INTO events (id, hall_id, film_id, datetime, price) VALUES (7, 2, 2, '2021-01-14 19:00', 250.00);
INSERT INTO events (id, hall_id, film_id, datetime, price) VALUES (8, 3, 3, '2021-01-14 19:00', 250.20);

INSERT INTO order_statuses (id, title) VALUES (1, 'booked');
INSERT INTO order_statuses (id, title) VALUES (2, 'paid');
INSERT INTO order_statuses (id, title) VALUES (3, 'canceled');

INSERT INTO orders (id, event_id, place_id, order_status_id, user_id, datetime)
VALUES (1, 1, 1, 2, NULL, '2020-11-01 13:00');
INSERT INTO orders (id, event_id, place_id, order_status_id, user_id, datetime)
VALUES (2, 1, 2, 2, 1, '2020-11-01 13:00');
INSERT INTO orders (id, event_id, place_id, order_status_id, user_id, datetime)
VALUES (3, 2, 1, 1, 2, '2020-11-01 13:00');
INSERT INTO orders (id, event_id, place_id, order_status_id, user_id, datetime)
VALUES (4, 2, 2, 2, 2, '2020-11-01 13:00');