insert into film (name, duration) values ('Терминатор', '01:20:00');
insert into film (name, duration) values ('Кинг-Конг', '01:35:00');

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
