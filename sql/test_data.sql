-- movies
INSERT INTO movies (id, name, description, poster_path)
SELECT gs.id, random_string(20), random_string(500), random_string(30)
FROM generate_series(1, 1000000) AS gs(id);

-- attributes_types
INSERT INTO public.attributes_types (id, name) VALUES (1, 'Текст');
INSERT INTO public.attributes_types (id, name) VALUES (2, 'Вещественное число');
INSERT INTO public.attributes_types (id, name) VALUES (3, 'Целое число');
INSERT INTO public.attributes_types (id, name) VALUES (4, 'Дата');
INSERT INTO public.attributes_types (id, name) VALUES (5, 'Да/нет');

-- movies_attributes
INSERT INTO public.movies_attributes (id, name, type_id, is_system) VALUES (1, 'Рецензия', 1, false);
INSERT INTO public.movies_attributes (id, name, type_id, is_system) VALUES (2, 'Отзыв', 1, false);
INSERT INTO public.movies_attributes (id, name, type_id, is_system) VALUES (3, 'Страна', 1, false);
INSERT INTO public.movies_attributes (id, name, type_id, is_system) VALUES (4, 'Режисер', 1, false);

INSERT INTO public.movies_attributes (id, name, type_id, is_system) VALUES (5, 'Средняя стоимость билета', 2, false);

INSERT INTO public.movies_attributes (id, name, type_id, is_system) VALUES (6, 'Сборы в мире', 3, false);
INSERT INTO public.movies_attributes (id, name, type_id, is_system) VALUES (7, 'Сборы в России', 3, false);
INSERT INTO public.movies_attributes (id, name, type_id, is_system) VALUES (8, 'Продолжительность', 3, false);

INSERT INTO public.movies_attributes (id, name, type_id, is_system) VALUES (9, 'Премьера в РФ', 4, false);
INSERT INTO public.movies_attributes (id, name, type_id, is_system) VALUES (10, 'Мировая премьера', 4, false);
INSERT INTO public.movies_attributes (id, name, type_id, is_system) VALUES (11, 'Начало продажи билетов', 4, true);
INSERT INTO public.movies_attributes (id, name, type_id, is_system) VALUES (12, 'Запуск рекламы на ТВ', 4, true);
INSERT INTO public.movies_attributes (id, name, type_id, is_system) VALUES (13, 'Запуск рекламы по радио', 4, true);

INSERT INTO public.movies_attributes (id, name, type_id, is_system) VALUES (14, 'Получена премия "Оскар"', 5, false);
INSERT INTO public.movies_attributes (id, name, type_id, is_system) VALUES (15, 'Получена премия "Ника"', 5, false);

-- movies_attributes_value
-- Текст, атрибуты 1 - 4
INSERT INTO movies_attributes_value (id, movie_id, attribute_id, text_value, numeric_value, date_value, int_value)
SELECT gs.id,
       (floor(random()*(1000000-1+1))+1)::int,
       (floor(random()*(4-1+1))+1)::int,
       random_string((floor(random()*(500-30+1))+30)::int),
       null,
       null,
       null
FROM generate_series(1000001, 2000000) AS gs(id);

-- Вещественное число, атрибуты 5
INSERT INTO movies_attributes_value (id, movie_id, attribute_id, text_value, numeric_value, date_value, int_value)
SELECT gs.id,
       (floor(random()*(1000000-1+1))+1)::int,
       5,
       null,
       floor(random()*(300-1+1))+1,
       null,
       null
FROM generate_series(2000001, 3000000) AS gs(id);

-- Целое число, атрибуты 6 - 8
INSERT INTO movies_attributes_value (id, movie_id, attribute_id, text_value, numeric_value, date_value, int_value)
SELECT gs.id,
       (floor(random()*(1000000-1+1))+1)::int,
       (floor(random()*(8-6+1))+6)::int,
       null,
       null,
       null,
       (floor(random()*(400-1+1))+1)::int
FROM generate_series(3000001, 4000000) AS gs(id);

-- Дата, атрибуты 9 - 13
INSERT INTO movies_attributes_value (id, movie_id, attribute_id, text_value, numeric_value, date_value, int_value)
SELECT gs.id,
       (floor(random()*(1000000-1+1))+1)::int,
       (floor(random()*(13-9+1))+9)::int,
       null,
       null,
       (
           (floor(random()*(2020-1900+1))+1900)::text || '-' ||
           (floor(random()*(12-10+1))+1)::text || '-' ||
           (floor(random()*(28-10+1))+1)::text || ' 00:00:00.000000'
       )::timestamp,
       null
FROM generate_series(4000001, 5000000) AS gs(id);

-- Да/нет, атрибуты 14 - 15
INSERT INTO movies_attributes_value (id, movie_id, attribute_id, text_value, numeric_value, date_value, int_value)
SELECT gs.id,
       (floor(random()*(1000000-1+1))+1)::int,
       (floor(random()*(15-14+1))+14)::int,
       null,
       null,
       null,
       (floor(random()*(1-0+1))+0)::int
FROM generate_series(5000001, 6000000) AS gs(id);
