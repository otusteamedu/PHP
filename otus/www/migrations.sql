CREATE SEQUENCE guest_ids;
CREATE TABLE guests
(
    id INTEGER PRIMARY KEY DEFAULT NEXTVAL('guest_ids'),
    name CHAR(64) NOT NULL
);

CREATE SEQUENCE cinema_halls_ids;
CREATE TABLE cinema_halls
(
    id INTEGER PRIMARY KEY DEFAULT NEXTVAL('cinema_halls_ids'),
    name CHAR(64) NOT NULL
);

CREATE SEQUENCE genres_ids;
CREATE TABLE genres
(
    id INTEGER PRIMARY KEY DEFAULT NEXTVAL('genres_ids'),
    name CHAR(64) NOT NULL
);

CREATE SEQUENCE films_ids;
CREATE TABLE films
(
    id INTEGER PRIMARY KEY DEFAULT NEXTVAL('films_ids'),
    name CHAR(64)                  NOT NULL,
    genre_id integer NOT NULL,
    FOREIGN KEY (genre_id) REFERENCES genres (id)
);

CREATE SEQUENCE tickets_ids;
CREATE TABLE tickets
(
    id INTEGER PRIMARY KEY DEFAULT NEXTVAL('tickets_ids'),
    price integer                  NOT NULL,
    number integer                  NOT NULL,
    film_id integer NOT NULL,
    FOREIGN KEY (film_id) REFERENCES films (id)
);

CREATE SEQUENCE tickets_users_ids;
CREATE TABLE tickets_users_pivot
(
    id INTEGER PRIMARY KEY DEFAULT NEXTVAL('tickets_users_ids'),
    guest_id  integer NOT NULL,
    ticket_id integer NOT NULL,
    FOREIGN KEY (guest_id) REFERENCES guests (id),
    FOREIGN KEY (ticket_id) REFERENCES tickets (id)
);

CREATE SEQUENCE session_ids;
CREATE TABLE sessions
(
    id INTEGER PRIMARY KEY DEFAULT NEXTVAL('session_ids'),
    session_start TIMESTAMP NOT NULL,
    session_close TIMESTAMP NOT NULL,
    film_id integer NOT NULL,
    FOREIGN KEY (film_id) REFERENCES films (id)
);

CREATE SEQUENCE schedule_ids;
CREATE TABLE schedules
(
    id INTEGER PRIMARY KEY DEFAULT NEXTVAL('schedule_ids'),
    cinema_halls_id integer NOT NULL,
    session_id integer NOT NULL,
    FOREIGN KEY (session_id) REFERENCES sessions (id),
    FOREIGN KEY (cinema_halls_id) REFERENCES cinema_halls (id)
);
