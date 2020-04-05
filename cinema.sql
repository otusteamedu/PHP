DROP TABLE IF EXISTS "user" CASCADE;
CREATE TABLE "user"
(
    id    SERIAL PRIMARY KEY,
    name  varchar NOT NULL,
    phone varchar NULL,
    email varchar NULL
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
    runtime       int     NOT NULL
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

DROP TABLE IF EXISTS film_attribute_type CASCADE;
CREATE TABLE film_attribute_type
(
    id   serial PRIMARY KEY,
    name varchar NOT NULL
);

DROP TABLE IF EXISTS film_attribute CASCADE;
CREATE TABLE film_attribute
(
    id                     serial PRIMARY KEY,
    name                   varchar,
    film_attribute_type_id int REFERENCES film_attribute_type (id) ON DELETE RESTRICT NOT NULL
);

DROP TABLE IF EXISTS film_attribute_value;
CREATE TABLE film_attribute_value
(
    id                serial PRIMARY KEY,
    film_id           int REFERENCES film (id) ON DELETE CASCADE            NOT NULL,
    film_attribute_id int REFERENCES film_attribute (id) ON DELETE RESTRICT NOT NULL,
    value_date        date,
    value_text        text,
    value_numeric     numeric(11, 2)
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

INSERT INTO film (id, name, description, preview_image, runtime)
VALUES (1, 'Бойцовский клуб', 'Бойцовский клуб описание...', 'https://...', 139),
       (2, 'Идентификация Борна', 'Идентификация Борна описание...', 'https://...', 113),
       (3, 'Новый фильм', 'Новый фильм описание...', 'https://...', 113),
       (4, 'Новый фильм 2', 'Новый фильм 2 описание...', 'https://...', 113);

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

INSERT INTO film_attribute_type (id, name)
VALUES (1, 'text'),
       (2, 'date'),
       (3, 'numeric');

INSERT INTO film_attribute (id, name, film_attribute_type_id)
VALUES (1, 'Рецензия', 1),
       (2, 'Дата премьеры в России', 2),
       (3, 'Страна производства', 1),
       (4, 'Бюджет', 3),
       (5, 'Сборы в мире', 3),
       (6, 'Сборы в России', 3),
       (7, 'Режиссер', 1),
       (8, 'Старт продажи билетов', 2),
       (9, 'Старт рекламы на ТВ', 2),
       (10, 'Печать буклетов', 2);

INSERT INTO film_attribute_value (film_id, film_attribute_id, value_date, value_text, value_numeric)
VALUES (1, 1, NULL, 'Хороший фильм', NULL),
       (1, 1, NULL, 'Плохой фильм', NULL),
       (1, 2, '2000-01-13', NULL, NULL),
       (1, 3, NULL, 'США', NULL),
       (1, 3, NULL, 'Германия', NULL),
       (1, 4, NULL, NULL, 63000000.00),
       (1, 5, NULL, NULL, 100853753.00),
       (1, 6, NULL, NULL, 334590),
       (1, 7, NULL, 'Дэвид Финчер', NULL),
       (1, 8, '2000-01-13', NULL, NULL),
       (1, 9, '1999-12-13', NULL, NULL),
       (3, 8, now() + INTERVAL '20 days', NULL, NULL),
       (3, 9, now(), NULL, NULL),
       (3, 10, now(), NULL, NULL),
       (4, 8, now() + INTERVAL '20 days', NULL, NULL),
       (4, 10, now(), NULL, NULL);

-- View для просмотра всех существующих параметров
DROP VIEW IF EXISTS films_with_attributes_view;
CREATE VIEW films_with_attributes_view AS
SELECT film.name                AS film_name,
       film_attribute_type.name AS attribute_type_name,
       film_attribute.name      AS attribute_name,
       CASE
           WHEN film_attribute_type.name = 'text' THEN value_text::text
           WHEN film_attribute_type.name = 'date' THEN value_date::text
           WHEN film_attribute_type.name = 'numeric' THEN value_numeric::text
           END                  AS value
FROM film
         LEFT JOIN film_attribute_value ON film.id = film_attribute_value.film_id
         LEFT JOIN film_attribute ON film_attribute_value.film_attribute_id = film_attribute.id
         LEFT JOIN film_attribute_type ON film_attribute.film_attribute_type_id = film_attribute_type.id
WHERE film_attribute.name IS NOT NULL;

-- View для задач
DROP VIEW IF EXISTS tasks_view;
CREATE VIEW tasks_view AS
SELECT film.name   AS film_name,
       array_to_string(
               array_agg(
                       CASE
                           WHEN film_attribute_value.value_date = now()::date
                               THEN film_attribute.name
                           END
                   ),
               ', '
           )::text AS tasks_today,
       array_to_string(
               array_agg(
                       CASE
                           WHEN film_attribute_value.value_date = now()::date + INTERVAL '20 days'
                               THEN film_attribute.name
                           END
                   ),
               ', '
           )::text AS tasks_in_20_days
FROM film
         LEFT JOIN film_attribute_value ON film.id = film_attribute_value.film_id
         LEFT JOIN film_attribute ON film_attribute.id = film_attribute_value.film_attribute_id
WHERE film_attribute.name IN (
                              'Старт продажи билетов',
                              'Старт рекламы на ТВ',
                              'Печать буклетов'
    )
  AND film_attribute_value.value_date IN (
                                          now()::date,
                                          (now() + INTERVAL '20 days')::date
    )
GROUP BY film_name




