create table film (
    id                  serial primary key,
    name                varchar(255) unique not null
);

create table attribute_type (
    id                  serial primary key,
    name                varchar(10) unique not null
);

create table attribute_value (
    id                  serial primary key,
    integer_value           integer,
    time_value          time,
    date_value          date,
    timestamp_value     timestamp(0),
    text_value          text,
    boolean_value       boolean
);

create table attribute (
    id                  serial primary key,
    name                varchar(255) unique not null,
    attribute_type_id   integer not null references attribute_type (id)
);

create table film_attribute (
    id                  serial primary key,
    film_id             integer not null references film (id),
    attribute_id        integer not null references attribute (id),
    attribute_value_id  integer not null references attribute_value (id)
);

create table hall (
    id                  serial primary key,
    name                varchar(255) unique not null,
    seats               integer unique not null
);

create table customer (
    id                  serial primary key,
    name                varchar(255) unique not null
);

create table seance (
    id                  serial primary key,
    film_id             integer not null references film (id),
    hall_id             integer not null references hall (id),
    seance_time         timestamp(0) not null,
    price               integer not null
);

create table ticket (
    id                  serial primary key,
    customer_id         integer not null references customer (id),
    seance_id           integer not null references seance (id),
    purchase_date       timestamp(0) not null,
    seat                integer not null
);
