CREATE TABLE seances
(
    id       serial        not null
        constraint seances_pkey primary key,
    hall_id  integer       not null REFERENCES halls,
    film_id  integer       not null REFERENCES films,
    price    decimal(8, 2) not null,
    start_at timestamp     not null
);

CREATE INDEX seances_hall_id_idx ON seances (hall_id);
CREATE INDEX seances_film_id_idx ON seances (film_id);
