DROP VIEW IF EXISTS marketing_data;
DROP VIEW IF EXISTS service_data;
DROP TABLE IF EXISTS movie_attribute_values;
DROP TABLE IF EXISTS movie_attributes;
DROP TABLE IF EXISTS movies_attribute_types;
DROP TABLE IF EXISTS tickets;
DROP TABLE IF EXISTS seances;
DROP TABLE IF EXISTS movies;
DROP TABLE IF EXISTS places;
DROP TABLE IF EXISTS rooms;
DROP TABLE IF EXISTS discounts;

CREATE TABLE rooms
(
  id   SERIAL       NOT NULL,
  name VARCHAR(250) NOT NULL,
  CONSTRAINT rooms_pk PRIMARY KEY (id)
);

CREATE TABLE places
(
  id      SERIAL  NOT NULL,
  room_id INTEGER NOT NULL,
  row     INTEGER NOT NULL,
  place   INTEGER NOT NULL,
  CONSTRAINT places_pk PRIMARY KEY (id),
  CONSTRAINT places_room_fk FOREIGN KEY (room_id) REFERENCES rooms (id)
);

CREATE TABLE movies
(
  id   SERIAL       NOT NULL,
  name VARCHAR(250) NOT NULL,
  CONSTRAINT movies_pk PRIMARY KEY (id)
);

CREATE TABLE seances
(
  id       SERIAL  NOT NULL,
  room_id  INTEGER NOT NULL,
  movie_id INTEGER NOT NULL,
  price    INTEGER NOT NULL,
  CONSTRAINT seances_pk PRIMARY KEY (id),
  CONSTRAINT seances_rooms_fk FOREIGN KEY (room_id) REFERENCES rooms (id),
  CONSTRAINT seances_movies_fk FOREIGN KEY (movie_id) REFERENCES movies (id)
);

CREATE TABLE discounts
(
  id    SERIAL  NOT NULL,
  value INTEGER NOT NULL,
  CONSTRAINT discounts_pk PRIMARY KEY (id)
);

CREATE TABLE tickets
(
  id          SERIAL  NOT NULL,
  seance_id   INTEGER NOT NULL,
  place_id    INTEGER NOT NULL,
  price       INTEGER NOT NULL,
  discount_id INTEGER NOT NULL,
  CONSTRAINT tickets_pk PRIMARY KEY (id),
  CONSTRAINT tickets_seances_fk FOREIGN KEY (seance_id) REFERENCES seances (id),
  CONSTRAINT tickets_places_fk FOREIGN KEY (place_id) REFERENCES places (id),
  CONSTRAINT tickets_discounts_fk FOREIGN KEY (discount_id) REFERENCES discounts (id)
);

CREATE TABLE movies_attribute_types
(
  id    SERIAL       NOT NULL,
  name  VARCHAR(250) NOT NULL,
  value VARCHAR(250) NOT NULL,
  CONSTRAINT movies_attribute_types_pk PRIMARY KEY (id),
  CONSTRAINT movies_attribute_types_un UNIQUE (name)
);

CREATE TABLE movie_attributes
(
  id      SERIAL       NOT NULL,
  name    VARCHAR(250) NOT NULL,
  type_id INTEGER      NOT NULL,
  CONSTRAINT movie_attributes_pk PRIMARY KEY (id),
  CONSTRAINT movie_attributes_un UNIQUE (name),
  CONSTRAINT movie_attributes_fk FOREIGN KEY (type_id) REFERENCES movies_attribute_types (id)
);

CREATE TABLE movie_attribute_values
(
  id            SERIAL  NOT NULL,
  movie_id      INTEGER NOT NULL,
  attr_id       INTEGER NOT NULL,
  value_integer INTEGER NULL,
  value_float   FLOAT   NULL,
  value_text    TEXT    NULL,
  value_bool    BOOL    NULL,
  value_date    DATE    NULL,
  CONSTRAINT movie_attribute_values_pk PRIMARY KEY (id),
  CONSTRAINT movie_attribute_values_un UNIQUE (movie_id, attr_id),
  CONSTRAINT movie_attribute_values_movies_fk FOREIGN KEY (movie_id) REFERENCES movies (id),
  CONSTRAINT movie_attribute_values_attributes_fk FOREIGN KEY (attr_id) REFERENCES movie_attributes (id)
);

CREATE OR REPLACE FUNCTION random_between(low INT, high INT)
  RETURNS INT AS
$$
BEGIN
  RETURN floor(random() * (high - low + 1) + low);
END;
$$ LANGUAGE 'plpgsql' STRICT;

CREATE OR REPLACE FUNCTION price_with_discount(price INT, percent INT)
  RETURNS INT AS
$$
BEGIN
  RETURN floor(price * (100 - percent) / 100);
END;
$$ LANGUAGE 'plpgsql' STRICT;


DO $discounts_insert$
BEGIN

  FOR discount_amount IN 0..2 LOOP
    INSERT INTO discounts (value)
      SELECT (discount_amount * 10) AS value;
  END LOOP;
END;
$discounts_insert$;

DO $room_insert$
BEGIN

  FOR room_num IN 1..3 LOOP
    INSERT INTO rooms (name)
      SELECT CONCAT('Кинозал №', '', room_num) AS name;
  END LOOP;
END;
$room_insert$;

DO $places_insert$
DECLARE
  rooms_count  INTEGER;
  rows_count   INTEGER = 12;
  places_count INTEGER = 12;
BEGIN
  rooms_count := (SELECT count(id)
                  FROM rooms);

  FOR room_id IN 1..rooms_count LOOP
    FOR room_row IN 1..rows_count LOOP
      FOR room_place IN 1..places_count LOOP
        INSERT INTO places (room_id, row, place)
        VALUES (room_id, room_row, room_place);
      END LOOP;
    END LOOP;
  END LOOP;
END;
$places_insert$;

DO $movies_insert$
BEGIN

  FOR movie_num IN 1..10 LOOP
    INSERT INTO movies (name)
      SELECT CONCAT('Киношка №', '', movie_num) AS name;
  END LOOP;
END;
$movies_insert$;

DO $seances_insert$
DECLARE
  rooms_count              INTEGER;
  movie_count              INTEGER;
  average_seances_per_room INTEGER = 6;
BEGIN
  rooms_count := (SELECT count(id)
                  FROM rooms);
  movie_count := (SELECT count(id)
                  FROM movies);

  FOR col_seances IN 1..rooms_count * average_seances_per_room LOOP
    INSERT INTO seances (room_id, movie_id, price)
      SELECT
        random_between(1, rooms_count) AS room_id,
        random_between(1, movie_count) AS movie_id,
        random_between(500, 3000)      AS price;
  END LOOP;
END;
$seances_insert$;

DO
$tickets_seeder$
DECLARE
  tickets_count INTEGER = random_between(100, 1000);
  seance        RECORD;
  place         RECORD;
  discount      RECORD;
BEGIN

  FOR seance IN (SELECT
                   id,
                   room_id,
                   price
                 FROM seances) LOOP
    FOR place IN (SELECT id
                  FROM places
                  WHERE room_id = seance.room_id
                  LIMIT tickets_count) LOOP
      FOR discount IN (SELECT
                         id,
                         value
                       FROM discounts
                       WHERE id = random_between(1, 3)) LOOP
        INSERT INTO tickets (seance_id, place_id, price, discount_id)
        VALUES (seance.id, place.id, price_with_discount(seance.price, discount.value), discount.id);
      END LOOP;
    END LOOP;
  END LOOP;
END
$tickets_seeder$;

INSERT INTO movies_attribute_types (name, value)
VALUES ('Целое число', 'integer'),
  ('Вещественное число', 'float'),
  ('Важная дата', 'date'),
  ('Служебная дата', 'date'),
  ('Логическая переменная', 'bool'),
  ('Текст', 'text');

INSERT INTO movie_attributes (name, type_id)
VALUES
  ('Сборы', 1),
  ('Бюджет', 1),
  ('Рейтинг IMDB', 2),
  ('Рейтинг на кинопоиске', 2),
  ('Мировая премьера', 3),
  ('Премьера в РФ', 3),
  ('Дата старта продаж билетов', 4),
  ('Дата запуска рекламы', 4),
  ('Оскар', 5),
  ('Ника', 5),
  ('Рецензии', 6),
  ('Синопсис фильма', 6);


DO $movie_attribute_values_insert$
DECLARE
  movie_count      INTEGER;
  movie_attr_count INTEGER;
  value_integer    INTEGER;
  value_float      FLOAT;
  value_date       DATE;
  value_bool       BOOLEAN;
  value_text       TEXT;
BEGIN
  movie_count := (SELECT count(id)
                  FROM movies);

  movie_attr_count := (SELECT count(id)
                       FROM movie_attributes);

  FOR movie_id IN 1..movie_count LOOP
    FOR attr_id IN 1..movie_attr_count LOOP

      value_integer := NULL;
      value_float := NULL;
      value_date := NULL;
      value_bool := NULL;
      value_text := NULL;

      CASE attr_id
        WHEN 1
        THEN value_integer := random_between(5000000, 20000000);
        WHEN 2
        THEN value_integer := random_between(1000000, 5000000);
        WHEN 3
        THEN value_float := random() * 9 + 1;
        WHEN 4
        THEN value_float := random() * 9 + 1;
        WHEN 5
        THEN value_date := date(TIMESTAMP '2021-05-10' +
                                random() * (TIMESTAMP '2021-05-15' - TIMESTAMP '2021-05-10'));
        WHEN 6
        THEN value_date := date(TIMESTAMP '2021-05-10' +
                                random() * (TIMESTAMP '2021-05-15' - TIMESTAMP '2021-05-10'));
        WHEN 7
        THEN value_date := date(TIMESTAMP '2021-05-10' +
                                random() * (TIMESTAMP '2021-05-15' - TIMESTAMP '2021-05-10'));
        WHEN 8
        THEN value_date := date(TIMESTAMP '2021-05-10' +
                                random() * (TIMESTAMP '2021-05-15' - TIMESTAMP '2021-05-10'));
        WHEN 9
        THEN value_bool := (round(random()) :: INT) :: BOOLEAN;
        WHEN 10
        THEN value_bool := (round(random()) :: INT) :: BOOLEAN;
        WHEN 11
        THEN value_text := concat('Рецензия фильма ', movie_id);
        WHEN 12
        THEN value_text := concat('Синопсис фильма ', movie_id);
      END CASE;


      INSERT INTO movie_attribute_values (movie_id, attr_id, value_integer, value_float, value_date, value_bool, value_text)
        SELECT
          movie_id,
          attr_id,
          value_integer,
          value_float,
          value_date,
          value_bool,
          value_text;
    END LOOP;
  END LOOP;
END;
$movie_attribute_values_insert$;

-- View сборки служебных данных в форме
CREATE OR REPLACE VIEW public.service_data
  AS
    SELECT
      movies.name,
      string_agg(
          CASE
          WHEN mav.value_date = CURRENT_DATE
            THEN ma.name
          END,
          ', ')
        AS today_tasks,
      string_agg(
          CASE
          WHEN mav.value_date > CURRENT_DATE AND mav.value_date <= (CURRENT_DATE + INTERVAL '20 day')
            THEN ma.name
          END,
          ', ')
        AS future_tasks
    FROM movies
      JOIN movie_attribute_values mav ON mav.movie_id = movies.id
      JOIN movie_attributes ma ON ma.id = mav.attr_id
    WHERE mav.value_date <= (CURRENT_DATE + INTERVAL '20 day') AND mav.value_date >= CURRENT_DATE
    GROUP BY movies.id
    ORDER BY movies.id;

-- View сборки данных для маркетинга в форме
CREATE OR REPLACE VIEW public.marketing_data
  AS SELECT
       movies.name AS movie_name,
       ma.name AS attribute_name,
       mat.name AS attribute_type,
       COALESCE(
           mav.value_integer::TEXT,
           mav.value_float::TEXT,
           mav.value_date::TEXT,
           mav.value_bool::TEXT,
           mav.value_text::TEXT
       ) AS attribute_value
     FROM movies
       INNER JOIN movie_attribute_values mav ON movies.id = mav.movie_id
       INNER JOIN movie_attributes ma ON ma.id = mav.attr_id
       INNER JOIN movies_attribute_types mat ON mat.id = ma.type_id
     ORDER BY movies.id, ma.id;

SELECT
  m.id         AS movie_id,
  m.name,
  SUM(s.price) AS total_cost
FROM movies AS m
  INNER JOIN seances AS s ON s.movie_id = m.id
  INNER JOIN tickets AS t ON t.seance_id = s.id
GROUP BY m.id, m.name
ORDER BY total_cost DESC