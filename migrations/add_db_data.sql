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
(1,'Фильм', 1),
(2,'Отзыв', 2),
(3,'Премия', 2),
(4,'Цена', 4),
(5,'Служебные даты', 3),
(6,'Важные даты', 3);

INSERT INTO film_attributes_values (id, attribute_id, film_id, review, premium, price, important_dates, service_dates) VALUES
(1,1, 1, NULL, NULL, NULL, NULL, NULL),
(2,2, 1, 'Жизненно', NULL, NULL, NULL, NULL),
(3,3, 1, NULL, 'Золотой орел', NULL, NULL, NULL),
(4,4, 1, NULL, NULL, '100.45', NULL, NULL),
(5,5, 1, NULL, NULL, NULL, CURRENT_DATE , NULL),
(6,6, 1, NULL, NULL, NULL, NULL, CURRENT_DATE);

INSERT INTO film_attributes_values (id, attribute_id, film_id, review, premium, price, important_dates, service_dates) VALUES
(7,1, 2, NULL, NULL, NULL, NULL, NULL),
(8,2, 2, 'Весело', NULL, NULL, NULL, NULL),
(9,3, 2, NULL, 'Оскар', NULL, NULL, NULL),
(10,4, 2, NULL, NULL, '200', NULL, NULL),
(11,5, 2, NULL, NULL, NULL, CURRENT_DATE + interval '20 days', NULL),
(12,6, 2, NULL, NULL, NULL, NULL, CURRENT_DATE + interval '20 days');

INSERT INTO film_attributes_values (id, attribute_id, film_id, review, premium, price, important_dates, service_dates) VALUES
(13,1, 3, NULL, NULL, NULL, NULL, NULL),
(14,2, 3, 'Боевой фильм', NULL, NULL, NULL, NULL),
(15,3, 3, NULL, 'Золотой глобус', NULL, NULL, NULL),
(16,4, 3, NULL, NULL, '150.25', NULL, NULL),
(17,5, 3, NULL, NULL, NULL, CURRENT_DATE + interval '10 days', NULL),
(18,6, 3, NULL, NULL, NULL, NULL, CURRENT_DATE + interval '11 days');

INSERT INTO film_attributes_values (id, attribute_id, film_id, review, premium, price, important_dates, service_dates) VALUES
(19,1, 4, NULL, NULL, NULL, NULL, NULL),
(20,2, 4, 'Птичку жалко', NULL, NULL, NULL, NULL),
(21,3, 4, NULL, 'Золотой глобус', NULL, NULL, NULL),
(22,4, 4, NULL, NULL, '100', NULL, NULL),
(23,5, 4, NULL, NULL, NULL, CURRENT_DATE + interval '8 days', NULL),
(24,6, 4, NULL, NULL, NULL, NULL, CURRENT_DATE + interval '9 days');

INSERT INTO film_attributes_values (id, attribute_id, film_id, review, premium, price, important_dates, service_dates) VALUES
(25,1, 5, NULL, NULL, NULL, NULL, NULL),
(26,2, 5, 'Гениальный план', NULL, NULL, NULL, NULL),
(27,3, 5, NULL, 'Оскар', NULL, NULL, NULL),
(28,4, 5, NULL, NULL, '200', NULL, NULL),
(29,5, 5, NULL, NULL, NULL, CURRENT_DATE + interval '10 days', NULL),
(30,6, 5, NULL, NULL, NULL, NULL, CURRENT_DATE + interval '10 days');
