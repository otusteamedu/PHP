INSERT INTO movies_attributes_types(name) VALUES ('Дата'), ('Дата и время'), ('Текст'), ('Целое'), ('Вещественное'),
('Логическое');

INSERT INTO movies_attributes(name, type) VALUES
('Год выпуска', 4), ('Жанр', 3), ('Дата премьеры в Росcии', 1), ('Сборы в мире', 5), ('Есть премии', 6),
('Дата начала продажи билетов', 1), ('Начало запуска рекламы', 2);

INSERT INTO movies(name) VALUES ('Лука'), ('Ледяной драйв'), ('Джетлаг');

INSERT INTO movies_attributes_values(movie_id, attribute_id, int_value) VALUES (1, 1, 2021);
INSERT INTO movies_attributes_values(movie_id, attribute_id, text_value) VALUES (1, 2, 'комедия');
INSERT INTO movies_attributes_values(movie_id, attribute_id, date_value) VALUES (1, 3, '2021-06-17');
INSERT INTO movies_attributes_values(movie_id, attribute_id, float_value) VALUES (1, 4, 5000000.50);
INSERT INTO movies_attributes_values(movie_id, attribute_id, boolean_value) VALUES (1, 5, false);
INSERT INTO movies_attributes_values(movie_id, attribute_id, date_value) VALUES (1, 6, '2021-06-17');
INSERT INTO movies_attributes_values(movie_id, attribute_id, datetime_value) VALUES (1, 7, '2021-06-12 10:00');

INSERT INTO movies_attributes_values(movie_id, attribute_id, int_value) VALUES (2, 1, 2021);
INSERT INTO movies_attributes_values(movie_id, attribute_id, text_value) VALUES (2, 2, 'триллер');
INSERT INTO movies_attributes_values(movie_id, attribute_id, date_value) VALUES (2, 3, '2021-06-25');
INSERT INTO movies_attributes_values(movie_id, attribute_id, boolean_value) VALUES (2, 5, false);
INSERT INTO movies_attributes_values(movie_id, attribute_id, date_value) VALUES (2, 6, '2021-06-25');
INSERT INTO movies_attributes_values(movie_id, attribute_id, datetime_value) VALUES (2, 7, '2021-06-20 10:00');

INSERT INTO movies_attributes_values(movie_id, attribute_id, int_value) VALUES (3, 1, 2021);
INSERT INTO movies_attributes_values(movie_id, attribute_id, text_value) VALUES (3, 2, 'комедия');
INSERT INTO movies_attributes_values(movie_id, attribute_id, text_value) VALUES (3, 2, 'спорт');
INSERT INTO movies_attributes_values(movie_id, attribute_id, date_value) VALUES (3, 3, '2021-07-15');
INSERT INTO movies_attributes_values(movie_id, attribute_id, boolean_value) VALUES (3, 5, false);
INSERT INTO movies_attributes_values(movie_id, attribute_id, date_value) VALUES (3, 6, '2021-07-15');
INSERT INTO movies_attributes_values(movie_id, attribute_id, datetime_value) VALUES (3, 7, '2021-07-02 10:00');
