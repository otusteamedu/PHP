CREATE TABLE halls
(
    id         integer UNIQUE NOT NULL,
    name       text,
    site_count integer
);

CREATE TABLE sessions
(
    id            integer UNIQUE NOT NULL,
    halls_id      integer REFERENCES halls (id),
    name          text,
    sessions_time date
);

CREATE TABLE tickets
(
    id integer UNIQUE NOT NULL,
    sessions_id integer REFERENCES sessions(id),
    sold boolean,
    site_number integer
);