create table films
(
    id varchar(36) not null
        constraint films_pk
            primary key,
    name varchar(255),
    production_year integer not null
);

create table attr_types
(
    id varchar(36) not null
        constraint attr_types_pk
            primary key,
    name varchar(50) not null unique
);

create table films_attrs
(
    id varchar(36) not null
        constraint films_attrs_pk
            primary key,
    name varchar(100) not null unique,
    type_id varchar(36) not null
        constraint films_attrs_fk
            references attr_types
            on update cascade
);

create table films_attrs_values
(
    id varchar(36) not null
        constraint films_attrs_values_pk
            primary key,
    film_id varchar(36) not null
        constraint films_attrs_values_film_id_fk
            references films
            on update cascade on delete cascade,
    attr_id varchar(36) not null
        constraint films_attrs_values_attr_id_fk
            references films_attrs
            on update cascade,
    value_float double precision,
    value_date timestamp,
    value_text text,
    value_bool boolean,
    value_int integer,
    unique (film_id, attr_id)
);
