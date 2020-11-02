/* Таблица залов */
CREATE TABLE halls
(
    id         serial PRIMARY KEY,
    name       text,
    site_count integer
);

/* Таблица фильмов */
CREATE TABLE films
(
    id   serial PRIMARY KEY,
    name text
);

/* Таблица сеансов, на которых показывают фильмы */
CREATE TABLE sessions
(
    id            serial PRIMARY KEY,
    halls_id      integer REFERENCES halls (id),
    film_id       integer REFERENCES films (id),
    sessions_date date,
    sessions_time time,
    price         money
);

/* Билеты на сеансы */
CREATE TABLE tickets
(
    id          serial PRIMARY KEY,
    sessions_id integer REFERENCES sessions (id),
    sold        boolean,
    site_number integer
);

create table attributes
(
    id       serial PRIMARY KEY,
    films_id integer REFERENCES films (id),
    name     text
);

create table attributes_type
(
    id              serial PRIMARY KEY,
    attributes_id   integer REFERENCES attributes (id),
    attributes_type text
);

create table attributes_value
(
    id                 serial PRIMARY KEY,
    attributes_type_id integer REFERENCES attributes_type (id),
    film_id            integer REFERENCES films (id),
    attributes_text    text,
    attributes_integer integer,
    attributes_float   float,
    attributes_data    date
);

create view system_data as
select f.name, a.name, av.attributes_text
from films as f
         inner join attributes a on f.id = a.films_id
         inner join attributes_value av on f.id = av.film_id
where a.name = 'current_task'
   OR (a.name = 'future_task' AND av.attributes_data = (current_date + integer '20'))
group by f.name;

create view market_data as
select f.name, a.name, av.attributes_text, av.attributes_data
from films as f
         inner join attributes a on f.id = a.films_id
         inner join attributes_value av on f.id = av.film_id
where a.name LIKE ['жанр', 'дата премьеры', 'рейтинг']
group by f.name;