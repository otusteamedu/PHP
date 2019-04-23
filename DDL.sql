CREATE SEQUENCE hall_seq;

DROP TABLE IF EXISTS hall;

CREATE TABLE hall
(
    id_hall INT          NOT NULL DEFAULT nextval('hall_seq'),
    name    VARCHAR(512) NOT NULL,
    PRIMARY KEY (id_hall)
);

ALTER SEQUENCE hall_seq OWNED BY hall.id_hall;

CREATE SEQUENCE film_seq;

CREATE TABLE IF NOT EXISTS film
(
    id_film INT           NOT NULL DEFAULT nextval('film_seq'),
    name    VARCHAR(1024) NOT NULL,
    year    CHAR(4)       NOT NULL,
    info    JSON          NULL,
    rating  FLOAT         NULL,
    PRIMARY KEY (id_film)
);

ALTER SEQUENCE film_seq OWNED BY film.id_film;

CREATE SEQUENCE session_seq;

CREATE TABLE IF NOT EXISTS session
(
    id_session INT   NOT NULL DEFAULT nextval('film_seq'),
    date       DATE  NOT NULL,
    time       TIME  NOT NULL,
    id_hall    INT   NOT NULL,
    id_film    INT   NOT NULL,
    price      FLOAT NULL,
    PRIMARY KEY (id_session),
    FOREIGN KEY (id_hall) REFERENCES hall (id_hall),
    FOREIGN KEY (id_film) REFERENCES film (id_film)
);

ALTER SEQUENCE session_seq OWNED BY session.id_session;

CREATE UNIQUE INDEX session_UNIQUE ON session (date ASC, time ASC, id_hall ASC, id_film ASC);

CREATE SEQUENCE client_seq;

CREATE TABLE IF NOT EXISTS "client"
(
    id_client INT         NOT NULL DEFAULT nextval('client_seq'),
    name      VARCHAR(45) NOT NULL,
    card      VARCHAR(45) NULL,
    PRIMARY KEY (id_client)
);

ALTER SEQUENCE client_seq OWNED BY "client".id_client;

CREATE TABLE IF NOT EXISTS client_session
(
    id_session INT NOT NULL,
    id_client  INT NOT NULL,
    PRIMARY KEY (id_session, id_client),
    FOREIGN KEY (id_session)
        REFERENCES session (id_session)
        ON DELETE NO ACTION
        ON UPDATE NO ACTION,
    FOREIGN KEY (id_client)
        REFERENCES "client" (id_client)
        ON DELETE NO ACTION
        ON UPDATE NO ACTION
);

