insert into halls (name)
values ('Зал 1'), ('Зал 2'), ('Зал 3'), ('Зал 4'), ('Зал 5'),
       ('Зал 6'), ('Зал 7'), ('Зал 8'), ('Зал 9'), ('Зал 10');

insert into movies (name)
values ('Бэтмен'), ('Бэтмен и Робин'), ('Бэтмен возвращается'),
       ('Бэтмен убивает бурундука'), ('Бурундуки убивают Бэтмена');

insert into movie_attrs (name, type)
values ('review', 'text'),          -- 1
       ('award_oskar', 'bool'),     -- 2
       ('award_nika', 'bool'),      -- 3
       ('premiere_world', 'date'),  -- 4
       ('premiere_russia', 'date'), -- 5
       ('sales_start', 'date'),     -- 6
       ('advert_start', 'date'),    -- 7
       ('advert_budget', 'numeric') -- 8
;

insert into movie_values (movie_id, attr_id, date, bool, text, numeric)
values (1, 1, null, null, 'abrakadabra', null),
       (1, 2, null, true, null, null),
       (1, 7, '2020-06-12 14:00', null, null, null),
       (1, 8, null, null, null, 1000000),
       (2, 6, current_date + interval '10 hour', null, null, null),
       (2, 7, current_date + interval '2 hour', null, null, null),
       (3, 6, current_date + interval '10 day 2 hour', null, null, null),
       (3, 7, current_date + interval '2 hour', null, null, null)
;

insert into shows (movie_id, hall_id, start_at, end_at, status)
values (1, 1, '2020-12-12 12:00', '2020-12-12 14:00', 'actual'),
       (2, 1, '2020-12-14 12:00', '2020-12-14 14:00', 'actual');

insert into clients (name, email)
values ('john doe', 'example@example.com');

call seed_seats(1, 100, 100);
call seed_seats(2, 100, 100);

