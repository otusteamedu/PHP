#!/bin/bash
set -e

psql -v ON_ERROR_STOP=1 --username otus --dbname otus -c "
CREATE TABLE films
(
    id          serial      not null
        constraint films_pkey primary key,
    name        varchar(60) not null,
    description text        not null,
    duration    integer     not null,
    age_limit   smallint
);

CREATE TABLE seances
(
    id       serial        not null
        constraint seances_pkey primary key,
    film_id  integer       not null REFERENCES films,
    price    decimal(8, 2) not null,
    start_at timestamp     not null
);

CREATE INDEX seances_film_id_idx ON seances (film_id);
"
