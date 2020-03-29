drop table if exists hall CASCADE;
create table hall
(
    id   SERIAL PRIMARY KEY,
    name varchar NOT NULL
);

drop table if exists film CASCADE;
create table film
(
    id            SERIAL PRIMARY KEY,
    name          varchar NOT NULL,
    description   text    NOT NULL,
    country       varchar NOT NULL,
    preview_image varchar NOT NULL,
    release_date  date    NOT NULL,
    runtime       int     NOT NULL
);

drop table if exists session CASCADE;
create table session
(
    id             SERIAL PRIMARY KEY,
    start_datetime timestamp     not null,
    hall_id        int REFERENCES hall (id) ON DELETE RESTRICT,
    film_id        int REFERENCES film (id) ON DELETE RESTRICT,
    price          numeric(5, 2) not null
);

drop table if exists ticket;
create table ticket
(
    id         SERIAL PRIMARY KEY,
    session_id int REFERENCES session (id) ON DELETE RESTRICT
);


-- Данные для демонстрации и проверки скрипта подсчета самого прибыльного фильма
insert into hall (name)
values ('Первый зал'),
       ('Второй зал');

insert into film (name, description, country, preview_image, release_date, runtime)
values ('Бойцовский клуб', 'Бойцовский клуб описание...', 'США', 'https://...', '1999-01-01', 139),
       ('Идентификация Борна', 'Идентификация Борна описание...', 'США', 'https://...', '2017-06-24', 113);

insert into session (start_datetime, hall_id, film_id, price)
VALUES ('2020-03-28 11:00:00.000000', 1, 1, 200.00),
       ('2020-03-28 14:30:02.000000', 2, 1, 200.00),
       ('2020-03-28 17:45:02.000000', 1, 2, 300.00),
       ('2020-03-28 20:10:02.000000', 2, 2, 300.00);

insert into ticket (session_id)
values (1),
       (1),
       (1),
       (2),
       (3),
       (4);