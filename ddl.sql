DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS movies;
DROP TABLE IF EXISTS halls;
DROP TABLE IF EXISTS sessions;
DROP TABLE IF EXISTS tickets;

CREATE TABLE IF NOT EXISTS users(
    id serial PRIMARY KEY,
    name VARCHAR (255) NOT NULL,
    last_name VARCHAR (255) NOT NULL
);

CREATE TABLE IF NOT EXISTS movies(
    id serial PRIMARY KEY,
    name VARCHAR (255) NOT NULL,
    description VARCHAR (255) NOT NULL,
    duration interval NOT NULL,
    date_start timestamp NOT NULL,
    date_end timestamp NOT NULL
);

CREATE TABLE IF NOT EXISTS halls(
    id serial PRIMARY KEY,
    name VARCHAR (255) NOT NULL,
    description VARCHAR (255) NOT NULL,
    tickets_count INT NOT NULL
);

CREATE TABLE IF NOT EXISTS sessions(
    id serial PRIMARY KEY,
    movie_id serial REFERENCES movies,
    hall_id serial REFERENCES halls,
    start_time timestamp NOT NULL,
    end_time timestamp NOT NULL
);

CREATE TABLE IF NOT EXISTS tickets(
    id serial PRIMARY KEY,
    user_id serial REFERENCES users,
    session_id serial REFERENCES sessions,
    row INT NOT NULL,
    palce INT NOT NULL,
    price INT NOT NULL,
    date_create timestamp NOT NULL
);