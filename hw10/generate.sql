INSERT INTO homework.client(id, first_name, last_name)
SELECT
    seq,
   seq || (
    CASE (RANDOM() * 2)::INT
      WHEN 0 THEN ' Иван'
      WHEN 1 THEN ' Алексей'
      WHEN 2 THEN ' Роман'
    END
  ) AS first_name,
  seq || (
    CASE (RANDOM() * 2)::INT
      WHEN 0 THEN ' Бак'
      WHEN 1 THEN 'Соколов'
      WHEN 2 THEN 'Иванов'
    END
  ) AS last_name
FROM GENERATE_SERIES(1, 10000000) seq;

INSERT INTO homework.cinemas(id, title)
SELECT
    seq,
   seq || ' кинотеатр' AS title
FROM GENERATE_SERIES(1, 10000000) seq;

INSERT INTO homework.halls(id, title, cinema_id)
SELECT
    seq,
    seq || ' зал' as title,
   (random()*9999999 + 1)::integer
FROM GENERATE_SERIES(1, 10000000) seq;

INSERT INTO homework.movies(id, title, cost)
SELECT
    seq,
        seq || ' фильм' AS title,
        round(random()*10000) as cost
FROM GENERATE_SERIES(1, 10000000) seq;

INSERT INTO homework.seats_hall(id, hall_id, series, number)
SELECT
    seq,
    (random()*9999999 + 1)::integer,
    round(random()*9999999 + 1) as series,
    round(random()*9999999 + 1) as number
FROM GENERATE_SERIES(1, 10000000) seq;




INSERT INTO homework.sessions(id, title, movie_id, hall_id)
SELECT
    seq,
   'Сессия: ' || seq AS body,
    (random()*9999999 + 1)::integer,
    (random()*9999999 + 1)::integer
FROM GENERATE_SERIES(1, 10000000) seq;

INSERT INTO homework.tickets(id, session_id, client_id, seat_hall_id, cost)
SELECT
    seq,
    (random()*9999999 + 1)::integer,
    (random()*9999999 + 1)::integer,
    (random()*9999999 + 1)::integer,
   round(random()*5000) as cost
FROM GENERATE_SERIES(1, 10000000) seq;


INSERT INTO homework.movies_attributes_types (id, title)
VALUES (1, 'Булевое');
INSERT INTO homework.movies_attributes_types (id, title)
VALUES (2, 'Текст');
INSERT INTO homework.movies_attributes_types (id, title)
VALUES (3, 'Целые числа');
INSERT INTO homework.movies_attributes_types (id, title)
VALUES (4, 'Вещественные числа');
INSERT INTO homework.movies_attributes_types (id, title)
VALUES (5, 'Дата');


INSERT INTO homework.movies_attributes(title, type)
WITH expanded AS (
    SELECT RANDOM(), seq, t.id AS type
    FROM GENERATE_SERIES(1, 10000000) seq, homework.movies_attributes_types t
), shuffled AS (
    SELECT e.*
    FROM expanded e
             INNER JOIN (
        SELECT ei.seq, MIN(ei.random) FROM expanded ei GROUP BY ei.seq
    ) em ON (e.seq = em.seq AND e.random = em.min)
    ORDER BY e.seq
)
SELECT
    (
        CASE (s.type)::INT
            WHEN 1 THEN ' Выпустился ли фильм'
            WHEN 2 THEN ' Описание фильма'
            WHEN 3 THEN ' Стоимость фильма'
            WHEN 4 THEN ' Процент просмотров'
            WHEN 5 THEN ' Дата начала'
            END
        ) AS title,
    s.type
FROM shuffled s;


INSERT INTO homework.movies_attributes_values(movie_attribute_id, movie_id, val_bool, val_text,val_integer, val_real, val_date)
WITH expanded AS (
    SELECT RANDOM(), seq, a.id AS attribute, a.type AS attributesType
    FROM GENERATE_SERIES(1, 10000000) seq, homework.movies_attributes a
), shuffled AS (
    SELECT e.*
    FROM expanded e
             INNER JOIN (
        SELECT ei.seq, MIN(ei.random) FROM expanded ei GROUP BY ei.seq
    ) em ON (e.seq = em.seq AND e.random = em.min)
    ORDER BY e.seq
)
SELECT
    s.attribute,
    (random()*10000 + 1)::integer,
    (
        CASE (s.attributesType)::INT
            WHEN 1 THEN floor(random() * 1)
            END
        ) AS val_bool,
    (
        CASE (s.attributesType)::INT
            WHEN 2 THEN random_string()
            END
        ) AS val_text,
    (
        CASE (s.attributesType)::INT
            WHEN 3 THEN floor(random() * 1000000)
            END
        ) AS val_integer,
    (
        CASE (s.attributesType)::INT
            WHEN 4 THEN random() * 1000000
            END
        ) AS val_real,
    (
        CASE (s.attributesType)::INT
            WHEN 5 THEN gen_date('1980-01-01')
            END
        ) AS val_date
FROM shuffled s;