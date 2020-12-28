CREATE TABLE IF NOT EXISTS events (
   id SERIAL PRIMARY KEY,
   hall_id smallint NOT NULL REFERENCES halls,
   film_id integer NOT NULL REFERENCES films,
   datetime timestamp NOT NULL,
   UNIQUE (hall_id, datetime)
);