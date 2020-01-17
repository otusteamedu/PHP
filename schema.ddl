create table if not exists movies
(
    id       serial                   not null primary key,
    title    varchar(255) default ''::character varying,
    duration integer      default 120 not null
);
comment on table movies is 'Фильмы';
comment on column movies.id is 'Идентификатор фильма';
comment on column movies.title is 'Название фильма';
comment on column movies.duration is 'Продолжительность фильма в минутах';

create table if not exists movies_attributes_types
(
    id   smallserial       not null primary key,
    name varchar(127)      not null,
    max  integer default 0 not null,
    min  integer default 0 not null
);

comment on column movies_attributes_types.max is 'ограничение значения атрибута сверху (кол-во символов, число, дата и т.п.)';
comment on column movies_attributes_types.min is ' ограничение значения атрибута снизу (кол-во символов, число, дата и т.п.)';


create table if not exists movies_attributes
(
    id      smallserial  not null primary key,
    name    varchar(255) not null,
    type_id integer      not null
        constraint attribute_type_id references movies_attributes_types on update cascade on delete cascade
);

create table if not exists movies_attributes_values
(
    id           bigserial not null primary key,
    id_attribute integer   not null
        constraint movie_attribute_id references movies_attributes on update cascade on delete cascade,
    id_movie     integer   not null
        constraint movie_id references movies on update cascade on delete cascade,
    as_text      text,
    as_bool      boolean,
    as_date      date,
    as_int       bigint,
    as_dec       decimal(10, 2),
    as_float     double precision
);

create table if not exists halls
(
    id               serial                          not null
        constraint hall_id primary key,
    title            varchar(255) default ''::bpchar not null,
    lines_count      integer      default 20         not null,
    line_seats_count integer      default 40         not null
);
comment on table halls is 'Залы кинотеатра';
comment on column halls.id is 'Индентификатор зала';
comment on column halls.title is 'Название зала';
comment on column halls.lines_count is 'Кол-во рядов кресел в зале';
comment on column halls.line_seats_count is 'Кол-во кресел в каждом ряду';

create table if not exists sessions
(
    id       serial  not null primary key,
    hall_id  integer not null
        constraint sessions_halls_id references halls on update cascade on delete restrict,
    movie_id integer not null
        constraint sessions_movies_id_fk references movies on update cascade on delete cascade,
    date     date    not null,
    time     char(5) not null
);
comment on table sessions is 'Сеансы показа фильмов';
comment on column sessions.id is 'Идентификатор сеанса';
comment on column sessions.hall_id is 'Идентификатор зала, в котором проводится сеанс показа фильма';
comment on column sessions.movie_id is 'Идентификатор показываемого фильма';
comment on column sessions.date is 'Дата сеанса';
comment on column sessions.time is 'Время начала сеанса';

create table if not exists tickets
(
    id          serial                      not null primary key,
    session_id  integer                     not null
        constraint tickets_sessions_id_fk
            references sessions
            on update cascade on delete restrict,
    seat_number integer                     not null,
    line_number integer                     not null,
    price       decimal(10, 2) default 0.00 not null
);
comment on table tickets is 'Проданные билеты на сеансы';
comment on column tickets.session_id is 'Идентификатор сеанса';
comment on column tickets.seat_number is 'Номер места в ряду';
comment on column tickets.line_number is 'Номер ряда';
comment on column tickets.price is 'Цена билета в копейках';

create unique index unique_ticket
    on tickets (session_id desc, line_number asc, seat_number asc);