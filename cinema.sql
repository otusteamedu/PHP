DROP TABLE IF EXISTS "user" CASCADE;
CREATE TABLE "user"
(
    id    SERIAL PRIMARY KEY,
    name  varchar NOT NULL,
    phone varchar NULL,
    email varchar NULL
);

DROP TABLE IF EXISTS country CASCADE;
CREATE TABLE country
(
    id   SERIAL PRIMARY KEY,
    name varchar NOT NULL
);

DROP TABLE IF EXISTS hall CASCADE;
CREATE TABLE hall
(
    id   SERIAL PRIMARY KEY,
    name varchar NOT NULL
);

DROP TABLE IF EXISTS film CASCADE;
CREATE TABLE film
(
    id            SERIAL PRIMARY KEY,
    name          varchar NOT NULL,
    description   text    NOT NULL,
    preview_image varchar NOT NULL,
    release_date  date    NOT NULL,
    runtime       int     NOT NULL
);

DROP TABLE IF EXISTS film_country;
CREATE TABLE film_country
(
    film_id    int REFERENCES film (id) ON DELETE CASCADE     NOT NULL,
    country_id int REFERENCES country (id) ON DELETE RESTRICT NOT NULL
);

DROP TABLE IF EXISTS session CASCADE;
CREATE TABLE session
(
    id             SERIAL PRIMARY KEY,
    start_datetime timestamp                                   NOT NULL,
    hall_id        int REFERENCES hall (id) ON DELETE RESTRICT NOT NULL,
    film_id        int REFERENCES film (id) ON DELETE RESTRICT NOT NULL,
    price          numeric(5, 2)                               NOT NULL
);

DROP TABLE IF EXISTS ticket;
CREATE TABLE ticket
(
    id         SERIAL PRIMARY KEY,
    session_id int REFERENCES session (id) ON DELETE RESTRICT NOT NULL,
    created    timestamp                                      NOT NULL,
    price      numeric(5, 2)                                  NOT NULL,
    user_id    int REFERENCES "user" (id) ON DELETE RESTRICT  NOT NULL
);


-- Данные для демонстрации и проверки скрипта подсчета самого прибыльного фильма
INSERT INTO "user" (id, name, phone, email)
VALUES (1, 'Иван Петров', NULL, NULL),
       (2, 'Аркадий Николаев', '+7-999-999-99-99', 'an@gmail.com'),
       (3, 'Семен', NULL, NULL),
       (4, 'Людмила', NULL, NULL);

INSERT INTO hall (id, name)
VALUES (1, 'Первый зал'),
       (2, 'Второй зал');

INSERT INTO film (id, name, description, preview_image, release_date, runtime)
VALUES (1, 'Бойцовский клуб', 'Бойцовский клуб описание...', 'https://...', '1999-01-01', 139),
       (2, 'Идентификация Борна', 'Идентификация Борна описание...', 'https://...', '2017-06-24', 113);

INSERT INTO session (id, start_datetime, hall_id, film_id, price)
VALUES (1, '2020-03-28 11:00:00.000000', 1, 1, 200.00),
       (2, '2020-03-28 14:30:02.000000', 2, 1, 200.00),
       (3, '2020-03-28 17:45:02.000000', 1, 2, 300.00),
       (4, '2020-03-28 20:10:02.000000', 2, 2, 300.00);

INSERT INTO ticket (session_id, created, price, user_id)
VALUES (1, '2020-03-28 11:00:00.000000', 200.00, 1),
       (1, '2020-03-28 11:00:00.000000', 200.00, 2),
       (1, '2020-03-28 11:00:00.000000', 200.00, 3),
       (2, '2020-03-28 11:00:00.000000', 200.00, 4),
       (3, '2020-03-28 11:00:00.000000', 300.00, 1),
       (4, '2020-03-28 11:00:00.000000', 300.00, 2);

INSERT INTO country (id, name)
VALUES (1, 'США'),
       (2, 'Германия'),
       (3, 'Россия');

INSERT INTO film_country (film_id, country_id)
VALUES (1, 1),
       (2, 1),
       (2, 2);