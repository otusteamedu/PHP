CREATE TABLE movies (
	id serial PRIMARY KEY,
	name varchar(128) NOT NULL UNIQUE
);

CREATE TABLE halls (
	id smallserial PRIMARY KEY,
	name varchar(32) NOT NULL UNIQUE
);

CREATE TABLE sessions (
	id serial PRIMARY KEY,
	hall_id smallint NOT NULL REFERENCES halls(id),
	movie_id int NOT NULL REFERENCES movies(id),
	cost bigint NOT NULL,
	date date NOT NULL,
	time time NOT NULL
);
CREATE INDEX ON sessions(hall_id);
CREATE INDEX ON sessions(movie_id);
CREATE INDEX ON sessions(date);

CREATE TABLE tickets (
	id bigserial PRIMARY KEY,
	session_id int REFERENCES sessions(id)
);
CREATE INDEX ON tickets(session_id);