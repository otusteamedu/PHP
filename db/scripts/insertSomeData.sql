-- вставляем некоторые данные
insert into attribute_type (name) values ('text'),('int'),('float'),('date'),('bool');
insert into attribute_type_prop (name, value, attribute_type_id) values ('author', 'Главный критик', 1),('author', 'Неизвестный критик', 1),('CountAfterDot', 2, 3),('CountBeforeDot', 4, 3);
insert into "attribute" (id, name, showname, attribute_type_id) values (1,'review', 'Рецензия', 1),(2,'prize','Премия', 1),(3,'date_of_premier', 'Дата премьеры', 4),(4,'date_of_strart_sale_tickets', 'Начало продаж билетов', 4),(5,'3D', 'Формат 3D', 5),(6,'task','Задача',1);

insert into attribute_value (attribute_id, movie_id, value_text) values (1,1, 'Моя главная рецензия на фильм');
insert into attribute_value (attribute_id, movie_id, value_text) values (1,1,'"Неизвестная рецензия на фильм');
insert into attribute_value (attribute_id, movie_id, value_date) values (3,1,'2020-04-21 21:00');
insert into attribute_value (attribute_id, movie_id, value_date) values (4,1,'2020-04-21 11:00');
insert into attribute_value (attribute_id, movie_id, value_bool) values (5,1,'true');
insert into attribute_value (attribute_id, movie_id, value_text, value_bool) values (1,1,'Незначительная ремарка','true');
insert into attribute_value (attribute_id, movie_id, value_text) values (2,1, 'Оскар');
insert into attribute_value (attribute_id, movie_id, value_text, value_date) values (6,1, 'Провести презентацию в фое', '2021-04-01');
insert into attribute_value (attribute_id, movie_id, value_text, value_date) values (6,1, 'Провести красочное закрытие фильма', '2021-04-21');
