-- truncate halls, movies, seats, shows cascade;
insert into halls (name)
values ('Основной зал');

insert into movies (name)
values ('Бэтмен'),
       ('Бэтмен и Робин');

insert into shows (movie_id, hall_id, start_at, end_at, actual)
values (1, 1, '2020-12-12 12:00', '2020-12-12 14:00', true);
insert into shows (movie_id, hall_id, start_at, end_at, actual)
values (2, 1, '2020-12-14 12:00', '2020-12-14 14:00', true);

insert into seats (hall_id, row_name, set_name)
values (1, '1', '1'),
       (1, '1', '2'),
       (1, '2', '1'),
       (1, '2', '2')
;

insert into show_seats (cost, show_id, seat_id)
values (100, 1, 1),
       (100, 1, 2),
       (100, 1, 3),
       (100, 1, 4),
       (100, 2, 1),
       (100, 2, 2),
       (100, 2, 3),
       (100, 2, 4)
;

insert into clients (name, email)
values ('john doe', 'example@example.com');

insert into orders (client_id, deadline_at)
values (1, null);

insert into tickets (cost, order_id, show_id, seat_id, paid_at, actual, canceled_at)
values (100, 1, 1, 1, '2020-10-01 12:00', true, null),
       (100, 1, 1, 2, '2020-10-01 12:00', true, null),
       (100, 1, 2, 1, '2020-10-01 12:00', true, null)
;
