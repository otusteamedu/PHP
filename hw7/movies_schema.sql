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
	cost int NOT NULL,
	date date NOT NULL,
	time time NOT NULL
);
CREATE UNIQUE INDEX ON sessions(hall_id, movie_id, date, time);
CREATE INDEX ON sessions(movie_id);
CREATE INDEX ON sessions(date);

CREATE TABLE seats (
    id smallserial PRIMARY KEY,
    hall_id smallint NOT NULL REFERENCES halls(id),
    row smallint NOT NULL,
    seat smallint NOT NULL
);
CREATE UNIQUE INDEX ON seats(hall_id, row, seat);

CREATE TABLE tickets (
	id bigserial PRIMARY KEY,
	session_id int NOT NULL REFERENCES sessions(id),
	seat_id smallint NOT NULL REFERENCES seats(id)
);
CREATE UNIQUE INDEX ON tickets(session_id, seat_id);
CREATE INDEX ON tickets(seat_id);
