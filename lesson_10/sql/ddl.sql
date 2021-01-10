DROP VIEW IF EXISTS view_movie_tasks;
DROP VIEW IF EXISTS view_movie_information;

DROP TABLE IF EXISTS orders;
DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS seats;
DROP TABLE IF EXISTS sessions;
DROP TABLE IF EXISTS halls;
DROP TABLE IF EXISTS movieAttributeValues;
DROP TABLE IF EXISTS movieAttributes;
DROP TABLE IF EXISTS movieAttributeTypes;
DROP TABLE IF EXISTS movies;

CREATE TABLE IF NOT EXISTS movies (
    id SERIAL PRIMARY KEY,
    title varchar(100) NOT NULL,
    duration smallint NOT NULL
);

CREATE TABLE IF NOT EXISTS halls (
    id SERIAL PRIMARY KEY,
    title varchar(100) UNIQUE NOT NULL
);

CREATE TABLE IF NOT EXISTS seats (
    id SERIAL PRIMARY KEY,
    number smallint NOT NULL,
    hall_id integer NOT NULL REFERENCES halls,
    UNIQUE (number, hall_id)
);

CREATE TABLE IF NOT EXISTS sessions (
    id SERIAL PRIMARY KEY,
    movie_id integer NOT NULL REFERENCES movies,
    hall_id integer NOT NULL REFERENCES halls,
    start_time timestamp NOT NULL,
    price numeric(6, 2) NULL CHECK (price >= 0),
    UNIQUE (hall_id, start_time)
);

CREATE TABLE IF NOT EXISTS users (
    id SERIAL PRIMARY KEY,
    name varchar(100) UNIQUE NOT NULL,
    password varchar(100) NOT NULL,
    email varchar(255) NOT NULL,
    created_on timestamp NOT NULL,
    last_login timestamp
);

CREATE TABLE IF NOT EXISTS orders (
    id SERIAL PRIMARY KEY,
    session_id integer NOT NULL REFERENCES sessions,
    seat_id integer NOT NULL REFERENCES seats,
    user_id integer NULL REFERENCES users,
    date_time timestamp NOT NULL,
    UNIQUE (session_id, seat_id)
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
    value_float float NULL
);
CREATE INDEX movie_attribute_idx ON movieAttributeValues (movie_id, attribute_id);

