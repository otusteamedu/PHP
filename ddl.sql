create table if not exists movies
(
    id          serial primary key,
    name        char(255) not null,
    duration    int,
    age_limit   int       not null,
    description text
);

-- поиск будет проходить в основном по названию фильма
create index movies_name_index on movies (name);

create table if not exists halls
(
    id             serial primary key,
    number         char(8) not null unique,
    max_moviegoers int     not null,
    floor          int
);

-- поиск будет проходить в основном по номеру зала
create index halls_number_index on halls (number);

create table if not exists moviegoer_types
(
    id   serial primary key,
    name char(60)
);

create table tariffs
(
    id   serial primary key,
    name varchar,
    discount float default(0)
);

create table if not exists prices
(
    id                serial primary key,
    price             float not null check ( price >= 0 ),
    tariff_id         integer references tariffs,
    moviegoer_type_id integer references moviegoer_types
);

create table if not exists schedule
(
    id                serial primary key,
    movie_id          integer references movies,
    hall_id           integer references halls,
    price_id          integer references prices,
    start_time        integer not null, --unix_timestamp буду юзать
    unique (hall_id, start_time)        -- комбинация hall_id и start_time должна быть уникальной
);

create index schedule_index on schedule (movie_id, hall_id, start_time);

create table if not exists moviegoers
(
    id        serial primary key,
    phone     integer,
    email     char(180),
    hash_code char(250) unique not null
);

create index moviegoers_hash_code_index on moviegoers (hash_code);

create table if not exists seats
(
    id            serial primary key,
    unique_number char(128) not null,
    position      integer   not null,
    hall_id       integer references halls,
    unique (unique_number, hall_id)
);

create table if not exists tickets
(
    id           serial primary key,
    schedule_id  integer        not null references schedule,
    moviegoer_id integer        not null references moviegoers,
    seat_id      integer        not null references seats,
    number       integer unique not null,
    status       integer default 1,    -- будут статусы типа 1 активный 2 использован 3 заблокирован и тд
    unique (moviegoer_id, schedule_id) -- комбинация moviegoer_id и schedule_id должна быть уникальной
);

create index tickets_number_index on tickets (schedule_id, moviegoer_id, number);

insert into movies(name, duration, age_limit, description)
select 'tenet-1' || random()::text, 5400, 16, random()::text
from generate_series(1, 10);

CREATE OR REPLACE FUNCTION random_between(low INT, high INT)
    RETURNS INT AS
$$
BEGIN
    RETURN floor(random() * (high - low + 1) + low);
END;
$$ language 'plpgsql' STRICT;

insert into halls(number, max_moviegoers, floor)
select 'num-' || random_between(1, 100), 50, random_between(1, 5)
from generate_series(1, 4);

insert into seats (unique_number, position, hall_id)
select gen_random_uuid(), position_num, 1
from generate_series(1, 20) as position_num;

insert into seats (unique_number, position, hall_id)
select gen_random_uuid(), position_num, 2
from generate_series(1, 20) as position_num;

insert into seats (unique_number, position, hall_id)
select gen_random_uuid(), position_num, 3
from generate_series(1, 20) as position_num;

insert into seats (unique_number, position, hall_id)
select gen_random_uuid(), position_num, 4
from generate_series(1, 20) as position_num;

insert into moviegoer_types(name)
values ('детский'),
       ('студенческий'),
       ('взрослый');

insert into tariffs(name) values ('tariff-1');
insert into tariffs(name) values ('tariff-2');
insert into tariffs(name) values ('tariff-3');

insert into prices(price, tariff_id, moviegoer_type_id) VALUES (200, 1, 1);
insert into prices(price, tariff_id, moviegoer_type_id) VALUES (400, 2, 2);
insert into prices(price, tariff_id, moviegoer_type_id) VALUES (600, 3, 3);

insert into schedule(movie_id, hall_id, price_id, start_time)
select m.id, h.id, 1, random_between(1609132499, 1609391699)
from movies m,
     halls h;

insert into moviegoers(hash_code)
select md5(random()::text)
from generate_series(1, 10);

insert into tickets(schedule_id, moviegoer_id, seat_id, number)
select sh.id, mg.id, seats.id, random_between(10000, 500000)
from (select id from schedule where id = 1) sh,
     (select id from moviegoers where id = 1) mg,
     (select id from seats where hall_id = 1) seats
limit 1;

insert into tickets(schedule_id, moviegoer_id, seat_id, number)
select sh.id, mg.id, seats.id, random_between(10000, 500000)
from (select id from schedule where id = 2) sh,
     (select id from moviegoers where id = 2) mg,
     (select id from seats where hall_id = 2) seats
limit 1;

insert into tickets(schedule_id, moviegoer_id, seat_id, number)
select sh.id, mg.id, seats.id, random_between(10000, 500000)
from (select id from schedule where id = 3) sh,
     (select id from moviegoers where id = 3) mg,
     (select id from seats where hall_id = 3) seats
limit 1;

insert into tickets(schedule_id, moviegoer_id, seat_id, number)
select sh.id, mg.id, seats.id, random_between(10000, 500000)
from (select id from schedule where id = 4) sh,
     (select id from moviegoers where id = 4) mg,
     (select id from seats where hall_id = 4) seats
limit 1;
