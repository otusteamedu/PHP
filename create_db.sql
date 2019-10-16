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
    price NUMERIC NOT NULL CHECK (price >0),
    FOREIGN KEY (session_id) REFERENCES sessions (id),
    FOREIGN KEY (seat_id) REFERENCES seats (id),
    UNIQUE (seat_id, session_id)
);

CREATE TABLE IF NOT EXISTS film_attrs_types(
    id serial PRIMARY KEY,
    name VARCHAR (255) NOT NULL
);

CREATE TABLE IF NOT EXISTS films_attrs(
    id serial PRIMARY KEY,
    name VARCHAR (255) NOT NULL,
    type_id INT NOT NULL,
    FOREIGN KEY (type_id) REFERENCES film_attrs_types (id)
);

CREATE TABLE IF NOT EXISTS films_attrs_values(
    id serial PRIMARY KEY,
    film_id INT NOT NULL,
    film_attribute_id INT NOT NULL,
    value_text TEXT,
    value_date DATE,
    value_boolean BOOLEAN,
    FOREIGN KEY (film_id) REFERENCES films (id),
    FOREIGN KEY (film_attribute_id) REFERENCES films_attrs (id)
);
