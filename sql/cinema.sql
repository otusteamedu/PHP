-- CREATE

-- Залы кинотеатра
CREATE TABLE halls
(
    id serial,
    name varchar(30) NOT NULL,
    capacity smallint NOT NULL CHECK ( capacity > 0 ),

    CONSTRAINT "pk-halls-id"
        PRIMARY KEY (id)
);

-- Фильмы
CREATE TABLE movies
(
    id serial,
    name varchar(100) NOT NULL,
    description text,
    poster_path varchar(500) NOT NULL,

    CONSTRAINT "pk-movies-id"
        PRIMARY KEY (id)
);

-- Сеансы на фильмы
CREATE TABLE sessions
(
    id serial,
    hall_id int NOT NULL,
    movie_id int NOT NULL,
    start_at int NOT NULL,
    end_at int NOT NULL,
    price numeric(7, 2) NOT NULL CHECK ( price > 0 ),
    capacity smallint NOT NULL,
    tickets_count smallint DEFAULT 0,

    CONSTRAINT "pk-sessions-id"
        PRIMARY KEY (id),

    CONSTRAINT "fk-sessions-hall_id-hall-id"
        FOREIGN KEY (hall_id) REFERENCES halls (id)
            ON DELETE RESTRICT
            ON UPDATE RESTRICT,

    CONSTRAINT "fk-sessions-movie_id-movies-id"
        FOREIGN KEY (movie_id) REFERENCES movies (id)
            ON DELETE RESTRICT
            ON UPDATE RESTRICT
);

CREATE INDEX "idx-sessions-hall_id" ON sessions (hall_id);
CREATE INDEX "idx-sessions-movie_id" ON sessions (movie_id);

-- Билеты
CREATE TABLE tickets
(
    id serial,
    session_id int NOT NULL,
    price numeric(7, 2) NOT NULL CHECK ( price > 0 ),
    bought_at int NOT NULL,

    CONSTRAINT "pk-tickets-id"
        PRIMARY KEY (id),

    CONSTRAINT "fk-tickets-session_id-sessions-id"
        FOREIGN KEY (session_id) REFERENCES sessions (id)
            ON DELETE RESTRICT
            ON UPDATE RESTRICT
);

CREATE INDEX "idx-tickets-session_id" ON tickets (session_id);

-- UNDO

DROP TABLE halls;
DROP TABLE movies;
DROP TABLE sessions;
DROP TABLE tickets;
