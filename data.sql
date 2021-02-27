insert into cinema.customers (id, name)
values  (DEFAULT, 'JJ');

insert into cinema.halls (id, name)
values  (DEFAULT, 'Hall #1'),
        (DEFAULT, 'Hall #2');

insert into cinema.movies (id, name)
values  (DEFAULT, 'Avengers'),
        (DEFAULT, 'GoTo'),
        (DEFAULT, 'GreenBook');

insert into cinema.seats_type (id, code)
values  (DEFAULT, 'vip'),
        (DEFAULT, 'common'),
        (DEFAULT, 'comfort');

insert into cinema.seances (id, end_at, start_at, movie_id, hall_id)
values  (DEFAULT, '2021-02-27 15:29:56', '2021-02-27 15:30:06', 1, 1),
        (DEFAULT, '2021-02-27 15:29:56', '2021-02-27 15:30:06', 1, 2),
        (DEFAULT, '2021-02-27 15:29:56', '2021-02-27 15:30:06', 2, 2),
        (DEFAULT, '2021-02-27 15:29:56', '2021-02-27 15:30:06', 3, 2),
        (DEFAULT, '2021-02-27 15:29:56', '2021-02-27 15:30:06', 3, 1);

insert into cinema.seats (id, row, number, hall_id, type_id)
values  (DEFAULT, 1, 1, 1, 1),
        (DEFAULT, 1, 2, 1, 1),
        (DEFAULT, 1, 3, 1, 1),
        (DEFAULT, 2, 1, 1, 2),
        (DEFAULT, 2, 2, 1, 2),
        (DEFAULT, 2, 3, 1, 2),
        (DEFAULT, 3, 1, 1, 3),
        (DEFAULT, 3, 2, 1, 3),
        (DEFAULT, 3, 3, 1, 3),
        (DEFAULT, 3, 3, 2, 3),
        (DEFAULT, 3, 3, 2, 3),
        (DEFAULT, 3, 3, 2, 3),
        (DEFAULT, 3, 3, 2, 3),
        (DEFAULT, 3, 3, 2, 3),
        (DEFAULT, 3, 3, 2, 3),
        (DEFAULT, 3, 3, 2, 3),
        (DEFAULT, 3, 3, 2, 3),
        (DEFAULT, 3, 3, 2, 3);

insert into cinema.seats_price (id, seance_id, seat_type_id, price)
values  (DEFAULT, 1, 1, 700),
        (DEFAULT, 1, 2, 300),
        (DEFAULT, 1, 3, 500),
        (DEFAULT, 2, 3, 490),
        (DEFAULT, 2, 2, 330),
        (DEFAULT, 2, 1, 650),
        (DEFAULT, 3, 3, 1000),
        (DEFAULT, 3, 1, 1500),
        (DEFAULT, 3, 2, 700),
        (DEFAULT, 4, 1, 1000),
        (DEFAULT, 4, 2, 500),
        (DEFAULT, 4, 3, 702),
        (DEFAULT, 5, 1, 900),
        (DEFAULT, 5, 2, 300),
        (DEFAULT, 5, 3, 400);

insert into cinema.tickets (id, seat_id, seance_id, customer_id)
values  (DEFAULT, 1, 1, 1),
        (DEFAULT, 2, 1, 1),
        (DEFAULT, 6, 1, 1),
        (DEFAULT, 8, 5, 1),
        (DEFAULT, 12, 4, 1),
        (DEFAULT, 6, 5, 1),
        (DEFAULT, 18, 3, 1),
        (DEFAULT, 15, 3, 1),
        (DEFAULT, 11, 3, 1);