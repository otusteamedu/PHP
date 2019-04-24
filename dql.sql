create table film (
    id              serial primary key,
    name            varchar(255) unique not null,
    duration        time not null
);

create table hall (
    id              serial primary key,
    name            varchar(255) unique not null,
    seats           integer unique not null
);

create table customer (
    id              serial primary key,
    name            varchar(255) unique not null
);

create table seance_type (
    id              serial primary key,
    name            varchar(255) unique not null,
    seance_time     time not null,
    price           integer not null
);

create table seance (
    id              serial primary key,
    film_id         integer not null references film (id),
    hall_id         integer not null references hall (id),
    seance_type_id  integer not null references seance_type (id),
    seance_date     date not null
);

create table ticket (
    id              serial primary key,
    customer_id     integer not null references customer (id),
    seance_id       integer not null references seance (id),
    purchase_date   timestamp(0) not null,
    seat            integer not null
);
