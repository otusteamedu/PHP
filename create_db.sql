CREATE TABLE IF NOT EXISTS films(
    id serial PRIMARY KEY,
    name VARCHAR (255) NOT NULL
);

CREATE TABLE IF NOT EXISTS halls(
    id serial PRIMARY KEY,
    name VARCHAR (255) NOT NULL
);

CREATE TABLE IF NOT EXISTS sessions(
    id serial PRIMARY KEY,
    film_id INT NOT NULL,
    hall_id INT NOT NULL,
    time TIMESTAMP  NOT NULL,
    FOREIGN KEY (film_id) REFERENCES films (id),
    FOREIGN KEY (hall_id) REFERENCES halls (id)
);

CREATE TABLE IF NOT EXISTS seats(
    id serial PRIMARY KEY,
    hall_id INT NOT NULL,
    row INT NOT NULL,
    number INT NOT NULL,
    FOREIGN KEY (hall_id) REFERENCES halls (id)
);

CREATE TABLE IF NOT EXISTS tickets(
    id serial PRIMARY KEY,
    session_id INT NOT NULL,
    seat_id INT NOT NULL,
    price NUMERIC NOT NULL,
    FOREIGN KEY (session_id) REFERENCES sessions (id),
    FOREIGN KEY (seat_id) REFERENCES seats (id)
);
