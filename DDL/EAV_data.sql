-- Add movies
INSERT INTO public.movie
(id, title, description, duration)
VALUES(1, 'movie1', 'movie1 desc', 120),
(2, 'movie2', 'movie2 desc', 120),
(3, 'movie3', 'movie3 desc', 120);

-- Add types
INSERT INTO public.movie_attr_type
    ("id", "name", "comment")
VALUES (1, 'text', 'текстовое поле'),
       (2, 'int', 'целое число'),
       (3, 'double', 'число с плавающей точкой'),
       (4, 'date', 'дата'),
       (5, 'boolean', 'булевое');

-- Add attributes
INSERT INTO public.movie_attr
    (id, id_type, name)
VALUES (1, 1, 'Короткое описание'),
       (2, 3, 'Рейтинг IMDB'),
       (3, 2, 'Сборы в мире'),
       (4, 4, 'Дата премьеры в мире'),
       (5, 4, 'Дата премьеры в Украине'),
       (6, 5, 'Номинирован на оскар'),
       (7, 5, 'Участник Каннского кинофестиваля'),
       (8, 1, 'Жанр'),
       (9, 4, 'Дата начала продажи биллетов'),
       (10, 4, 'Дата запуска рекламы'),
       (11, 4, 'Дата начала проката');

-- Add values
INSERT INTO public.movie_attr_value
(id_attr, id_movie, value_text, value_int, value_double, value_date, value_boolean)
VALUES (1, 1, 'Some small DESCRIPTION', NULL, NULL, NULL, NULL),
       (2, 1, NULL, NULL, 7.6, NULL, NULL),
       (3, 1, NULL, 20000000, NULL, NULL, NULL),
       (4, 1, NULL, NULL, NULL, '2020-08-01', NULL),
       (5, 1, NULL, NULL, NULL, '2020-08-10', NULL),
       (6, 1, NULL, NULL, NULL, NULL, true),
       (7, 1, NULL, NULL, NULL, NULL, true),
       (8, 1, 'Драма, Коммедия', NULL, NULL, NULL, NULL),
       (9, 1, NULL, NULL, NULL, '2020-08-11', NULL),
       (10, 1, NULL, NULL, NULL, '2020-08-09', NULL),
       (11, 1, NULL, NULL, NULL, '2020-08-12', NULL);


-- Add values
INSERT INTO public.movie_attr_value
(id_attr, id_movie, value_text, value_int, value_double, value_date, value_boolean)
VALUES (1, 2, 'Some small DESCRIPTION movie 2', NULL, NULL, NULL, NULL),
       (2, 2, NULL, NULL, 8.33, NULL, NULL),
       (3, 2, NULL, 150000000, NULL, NULL, NULL),
       (4, 2, NULL, NULL, NULL, '2020-08-12', NULL),
       (5, 2, NULL, NULL, NULL, '2020-08-20', NULL),
       (6, 2, NULL, NULL, NULL, NULL, true),
       (7, 2, NULL, NULL, NULL, NULL, true),
       (8, 2, 'Триллер, Коммедия', NULL, NULL, NULL, NULL),
       (9, 2, NULL, NULL, NULL, '2020-08-22', NULL),
       (10, 2, NULL, NULL, NULL, '2020-08-21', NULL),
       (11, 2, NULL, NULL, NULL, '2020-08-23', NULL);

-- Add values
INSERT INTO public.movie_attr_value
(id_attr, id_movie, value_text, value_int, value_double, value_date, value_boolean)
VALUES (1, 3, 'Some small DESCRIPTION movie 3', NULL, NULL, NULL, NULL),
       (2, 3, NULL, NULL, 8.33, NULL, NULL),
       (3, 3, NULL, 18000000, NULL, NULL, NULL),
       (4, 3, NULL, NULL, NULL, '2020-08-10', NULL),
       (5, 3, NULL, NULL, NULL, '2020-08-15', NULL),
       (6, 3, NULL, NULL, NULL, NULL, true),
       (7, 3, NULL, NULL, NULL, NULL, true),
       (8, 3, 'Триллер, Ужасы', NULL, NULL, NULL, NULL),
       (9, 3, NULL, NULL, NULL, '2020-08-18', NULL),
       (10, 3, NULL, NULL, NULL, '2020-08-20', NULL),
       (11, 3, NULL, NULL, NULL, '2020-08-22', NULL);