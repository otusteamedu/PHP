create sequence halls_id_seq;

alter sequence halls_id_seq owner to postgres;

create table if not exists users
(
    id serial not null
        constraint users_pkey
            primary key,
    username varchar(50) not null,
    password varchar(50) not null,
    email varchar(255) not null
        constraint users_email_key
            unique,
    created_on timestamp not null,
    last_login timestamp
);

alter table users owner to postgres;

create table if not exists halls
(
    id integer not null
        constraint halls_pk
            primary key,
    capacity integer not null
        constraint capacity
            check ((capacity > 0) AND (capacity <= 1000)),
    number integer
);

alter table halls owner to postgres;

create table if not exists places
(
    id serial not null
        constraint places_pk
            primary key,
    row integer default 0 not null,
    "column" integer default 0 not null,
    hall_id integer
);

alter table places owner to postgres;

create table if not exists films
(
    id serial not null
        constraint films_pk
            primary key,
    name varchar,
    year integer not null,
    country varchar
);

alter table films owner to postgres;

create table if not exists films_schedule
(
    id serial not null
        constraint films_schedule_pk
            primary key,
    price real default 0 not null,
    hall_id integer not null
        constraint films_halls_id_fk
            references halls,
    started_at timestamp,
    finished_at timestamp,
    film_id integer not null
        constraint films_schedule_films_id_fk
            references films
);

alter table films_schedule owner to postgres;

create table if not exists tickets
(
    place_id integer not null
        constraint tickets_places_id_fk
            references places,
    user_id integer
        constraint tickets_users_id_fk
            references users,
    film_schedule_id integer
        constraint tickets_films_schedule_id_fk
            references films_schedule,
    id serial not null
        constraint tickets_pk
            primary key
);

alter table tickets owner to postgres;

