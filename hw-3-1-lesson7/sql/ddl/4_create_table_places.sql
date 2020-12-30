CREATE TABLE IF NOT EXISTS places (
  id SERIAL PRIMARY KEY,
  number smallint NOT NULL,
  hall_id smallint NOT NULL REFERENCES halls,
  UNIQUE (number, hall_id)
);