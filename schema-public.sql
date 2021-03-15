DROP TABLE IF EXISTS "public"."halls" CASCADE;
DROP SEQUENCE IF EXISTS halls_id_seq;

DROP TABLE IF EXISTS "public"."movies" CASCADE;
DROP SEQUENCE IF EXISTS movies_id_seq;

DROP TABLE IF EXISTS "sessions" CASCADE;
DROP SEQUENCE IF EXISTS sessions_id_seq;

DROP TABLE IF EXISTS "tickets" CASCADE;
DROP SEQUENCE IF EXISTS tickets_id_seq;

DROP TABLE IF EXISTS "users" CASCADE;
DROP SEQUENCE IF EXISTS users_id_seq;

DROP TABLE IF EXISTS "users_tickets" CASCADE;
DROP SEQUENCE IF EXISTS users_tickets_user_id_seq;


CREATE TABLE "halls"
(
    id           SERIAL PRIMARY KEY,
    name         VARCHAR  NOT NULL,
    number_rows  SMALLINT NOT NULL,
    seats_in_row SMALLINT NOT NULL,
    description  TEXT     NOT NULL
);

CREATE TABLE "public"."sessions"
(
    id       SERIAL PRIMARY KEY,
    hall_id  INTEGER                NOT NULL,
    movie_id INTEGER                NOT NULL,
    date     DATE                   NOT NULL,
    time     TIME WITHOUT TIME ZONE NOT NULL,
    price    INTEGER                NOT NULL,
    FOREIGN KEY (hall_id) REFERENCES halls (id)
        ON UPDATE CASCADE,
    FOREIGN KEY (movie_id) REFERENCES movies.films (id)
        ON UPDATE CASCADE
);


CREATE TABLE "public"."tickets"
(
    id         SERIAL PRIMARY KEY,
    session_id INTEGER   NOT NULL,
    price      INTEGER   NOT NULL,
    date_sale  TIMESTAMP NOT NULL,
    row        SMALLINT  NOT NULL,
    seat       SMALLINT  NOT NULL,
    FOREIGN KEY (session_id) REFERENCES sessions (id)
        ON UPDATE CASCADE
);


CREATE TABLE "public"."users"
(
    id        SERIAL PRIMARY KEY,
    email     VARCHAR NOT NULL UNIQUE,
    password  varchar NOT NULL,
    firstname VARCHAR,
    lastname  VARCHAR,
    discount  SMALLINT
);


CREATE TABLE "public"."users_tickets"
(
    user_id   INTEGER NOT NULL,
    ticket_id INTEGER NOT NULL,
    PRIMARY KEY (user_id, ticket_id),
    FOREIGN KEY (ticket_id) REFERENCES tickets (id)
        ON UPDATE CASCADE ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users (id)
        ON UPDATE CASCADE ON DELETE CASCADE
);
