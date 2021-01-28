-- заполняем таблицу films
INSERT INTO films (title, show_start_date, length)
SELECT 'Scary movie ' || generate_series(1, 10000)::text AS title,
       NOW() + random_between(0, 20) * interval '1 WEEK' AS show_start_date,
        random_between(30, 240) AS movie_length;

-- заполняем таблицу halls
INSERT INTO halls (title)
VALUES ('Зал 1'),
       ('Зал 2'),
       ('Зал 3'),
       ('Зал 4'),
       ('Зал 5'),
       ('Зал 6'),
       ('Зал 7'),
       ('Зал 8'),
       ('Зал 9'),
       ('Зал 10'),
       ('Зал 11'),
       ('Зал 12');

-- заполняем таблицу places
DO
$places_seeder$
DECLARE
    halls_count  integer = NULL;
    rows_count   integer = 20;
    places_count integer = 40;
BEGIN
    halls_count := (SELECT count(id) FROM halls);

    FOR hall_id IN 1..halls_count LOOP
        FOR row_number IN 1..rows_count LOOP
            INSERT INTO places (hall_id, hall_row, row_place)
            SELECT hall_id AS hall_id, row_number AS hall_row, generate_series(1, places_count)::integer AS row_place;
        END LOOP;
    END LOOP;
END
$places_seeder$;

-- заполняем таблицу seances
DO
$seances_seeder$
DECLARE
    films_count   integer = NULL;
    seances_count integer = NULL;
    halls_count   integer = NULL;
BEGIN
    films_count   := (SELECT count(id) FROM films);
    halls_count   := (SELECT count(id) FROM halls);
    seances_count = films_count / 10;

    FOR n IN 1..seances_count LOOP
        INSERT INTO seances (hall_id, film_id, date_start, price)
        VALUES (
            random_between(1, halls_count),
            random_between(1, films_count),
            random_film_start_datetime('2021-01-01', '2021-05-01'),
            random_between(100, 300)
        );
    END LOOP;
END
$seances_seeder$;

-- заполняем таблицу tickets
DO
$tickets_seeder$
DECLARE
    tickets_count integer;
    seance        record;
    place         record;
BEGIN
    FOR seance IN (SELECT id, hall_id FROM seances) LOOP
        tickets_count := random_between(50, 800);

        FOR place IN (SELECT id FROM places WHERE hall_id = seance.hall_id ORDER BY random() LIMIT tickets_count) LOOP
            INSERT INTO tickets (seance_id, place_id) VALUES (seance.id, place.id);
        END LOOP;
    END LOOP;
END
$tickets_seeder$;

-- заполняем таблицу films_attr_types
INSERT INTO films_attr_types (name, comment)
VALUES ('int', 'integer value'),
       ('date', 'simple date'),
       ('date_ext', 'date with attr name'),
       ('bool', 'boolean value'),
       ('text', 'text vale'),
       ('float', 'float value');

-- заполняем таблицу films_attr
INSERT INTO films_attr (name, type_id)
VALUES ('Минимальный возраст', 1),
       ('Премьера в мире', 2),
       ('Премьера в РФ', 2),
       ('Дата начала продажи билетов', 3),
       ('Премия Оскар', 4),
       ('Премия Золотой глобус', 4),
       ('Описание', 5),
       ('Главные роли', 5),
       ('Сборы в мире', 6),
       ('Сборы в РФ', 6);

-- заполняем таблицу films_attr_values
DO
$films_attr_values_seeder$
DECLARE
    films_count      integer = NULL;
    films_attr_count integer = NULL;
    val_date         date    = NULL;
    val_text         text    = NULL;
    val_bool         bool    = NULL;
    val_int          integer = NULL;
    val_float        float   = NULL;
BEGIN
    films_count      := (SELECT count(id) FROM films);
    films_attr_count := (SELECT count(id) FROM films_attr);

    FOR film_id IN 1..films_count LOOP
        FOR attr_id IN 1..films_attr_count LOOP
            val_date  := NULL;
            val_text  := NULL;
            val_bool  := NULL;
            val_int   := NULL;
            val_float := NULL;

            CASE
                WHEN attr_id = 1 THEN val_int := random_between(0, 18);
                WHEN attr_id BETWEEN 2 AND 4 THEN val_date := random_date_between('2021-01-01', '2021-09-01');
                WHEN attr_id BETWEEN 5 AND 6 THEN val_bool := random() < 0.5;
                WHEN attr_id BETWEEN 7 AND 8 THEN val_text := random_string((random()*100)::integer);
                WHEN attr_id BETWEEN 9 AND 10 THEN val_float := random_between(1000000, 50000000) + random();
                ELSE val_int := NULL;
            END CASE;

            INSERT INTO films_attr_values (film_id, attr_id, val_int, val_date, val_bool, val_text, val_float)
                VALUES (film_id, attr_id, val_int, val_date, val_bool, val_text, val_float);
        END LOOP;
    END LOOP;
END
$films_attr_values_seeder$;
