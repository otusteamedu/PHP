CREATE TABLE IF NOT EXISTS events (
   id SERIAL PRIMARY KEY,
   hall_id smallint NOT NULL REFERENCES halls,
   film_id integer NOT NULL REFERENCES films,
   datetime timestamp NOT NULL,
   price numeric(6, 2) NULL CHECK (price >= 0),
   UNIQUE (hall_id, datetime)
);