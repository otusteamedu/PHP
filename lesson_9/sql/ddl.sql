DROP VIEW IF EXISTS view_movie_tasks;
DROP VIEW IF EXISTS view_movie_information;
DROP TABLE IF EXISTS movieAttributeValues;
DROP TABLE IF EXISTS movieAttributes;
DROP TABLE IF EXISTS movieAttributeTypes;
DROP TABLE IF EXISTS movies;

CREATE TABLE IF NOT EXISTS movies (
    id SERIAL PRIMARY KEY,
    title varchar(100) NOT NULL,
    duration smallint NOT NULL
);

CREATE TABLE IF NOT EXISTS movieAttributeTypes (
    id SERIAL PRIMARY KEY,
    name varchar(255) NOT NULL,
    description varchar(255) NOT NULL
);

CREATE TABLE IF NOT EXISTS movieAttributes (
    id SERIAL PRIMARY KEY,
    name varchar(255) NOT NULL,
    type_id integer NOT NULL REFERENCES movieAttributeTypes,
    UNIQUE (name)
);
CREATE INDEX type_idx ON movieAttributes (type_id);

CREATE TABLE IF NOT EXISTS movieAttributeValues (
    id SERIAL PRIMARY KEY,
    attribute_id integer NOT NULL REFERENCES movieAttributes,
    movie_id integer NOT NULL REFERENCES movies,
    value_text varchar NULL,
    value_date date NULL,
    value_bool bool NULL,
    value_int integer NULL,
    value_float float NULL,
    value_money money NULL
);
CREATE INDEX movie_attribute_idx ON movieAttributeValues (movie_id, attribute_id);

