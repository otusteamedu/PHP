insert into film (name, duration) values ('Терминатор', '01:20:00');
insert into film (name, duration) values ('Кинг-Конг', '01:35:00');

insert into hall (name, seats) values ('Зал №1', 500);
insert into hall (name, seats) values ('Зал №2', 300);

insert into customer (name) values ('Федор');
insert into customer (name) values ('Михаил');

insert into seance_type (name, seance_time, price) values ('Утренний 10', '10:00:00', 100);
insert into seance_type (name, seance_time, price) values ('Утренний 14', '14:00:00', 150);
insert into seance_type (name, seance_time, price) values ('Утренний 18', '18:00:00', 250);
insert into seance_type (name, seance_time, price) values ('Утренний 22', '22:00:00', 350);

insert into seance (film_id, hall_id, seance_type_id, seance_date) values (1, 1, 1, '2019-04-01');
insert into seance (film_id, hall_id, seance_type_id, seance_date) values (1, 1, 2, '2019-04-01');
insert into seance (film_id, hall_id, seance_type_id, seance_date) values (1, 1, 3, '2019-04-01');
insert into seance (film_id, hall_id, seance_type_id, seance_date) values (1, 1, 4, '2019-04-01');
insert into seance (film_id, hall_id, seance_type_id, seance_date) values (2, 2, 1, '2019-04-01');
insert into seance (film_id, hall_id, seance_type_id, seance_date) values (2, 2, 2, '2019-04-01');
insert into seance (film_id, hall_id, seance_type_id, seance_date) values (2, 2, 3, '2019-04-01');
insert into seance (film_id, hall_id, seance_type_id, seance_date) values (2, 2, 4, '2019-04-01');

insert into ticket (customer_id, seance_id, purchase_date, seat) values (1, 3, '2019-04-01 09:00:00', 1);
insert into ticket (customer_id, seance_id, purchase_date, seat) values (2, 3, '2019-04-01 09:00:00', 2);
insert into ticket (customer_id, seance_id, purchase_date, seat) values (1, 8, '2019-04-01 09:00:00', 3);
insert into ticket (customer_id, seance_id, purchase_date, seat) values (2, 8, '2019-04-01 09:00:00', 4);
