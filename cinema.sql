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
    price          numeric(6, 2)                               NOT NULL
);

DROP TABLE IF EXISTS ticket;
CREATE TABLE ticket
(
    id         SERIAL PRIMARY KEY,
    session_id int REFERENCES session (id) ON DELETE RESTRICT NOT NULL,
    created    timestamp                                      NOT NULL,
    price      numeric(6, 2)                                  NOT NULL,
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

INSERT INTO "user" (name, phone, email)
SELECT (
           SELECT concat_ws(' ', first_name, middle_name, second_name) AS name
           FROM (
                    SELECT first_name[
                                   trunc(random() * array_length(first_name, 1) + 1) + (generator * 0)
                               ] first_name
                    FROM (
                             SELECT '{Филипп,Вячеслав,Иван,Тимур,Алексей,Денис,Эдуард}'::text[] first_name
                         ) a
                ) a,
                (
                    SELECT middle_name[
                                   trunc(random() * array_length(middle_name, 1) + 1) + (generator * 0)
                               ] middle_name
                    FROM (
                             SELECT '{Ростиславович,Святославович,Леонидович,Никитич,Васильевич,Леонидович,Львович}'::text[] middle_name
                         ) a
                ) b,
                (
                    SELECT second_name[
                                   trunc(random() * array_length(second_name, 1) + 1) + (generator * 0)
                               ] second_name
                    FROM (
                             SELECT '{Григорьев,Федосеев,Королёв,Одинцов,Буров,Мишин,Шашков}'::text[] second_name
                         ) a
                ) c
       ),
       (
           SELECT format(
                          '+7 (%s%s%s) %s%s%s-%s%s%s%s',
                          a[1], a[2], a[3], a[4], a[5], a[6], a[7], a[8], a[9], a[10]) phone
           FROM (
                    SELECT ARRAY(
                                   SELECT trunc(random() * 10 + (generator * 0))::int
                                   FROM generate_series(1, 10)
                               ) a
                ) a
       ),
       (
           SELECT concat(
                          array_to_string(
                                  array(
                                          SELECT substr('abcdefghijklmnopqrstuvwxyz0123456789_',
                                                        trunc(random() * 62 + (generator * 0))::integer + 1,
                                                        1)
                                          FROM generate_series(1, 12)
                                      ),
                                  ''
                              ),
                          '@gmail.com'
                      ) email
       )
FROM generate_series(1, 10000) generator;

INSERT INTO hall (id, name)
VALUES (1, 'Первый зал'),
       (2, 'Второй зал');

INSERT INTO film (id, name, description, preview_image, runtime)
VALUES (1, 'Бойцовский клуб', 'Бойцовский клуб описание...', 'https://...', 139),
       (2, 'Идентификация Борна', 'Идентификация Борна описание...', 'https://...', 113),
       (3, 'Карты, деньги, два ствола', 'Карты, деньги, два ствола описание...', 'https://...', 103),
       (4, 'Джентельмены', 'Джентельмены описание...', 'https://...', 120);

INSERT INTO session (id, start_datetime, hall_id, film_id, price)
VALUES (1, '2020-03-28 11:00:00.000000', 1, 1, 200.00),
       (2, '2020-03-28 14:30:02.000000', 2, 1, 200.00),
       (3, '2020-03-28 17:45:02.000000', 1, 2, 300.00),
       (4, '2020-03-28 20:10:02.000000', 2, 2, 300.00);

INSERT INTO ticket (session_id, created, price, user_id)
SELECT (
           SELECT ids[trunc(random() * array_length(ids, 1) + 1)::int + (generator * 0)] session_id
           FROM (
                    SELECT ARRAY(
                                   SELECT id
                                   FROM session
                               ) ids
                ) a
       ),
       (
           SELECT now() -
                  (concat(trunc(random() * 24 * 60 * 100 + 1)::int + (generator * 0), ' minutes'))::interval created
       ),
       (
           SELECT trunc(random() * 11 + 1) * 100 + (generator * 0) price
       ),
       (
           SELECT ids[trunc(random() * array_length(ids, 1) + 1)::int + (generator * 0)] user_id
           FROM (
                    SELECT ARRAY(
                                   SELECT id



                                   FROM "user"
                               ) ids
                ) a
       )
FROM generate_series(1, 10000) generator;


