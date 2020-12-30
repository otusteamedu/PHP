CREATE TABLE IF NOT EXISTS films (
   id SERIAL PRIMARY KEY,
   title varchar(50) UNIQUE NOT NULL,
   duration_in_minutes smallint NOT NULL
);