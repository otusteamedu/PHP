DROP TABLE IF EXISTS "tUserTickets" CASCADE;

DROP TABLE IF EXISTS "tHalls" CASCADE;
DROP SEQUENCE IF EXISTS "tHalls_id_seq";

DROP TABLE IF EXISTS "tSessions" CASCADE;
DROP SEQUENCE IF EXISTS "tSessions_id_seq";

DROP TABLE IF EXISTS "tTickets" CASCADE;
DROP SEQUENCE IF EXISTS "tTickets_id_seq";

DROP TABLE IF EXISTS "tUsers" CASCADE;
DROP SEQUENCE IF EXISTS "tUsers_id_seq";

DROP TABLE IF EXISTS "tFilmAttrValues" CASCADE;
drop sequence if exists "tFilmAttrValues_id_seq";

DROP TABLE IF EXISTS "tAttributes" CASCADE;
drop sequence if exists "tAttributes_id_seq";

DROP TABLE IF EXISTS "tAttrTypes" CASCADE;
drop sequence if exists "tAttrTypes_id_seq";

DROP TABLE IF EXISTS "tFilms" CASCADE;
drop sequence if exists "tFilms_id_seq";


CREATE TABLE "tFilms"
(
    id    serial PRIMARY KEY,
    title varchar NOT null UNIQUE
);


CREATE TABLE "tAttrTypes"
(
    id      serial PRIMARY KEY,
    name    varchar NOT null UNIQUE,
    data_type varchar null
);


CREATE TABLE "tAttributes"
(
    id      serial	PRIMARY KEY,
    name    varchar NOT null UNIQUE,
    type_id int4    NOT null,
    CONSTRAINT type_fk FOREIGN KEY (type_id) REFERENCES "tAttrTypes" (id) ON UPDATE CASCADE ON DELETE CASCADE
);


CREATE TABLE "tFilmAttrValues"
(
    id        serial PRIMARY KEY,
    film_id   int4    NOT NULL,
    attr_id   int4    NOT NULL,
    val_date  date    NULL,
    val_int   int4    NULL,
    val_float numeric NULL,
    val_bool  bool    NULL,
    val_text  text    NULL,
    CONSTRAINT attr_fk FOREIGN KEY (attr_id) REFERENCES "tAttributes" (id) ON UPDATE CASCADE ON DELETE CASCADE,
    CONSTRAINT film_fk FOREIGN KEY (film_id) REFERENCES "tFilms" (id) ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE INDEX "favFilm" ON "tFilmAttrValues" USING btree (film_id);


CREATE TABLE "tHalls" (
  id SERIAL PRIMARY KEY,
  name  VARCHAR NOT NULL,
  number_rows SMALLINT NOT NULL,
  seats_in_row SMALLINT NOT NULL,
  description TEXT NOT NULL
);



CREATE TABLE "tSessions" (
     id SERIAL PRIMARY KEY ,
     hall_id INTEGER NOT NULL,
     movie_id INTEGER NOT NULL,
     date DATE NOT NULL,
     time TIME WITHOUT TIME ZONE NOT NULL,
     price INTEGER NOT NULL,
     FOREIGN KEY (hall_id) REFERENCES "tHalls" (id)
        ON UPDATE CASCADE,
     FOREIGN KEY (movie_id) REFERENCES "tFilms" (id)
        ON UPDATE CASCADE
);


CREATE TABLE "tTickets" (
    id SERIAL PRIMARY KEY,
    session_id INTEGER NOT NULL,
    price INTEGER NOT NULL,
    date_sale TIMESTAMP NOT NULL,
    row SMALLINT NOT NULL,
    seat SMALLINT NOT NULL,
    FOREIGN KEY (session_id) REFERENCES "tSessions" (id)
        ON UPDATE CASCADE
);


CREATE TABLE "tUsers" (
    id SERIAL PRIMARY KEY ,
    email VARCHAR NOT NULL UNIQUE,
    password varchar NOT NULL,
    firstname VARCHAR,
    lastname VARCHAR,
    discount SMALLINT
);


CREATE TABLE "tUserTickets" (
    user_id INTEGER not NULL ,
    ticket_id INTEGER NOT NULL,
    FOREIGN KEY (ticket_id) REFERENCES "tTickets" (id)
        ON UPDATE CASCADE ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES "tUsers" (id)
        ON UPDATE CASCADE ON DELETE CASCADE
);
