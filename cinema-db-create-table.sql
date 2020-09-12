/* Таблица залов */
CREATE TABLE halls
(
    id         integer PRIMARY KEY,
    name       text,
    site_count integer
);

/* Таблица фильмов */
CREATE TABLE films
(
    id   integer PRIMARY KEY,
    name text
);

/* Таблица сеансов, на которых показывают фильмы */
CREATE TABLE sessions
(
    id            integer PRIMARY KEY,
    halls_id      integer REFERENCES halls (id),
    film_id       integer REFERENCES films (id),
    sessions_time date,
    price         money
);

/* Билеты на сеансы */
CREATE TABLE tickets
(
    id             integer PRIMARY KEY,
    sessions_id    integer REFERENCES sessions (id),
    sold           boolean,
    site_number    integer
);



