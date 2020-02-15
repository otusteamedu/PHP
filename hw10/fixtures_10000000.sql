TRUNCATE TABLE
    public.tickets,
    public.sessions,
    public.places,
    public.movies_attr_value,
    public.movies_attr,
    public.movies_attr_type,
    public.movies,
    public.halls;

   -- Заполнение таблицы залы
INSERT INTO halls (name)
SELECT random_string()
FROM generate_series(1, 10) as gn(id) on conflict do nothing;
-- Заполнение таблицы  фильмов - 10000 значений
INSERT INTO movies (name, description)
SELECT random_string(), random_string()
FROM generate_series(1, 10000) as gn(id) on conflict do nothing;
-- Заполнение таблицы мест
INSERT INTO places (hall_id, place_tariff)
SELECT halls.id, random_int(1000)
FROM generate_series(1, 10)
    CROSS JOIN halls;
-- Заполнение таблицы сеансов
INSERT INTO sessions (hall_id, movie_id, session_tariff, "date")
SELECT halls.id, movies.id, random_int(1000), random_datetime()
FROM generate_series(1, 1)
   CROSS JOIN halls
   CROSS JOIN movies;
-- Заполнение таблицы билетов - 10000000
INSERT INTO tickets (session_id, place_id, price)
SELECT sessions.id , places.id, sessions.session_tariff + places.place_tariff
FROM generate_series(1, 1)
   CROSS JOIN sessions
   CROSS JOIN places;
-- Заполнение таблицы типов атрибутов
INSERT INTO movies_attr_type (name)
SELECT random_string()
FROM generate_series(1, 100) as gn(id) on conflict do nothing;
-- Заполнение таблицы атрибутов
INSERT INTO movies_attr (type_id ,name)
SELECT movies_attr_type.id, random_string()
FROM generate_series(1,10) as gn(id)
    CROSS JOIN movies_attr_type;
-- Заполнение таблицы значений атрибутов фильмов - 10000000
INSERT INTO public.movies_attr_value (movie_id, movie_attr_id, value_string, value_date, value_bool, value_float, value_int)
SELECT movies.id,
       movies_attr.id,
       CASE
           WHEN ((right(movies_attr.type_id::text, 1)::int <= 2) and (right(movies_attr.type_id::text, 1)::int > 0))
               THEN random_string()
           END,
       CASE
           WHEN ((right(movies_attr.type_id::text, 1)::int <= 4) and (right(movies_attr.type_id::text, 1)::int > 2))
               THEN random_datetime()
           END,
       CASE
           WHEN ((right(movies_attr.type_id::text, 1)::int <= 6) and (right(movies_attr.type_id::text, 1)::int > 4))
               THEN (round(random())::int)::boolean
           END,
       CASE
           WHEN ((right(movies_attr.type_id::text, 1)::int <= 8) and (right(movies_attr.type_id::text, 1)::int > 6))
               THEN random()*1000
           END,
       CASE
           WHEN ((right(movies_attr.type_id::text, 1)::int > 8) or (right(movies_attr.type_id::text, 1)::int = 0))
               THEN random_int(10000)
           END
FROM generate_series(1,1)
    CROSS JOIN movies
    CROSS JOIN movies_attr