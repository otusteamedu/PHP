-- movies
INSERT INTO public.movies (id, name, description, poster_path) VALUES (3, 'Побег из Шоушенка', 'Побег из Шоушенка', '/path');
INSERT INTO public.movies (id, name, description, poster_path) VALUES (4, 'Зеленая миля ', 'Зеленая миля ', '/path');

-- attributes_types
INSERT INTO public.attributes_types (id, name) VALUES (1, 'Текст');
INSERT INTO public.attributes_types (id, name) VALUES (2, 'Вещественное число');
INSERT INTO public.attributes_types (id, name) VALUES (4, 'Дата');
INSERT INTO public.attributes_types (id, name) VALUES (3, 'Целое число');
INSERT INTO public.attributes_types (id, name) VALUES (5, 'Да/нет');

-- movies_attributes
INSERT INTO public.movies_attributes (id, name, type_id, is_system) VALUES (1, 'Рецензия', 1, false);
INSERT INTO public.movies_attributes (id, name, type_id, is_system) VALUES (4, 'Отзыв', 1, false);
INSERT INTO public.movies_attributes (id, name, type_id, is_system) VALUES (5, 'Мировая премьера', 4, false);
INSERT INTO public.movies_attributes (id, name, type_id, is_system) VALUES (6, 'Премьера в РФ', 4, false);
INSERT INTO public.movies_attributes (id, name, type_id, is_system) VALUES (7, 'Страна', 1, false);
INSERT INTO public.movies_attributes (id, name, type_id, is_system) VALUES (8, 'Режисер', 1, false);
INSERT INTO public.movies_attributes (id, name, type_id, is_system) VALUES (9, 'Сборы в мире', 3, false);
INSERT INTO public.movies_attributes (id, name, type_id, is_system) VALUES (10, 'Сборы в России', 3, false);
INSERT INTO public.movies_attributes (id, name, type_id, is_system) VALUES (11, 'Продолжительность', 3, false);
INSERT INTO public.movies_attributes (id, name, type_id, is_system) VALUES (12, 'Начало продажи билетов', 4, true);
INSERT INTO public.movies_attributes (id, name, type_id, is_system) VALUES (13, 'Запуск рекламы на ТВ', 4, true);
INSERT INTO public.movies_attributes (id, name, type_id, is_system) VALUES (15, 'Запуск рекламы по радио', 4, true);
INSERT INTO public.movies_attributes (id, name, type_id, is_system) VALUES (2, 'Получена премия "Оскар"', 5, false);
INSERT INTO public.movies_attributes (id, name, type_id, is_system) VALUES (3, 'Получена премия "Ника"', 5, false);
INSERT INTO public.movies_attributes (id, name, type_id, is_system) VALUES (16, 'Средняя стоимость билета', 2, false);

-- movies_attributes_value
INSERT INTO public.movies_attributes_value (id, movie_id, attribute_id, text_value, numeric_value, date_value, int_value) VALUES (1, 3, 2, null, null, null, 0);
INSERT INTO public.movies_attributes_value (id, movie_id, attribute_id, text_value, numeric_value, date_value, int_value) VALUES (2, 3, 5, null, null, '1994-09-10 00:00:00.000000', null);
INSERT INTO public.movies_attributes_value (id, movie_id, attribute_id, text_value, numeric_value, date_value, int_value) VALUES (3, 3, 6, null, null, '2019-10-24 00:00:00.000000', null);
INSERT INTO public.movies_attributes_value (id, movie_id, attribute_id, text_value, numeric_value, date_value, int_value) VALUES (4, 3, 9, null, null, null, 28418687);
INSERT INTO public.movies_attributes_value (id, movie_id, attribute_id, text_value, numeric_value, date_value, int_value) VALUES (5, 4, 9, null, null, null, 286801374);
INSERT INTO public.movies_attributes_value (id, movie_id, attribute_id, text_value, numeric_value, date_value, int_value) VALUES (6, 4, 8, 'Фрэнк Дарабонт', null, null, null);
INSERT INTO public.movies_attributes_value (id, movie_id, attribute_id, text_value, numeric_value, date_value, int_value) VALUES (8, 4, 16, null, 500.78, null, null);
INSERT INTO public.movies_attributes_value (id, movie_id, attribute_id, text_value, numeric_value, date_value, int_value) VALUES (7, 4, 12, null, null, '2020-03-22 00:00:00.000000', null);
INSERT INTO public.movies_attributes_value (id, movie_id, attribute_id, text_value, numeric_value, date_value, int_value) VALUES (9, 3, 13, null, null, '2020-05-05 00:00:00.000000', null);