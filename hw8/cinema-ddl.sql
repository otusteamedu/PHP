CREATE TABLE IF NOT EXISTS halls (
    id SERIAL PRIMARY KEY,
    name VARCHAR (255) NOT NULL
);

CREATE TABLE IF NOT EXISTS tickets (
    id SERIAL PRIMARY KEY,
    place_id INT NOT NULL,
    session_id INT NOT NULL,
    price NUMERIC NOT NULL CHECK (price > 0),
    FOREIGN KEY (place_id) REFERENCES places (id),
    FOREIGN KEY (session_id) REFERENCES sessions (id)
);

CREATE TABLE IF NOT EXISTS places (
    id SERIAL PRIMARY KEY,
    hall_id INT NOT NULL,
    place_tariff NUMERIC  NOT NULL CHECK (place_tariff > 0),
    FOREIGN KEY (hall_id) REFERENCES halls (id)
);

CREATE TABLE IF NOT EXISTS sessions (
    id SERIAL PRIMARY KEY,
    hall_id INT NOT NULL,
    movie_id INT NOT NULL,
    session_tariff NUMERIC NOT NULL CHECK (session_tariff > 0),
    date TIMESTAMP NOT NULL,
    FOREIGN KEY (hall_id) REFERENCES halls (id),
    FOREIGN KEY (movie_id) REFERENCES movies (id)
);

CREATE TABLE IF NOT EXISTS movies (
    id SERIAL PRIMARY KEY,
    name VARCHAR (255) NOT NULL,
    description VARCHAR (255) NOT NULL
);

-- самый прибыльный фильм только один
SELECT * FROM movies
WHERE id = (SELECT s.movie_id FROM tickets t
INNER JOIN sessions s on t.session_id = s.id
GROUP BY s.movie_id ORDER BY SUM(price) DESC LIMIT 1);

