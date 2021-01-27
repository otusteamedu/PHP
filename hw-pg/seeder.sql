-- заполняем таблицу films
INSERT INTO films (title, show_start_date, length)
SELECT 'Scary movie ' || generate_series(1, 10000)::text AS title,
       NOW() + random_between(0, 20) * interval '1 WEEK' AS show_start_date,
        random_between(30, 240) AS movie_length;


-- заполняем таблицу films_attr_types
INSERT INTO films_attr_types (name, comment) VALUES
('int', 'integer value')
