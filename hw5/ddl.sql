CREATE
EXTENSION IF NOT EXISTS "uuid-ossp";

CREATE TABLE cinemas
(
    id    INT GENERATED ALWAYS AS IDENTITY,
    title VARCHAR(255) NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE halls
(
    id        INT GENERATED ALWAYS AS IDENTITY,
    cinema_id INT,
    number    INT          NOT NULL,
    title     VARCHAR(255) NOT NULL,
    PRIMARY KEY (id),
    CONSTRAINT cinema_hall_to_cinema
        FOREIGN KEY (cinema_id)
            REFERENCES cinemas (id)
);

CREATE TABLE sessions
(
    id         INT GENERATED ALWAYS AS IDENTITY,
    hall_id    INT          NOT NULL,
    title      VARCHAR(255) NOT NULL,
    start_time timestamp    not null,
    end_time   timestamp    not null,
    PRIMARY KEY (id),
    CONSTRAINT movie_session_to_hall
        FOREIGN KEY (hall_id)
            REFERENCES halls (id)
);

CREATE TABLE movies
(
    id     INT GENERATED ALWAYS AS IDENTITY,
    title  varchar(255) NOT NULL,
    slogan varchar(255),
    PRIMARY KEY (id)
);

CREATE TABLE session_to_movie_pivot
(
    id         INT GENERATED ALWAYS AS IDENTITY,
    session_id INT NOT NULL,
    movie_id   INT NOT null,
    PRIMARY KEY (id),
    CONSTRAINT session_pivot_to_session
        FOREIGN KEY (session_id)
            REFERENCES sessions (id),
    CONSTRAINT movie_pivot_to_movie
        FOREIGN KEY (movie_id)
            REFERENCES movies (id)
);

CREATE TABLE tickets
(
    id                INT GENERATED ALWAYS AS IDENTITY,
    session_id        INT,
    ticket_identifier uuid default uuid_generate_v4(),
    price             INT  default 0,
    PRIMARY KEY (id),
    CONSTRAINT ticket_to_session
        FOREIGN KEY (session_id)
            REFERENCES sessions (id)
);
