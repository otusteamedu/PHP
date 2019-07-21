CREATE TABLE IF NOT EXISTS movies(
	id SERIAL PRIMARY KEY,
	title VARCHAR,
	duration INTERVAL,
	description TEXT
);

CREATE TYPE genre AS ENUM ('action', 'comedy', 'crime', 'drama', 'horor');

CREATE TABLE IF NOT EXISTS movies_genre(
	id SERIAL PRIMARY KEY,
	movie_genre GENRE,
	movie_id INTEGER REFERENCES movies(id)
);

CREATE TABLE IF NOT EXISTS hall(
	id SERIAL PRIMARY KEY,
	title VARCHAR
);

CREATE TABLE IF NOT EXISTS seance(
	id SERIAL PRIMARY KEY,
	movie_id INTEGER REFERENCES movies(id),
	hall_id INTEGER REFERENCES hall(id),
	start_time TIMESTAMP,
	end_time TIMESTAMP
);

CREATE TYPE place_category AS ENUM ('common', 'comfortable', 'vip');

CREATE TABLE IF NOT EXISTS category(
	id SERIAL PRIMARY KEY,
	category place_category,
	description TEXT
);

CREATE TABLE IF NOT EXISTS place(
	id SERIAL PRIMARY KEY,
	hall_id INTEGER REFERENCES hall(id),
	category_id INTEGER REFERENCES category(id),
	location VARCHAR
);


CREATE TABLE IF NOT EXISTS hall_place_count(
	id SERIAL PRIMARY KEY,
	hall_id INTEGER REFERENCES hall(id),
	category_id INTEGER REFERENCES category(id),
	place_count SMALLINT
);

CREATE TABLE IF NOT EXISTS users(
	id SERIAL PRIMARY KEY,
	user_name VARCHAR,
	first_name VARCHAR,
	last_name VARCHAR
);

CREATE TABLE IF NOT EXISTS tickets(
	id SERIAL PRIMARY KEY,
	user_id INTEGER REFERENCES users(id),
	seance_id INTEGER REFERENCES seance(id),
	place_id INTEGER REFERENCES place(id),
	cost MONEY
);
