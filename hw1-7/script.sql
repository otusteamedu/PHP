DROP TABLE IF EXISTS films;
DROP TABLE IF EXISTS filmsAttr;
DROP TABLE IF EXISTS filmsAttrTypes;
DROP TABLE IF EXISTS filmsAttrValues;
DROP TABLE IF EXISTS services;

CREATE TABLE if not exists films
(
    id   serial primary key,
    name varchar(50)
);

CREATE TABLE if not exists filmsAttrTypes
(
    id        serial primary key,
    attr_type varchar(15)
);

CREATE TABLE if not exists filmsAttr
(
    id      serial primary key,
    attr    varchar(128),
    type_id integer,
    CONSTRAINT fk_type_id FOREIGN KEY (type_id) REFERENCES filmsAttrTypes (id) ON DELETE CASCADE
);

CREATE TABLE if not exists filmsAttrValues
(
    id          serial primary key,
    film_id     integer NOT NULL,
    attr_id     integer NOT NULL,
    value_str   varchar,
    value_date  date,
    value_bool  boolean,
    description varchar(127),
    value_float float4,
    CONSTRAINT fk_film_id FOREIGN KEY (film_id) REFERENCES films (id) ON DELETE CASCADE,
    CONSTRAINT fk_attr_id FOREIGN KEY (attr_id) REFERENCES filmsAttr (id) ON DELETE CASCADE

);

CREATE INDEX films_id_idx ON filmsAttrValues (film_id);

CREATE TABLE services
(
    id       serial primary key,
    attr_id  integer NOT NULL references filmsAttr (id),
    priority integer DEFAULT 0
);



