INSERT INTO films (id, name) VALUES
(1,'Кин дза дза'),
(2,'Джентельмены удачи'),
(3,'Белое солнце пустыни'),
(4,'Кавказская пленница'),
(5,'Операция ы');

INSERT INTO film_attributes_types (id, name, comment) VALUES
(1,'Число', 'Целое число'),
(2,'Текст', 'Простой текст'),
(3,'Дата', 'Дата с временем'),
(4,'Цена', 'Цена с копейками');

INSERT INTO film_attributes (id, name, type_id) VALUES
(1,'Отзыв', 2),
(2,'Премия', 2),
(3,'Цена', 4),
(4,'Служебные даты', 3),
(5,'Важные даты', 3);

INSERT INTO film_attributes_values (id, attribute_id, film_id, val_text, val_float, val_date) VALUES
(1,1, 1, 'Жизненно', NULL, NULL),
(2,2, 1,'Золотой орел', NULL, NULL),
(3,3, 1, NULL, '100.45',  NULL),
(4,4, 1, NULL, NULL, CURRENT_DATE),
(5,5, 1, NULL, NULL, CURRENT_DATE);

INSERT INTO film_attributes_values (id, attribute_id, film_id, val_text, val_float, val_date) VALUES
(6,1, 2, 'Весело', NULL, NULL),
(7,2, 2, 'Оскар', NULL, NULL),
(8,3, 2, NULL, '200', NULL),
(9,4, 2, NULL, NULL, CURRENT_DATE + interval '20 days'),
(10,5, 2, NULL, NULL, CURRENT_DATE + interval '20 days');

INSERT INTO film_attributes_values (id, attribute_id, film_id, val_text, val_float, val_date) VALUES
(11,1, 3, 'Боевой фильм', NULL, NULL),
(12,2, 3, 'Золотой глобус', NULL, NULL),
(13,3, 3, NULL,'150.25', NULL),
(14,4, 3, NULL, NULL, CURRENT_DATE + interval '10 days'),
(15,5, 3, NULL, NULL, CURRENT_DATE + interval '11 days');

INSERT INTO film_attributes_values (id, attribute_id, film_id, val_text, val_float, val_date) VALUES
(16,1, 4, 'Птичку жалко', NULL, NULL),
(17,2, 4, 'Золотой глобус', NULL, NULL),
(18,3, 4, NULL, '100', NULL),
(19,4, 4, NULL, NULL, CURRENT_DATE + interval '8 days'),
(20,5, 4, NULL, NULL, CURRENT_DATE + interval '9 days');

INSERT INTO film_attributes_values (id, attribute_id, film_id, val_text, val_float, val_date) VALUES
(21,1, 5, 'Гениальный план', NULL, NULL),
(22,2, 5, 'Оскар', NULL, NULL),
(23,3, 5, NULL, '200', NULL),
(24,4, 5, NULL, NULL, CURRENT_DATE + interval '10 days'),
(25,5, 5, NULL, NULL, CURRENT_DATE + interval '10 days');
