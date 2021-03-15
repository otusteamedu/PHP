DROP SCHEMA IF EXISTS movies CASCADE;
CREATE SCHEMA movies AUTHORIZATION alex;

DROP TABLE IF EXISTS movies."values" CASCADE;
DROP SEQUENCE IF EXISTS values_id_seq;

DROP TABLE IF EXISTS movies."attributes" CASCADE;
DROP SEQUENCE IF EXISTS attributes_id_seq;

DROP TABLE IF EXISTS movies."types" CASCADE;
DROP SEQUENCE IF EXISTS types_id_seq;

DROP TABLE IF EXISTS movies."films" CASCADE;
DROP SEQUENCE IF EXISTS films_id_seq;


CREATE TABLE movies.films
(
    id    serial,
    title varchar NOT NULL,
    CONSTRAINT film_pk PRIMARY KEY (id),
    CONSTRAINT film_uniq UNIQUE (title)
);


CREATE TABLE movies."types"
(
    id        serial,
    "name"    varchar NOT NULL,
    data_type varchar null,
    CONSTRAINT type_pk PRIMARY KEY (id),
    CONSTRAINT type_uniq UNIQUE ("name")
);


CREATE TABLE movies."attributes"
(
    id        serial,
    "name"    varchar NOT NULL,
    "type_id" int4    NOT null,
    CONSTRAINT attr_pk PRIMARY KEY (id),
    CONSTRAINT attr_uniq UNIQUE ("name"),
    CONSTRAINT type_fk FOREIGN KEY (type_id) REFERENCES movies."types" (id) ON UPDATE CASCADE ON DELETE CASCADE
);


CREATE TABLE movies."values"
(
    id        serial,
    film_id   int4    NOT NULL,
    attr_id   int4    NOT NULL,
    val_date  date    NULL,
    val_int   int4    NULL,
    val_float numeric NULL,
    val_bool  boolean NULL,
    val_text  text    NULL,
    CONSTRAINT value_pk PRIMARY KEY (id),
    CONSTRAINT attr_fk FOREIGN KEY (attr_id) REFERENCES movies."attributes" (id) ON UPDATE CASCADE ON DELETE CASCADE,
    CONSTRAINT film_fk FOREIGN KEY (film_id) REFERENCES movies."films" (id) ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE INDEX film_value_idx ON movies."values" USING btree (film_id);











