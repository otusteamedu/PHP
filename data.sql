INSERT INTO movies_attributes_types(name) VALUES ('Дата'), ('Текст'), ('Сумма');

INSERT INTO movies_attributes(name, type) VALUES
('Жанр', 2), ('Премьера в Росcии', 1), ('Сборы в мире', 3), ('Дата начала продажи билетов', 1),
('Дата начала запуска рекламы', 1);

INSERT INTO movies(name) VALUES ('Лука'), ('Ледяной драйв'), ('Джетлаг');

INSERT INTO movies_attributes_values(movie_id, attribute_id, text_value) VALUES (1, 1, 'комедия');
INSERT INTO movies_attributes_values(movie_id, attribute_id, date_value) VALUES (1, 2, '2021-06-17');
INSERT INTO movies_attributes_values(movie_id, attribute_id, numeric_value) VALUES (1, 3, 12921);
INSERT INTO movies_attributes_values(movie_id, attribute_id, date_value) VALUES (1, 4, '2021-06-17');
INSERT INTO movies_attributes_values(movie_id, attribute_id, date_value) VALUES (1, 5, '2021-06-12');

INSERT INTO movies_attributes_values(movie_id, attribute_id, text_value) VALUES (2, 1, 'триллер');
INSERT INTO movies_attributes_values(movie_id, attribute_id, date_value) VALUES (2, 2, '2021-06-25');
INSERT INTO movies_attributes_values(movie_id, attribute_id, date_value) VALUES (2, 4, '2021-06-25');
INSERT INTO movies_attributes_values(movie_id, attribute_id, date_value) VALUES (2, 5, '2021-06-20');

INSERT INTO movies_attributes_values(movie_id, attribute_id, text_value) VALUES (3, 1, 'комедия');
INSERT INTO movies_attributes_values(movie_id, attribute_id, text_value) VALUES (3, 1, 'спорт');
INSERT INTO movies_attributes_values(movie_id, attribute_id, date_value) VALUES (3, 2, '2021-07-15');
INSERT INTO movies_attributes_values(movie_id, attribute_id, date_value) VALUES (3, 4, '2021-07-15');
INSERT INTO movies_attributes_values(movie_id, attribute_id, date_value) VALUES (3, 5, '2021-07-02');
