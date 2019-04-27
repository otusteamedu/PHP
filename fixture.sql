insert into film (name) values ('Терминатор');
insert into film (name) values ('Кинг-Конг');

insert into attribute_type (name) values ('integer');
insert into attribute_type (name) values ('time');
insert into attribute_type (name) values ('date');
insert into attribute_type (name) values ('timestamp');
insert into attribute_type (name) values ('text');
insert into attribute_type (name) values ('boolean');

insert into attribute_value (time_value) values ('01:20:00');
insert into attribute_value (time_value) values ('01:45:00');
insert into attribute_value (text_value) values ('Рецензия на фильм Терминатор');
insert into attribute_value (text_value) values ('Рецензия на фильм Кинг-Конг');
insert into attribute_value (boolean_value) values (true);
insert into attribute_value (boolean_value) values (false);
insert into attribute_value (date_value) values ('2010-05-01');
insert into attribute_value (date_value) values ('2010-07-01');
insert into attribute_value (date_value) values ('2014-03-01');
insert into attribute_value (date_value) values ('2014-06-01');
insert into attribute_value (date_value) values ('2010-04-01');
insert into attribute_value (date_value) values ('2014-06-01');
insert into attribute_value (text_value) values ('Продажа билетов');
insert into attribute_value (text_value) values ('Расклейка афиш');
insert into attribute_value (text_value) values ('Анализ отзывов в соц. сетях');
insert into attribute_value (text_value) values ('Подготовка залов');

insert into attribute (name, attribute_type_id) values ('Длительность', 2);
insert into attribute (name, attribute_type_id) values ('Рецензия', 5);
insert into attribute (name, attribute_type_id) values ('Премия Ника', 6);
insert into attribute (name, attribute_type_id) values ('Премия Оскар', 6);
insert into attribute (name, attribute_type_id) values ('Мировая премьера', 3);
insert into attribute (name, attribute_type_id) values ('Премьера в РФ', 3);
insert into attribute (name, attribute_type_id) values ('Запуск рекламы на ТВ', 3);
insert into attribute (name, attribute_type_id) values ('Задачи на 2019-04-01', 5);
insert into attribute (name, attribute_type_id) values ('Задачи на 2019-04-20', 5);

insert into film_attribute (film_id, attribute_id, attribute_value_id) values (1, 1, 1);
insert into film_attribute (film_id, attribute_id, attribute_value_id) values (2, 1, 2);
insert into film_attribute (film_id, attribute_id, attribute_value_id) values (1, 2, 3);
insert into film_attribute (film_id, attribute_id, attribute_value_id) values (2, 2, 4);
insert into film_attribute (film_id, attribute_id, attribute_value_id) values (1, 3, 5);
insert into film_attribute (film_id, attribute_id, attribute_value_id) values (2, 4, 5);
insert into film_attribute (film_id, attribute_id, attribute_value_id) values (2, 4, 6);
insert into film_attribute (film_id, attribute_id, attribute_value_id) values (1, 5, 7);
insert into film_attribute (film_id, attribute_id, attribute_value_id) values (1, 6, 8);
insert into film_attribute (film_id, attribute_id, attribute_value_id) values (2, 5, 9);
insert into film_attribute (film_id, attribute_id, attribute_value_id) values (2, 6, 10);
insert into film_attribute (film_id, attribute_id, attribute_value_id) values (1, 7, 11);
insert into film_attribute (film_id, attribute_id, attribute_value_id) values (2, 7, 12);
insert into film_attribute (film_id, attribute_id, attribute_value_id) values (1, 8, 13);
insert into film_attribute (film_id, attribute_id, attribute_value_id) values (1, 8, 14);
insert into film_attribute (film_id, attribute_id, attribute_value_id) values (1, 8, 16);
insert into film_attribute (film_id, attribute_id, attribute_value_id) values (2, 8, 13);
insert into film_attribute (film_id, attribute_id, attribute_value_id) values (1, 9, 15);
insert into film_attribute (film_id, attribute_id, attribute_value_id) values (2, 9, 16);

insert into hall (name, seats) values ('Зал №1', 500);
insert into hall (name, seats) values ('Зал №2', 300);

insert into customer (name) values ('Федор');
insert into customer (name) values ('Михаил');

insert into seance (film_id, hall_id, seance_time, price) values (1, 1, '2019-04-01 10:00:00', 100);
insert into seance (film_id, hall_id, seance_time, price) values (1, 1, '2019-04-01 14:00:00', 150);
insert into seance (film_id, hall_id, seance_time, price) values (1, 1, '2019-04-01 18:00:00', 200);
insert into seance (film_id, hall_id, seance_time, price) values (1, 1, '2019-04-01 22:00:00', 300);
insert into seance (film_id, hall_id, seance_time, price) values (2, 2, '2019-04-02 10:00:00', 100);
insert into seance (film_id, hall_id, seance_time, price) values (2, 2, '2019-04-02 14:00:00', 150);
insert into seance (film_id, hall_id, seance_time, price) values (2, 2, '2019-04-02 18:00:00', 200);
insert into seance (film_id, hall_id, seance_time, price) values (2, 2, '2019-04-02 22:00:00', 300);

insert into ticket (customer_id, seance_id, purchase_date, seat) values (1, 3, '2019-04-01 09:00:00', 1);
insert into ticket (customer_id, seance_id, purchase_date, seat) values (2, 3, '2019-04-01 09:01:00', 2);
insert into ticket (customer_id, seance_id, purchase_date, seat) values (1, 8, '2019-04-02 18:00:00', 3);
insert into ticket (customer_id, seance_id, purchase_date, seat) values (2, 8, '2019-04-02 18:01:00', 4);
