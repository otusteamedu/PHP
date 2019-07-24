CREATE DATABASE cinema;

\connect cinema

CREATE TABLE IF NOT EXISTS movie_rating(
   id serial PRIMARY KEY,
   title VARCHAR (50) NOT NULL,
   description TEXT
);

CREATE TABLE IF NOT EXISTS movie(
   id serial PRIMARY KEY,
   title VARCHAR (255) NOT NULL,
   image_path VARCHAR(255),
   year INT NOT NULL,
   description TEXT,
   rating_id INT,
   FOREIGN KEY (rating_id) REFERENCES movie_rating (id)
);

CREATE TABLE IF NOT EXISTS seat_category(
   id serial PRIMARY KEY,
   title VARCHAR(50) NOT NULL
);

CREATE TABLE IF NOT EXISTS hall(
   id serial PRIMARY KEY,
   title VARCHAR(50) NOT NULL,
   is_vip BOOLEAN NOT NULL
);

CREATE TABLE IF NOT EXISTS session(
   id serial PRIMARY KEY,
   date TIMESTAMP NOT NULL,
   movie_id INT,
   FOREIGN KEY (movie_id) REFERENCES movie(id),
   hall_id INT,
   FOREIGN KEY (hall_id) REFERENCES hall(id)
);

CREATE TABLE IF NOT EXISTS session_category_price(
   id serial PRIMARY KEY,
   session_id INT,
   FOREIGN KEY (session_id) REFERENCES session(id),
   category_id INT,
   FOREIGN KEY (category_id) REFERENCES seat_category(id),
   price NUMERIC NOT NULL
);

CREATE TABLE IF NOT EXISTS seat(
   id serial PRIMARY KEY,
   row SMALLINT NOT NULL,
   number SMALLINT NOT NULL,
   hall_id INT,
   FOREIGN KEY (hall_id) REFERENCES hall(id),
   category_id INT,
   FOREIGN KEY (category_id) REFERENCES seat_category(id)
);

CREATE TABLE IF NOT EXISTS ledger_entry(
   id serial PRIMARY KEY,
   session_id INT,
   FOREIGN KEY (session_id) REFERENCES session(id),
   seat_id INT,
   FOREIGN KEY (seat_id) REFERENCES seat(id),
   amount NUMERIC NOT NULL
);