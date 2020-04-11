CREATE TABLE IF NOT EXISTS cinemas (
    id SERIAL PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    code VARCHAR(100) NOT NULL,
    CONSTRAINT cinema_unique UNIQUE (code)
);

INSERT INTO cinemas VALUES 
    (DEFAULT, 'Первый кинотеатр', 'first'),
    (DEFAULT, 'Второй кинотеатр', 'second')
;



CREATE TABLE IF NOT EXISTS halls (
    id SERIAL PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    code VARCHAR(100) NOT NULL,
    cinema_id INTEGER,
    CONSTRAINT hall_unique UNIQUE (code, cinema_id),
    FOREIGN KEY (cinema_id) REFERENCES cinemas (id)
);

INSERT INTO halls VALUES 
    (DEFAULT, 'Синий зал', 'blue', (SELECT id FROM cinemas WHERE code='first')),
    (DEFAULT, 'Синий зал', 'blue', (SELECT id FROM cinemas WHERE code='second')),
    (DEFAULT, 'Зеленый зал', 'green', (SELECT id FROM cinemas WHERE code='first'))
;



CREATE TABLE IF NOT EXISTS seats (
    id SERIAL PRIMARY KEY,
    hall_id INTEGER,
    row SMALLINT,
    seat SMALLINT,
    base_price NUMERIC(18,2),
    CONSTRAINT seat_unique UNIQUE (hall_id, row, seat),
    FOREIGN KEY (hall_id) REFERENCES halls (id)
);

CREATE OR REPLACE FUNCTION fill_seats(hall_code text, cinema_code text, rows_count integer, seats_count integer, price integer) 
RETURNS boolean as $$

DECLARE
    _hall_id integer := null; 
    row_number integer := 1; 
    seat_number integer := 1;

BEGIN
    SELECT halls.id INTO _hall_id FROM halls
        LEFT JOIN cinemas ON halls.cinema_id = cinemas.id 
        WHERE halls.code=hall_code and cinemas.code=cinema_code;

    IF _hall_id IS NULL THEN
        RETURN false;
    END IF;
    
    SELECT MAX(row) + 1 INTO row_number FROM seats WHERE hall_id = _hall_id;

    IF row_number IS NULL THEN
        row_number := 1;
    END IF;

    rows_count := rows_count + row_number;

    <<row_loop>>
    WHILE row_number < rows_count LOOP
        seat_number := 1;
        <<seat_loop>>
        WHILE seat_number <= seats_count LOOP
            INSERT INTO seats VALUES (default, _hall_id, row_number, seat_number, price);
            seat_number := seat_number + 1;
        END LOOP seat_loop;

        row_number := row_number + 1;
    END LOOP row_loop;

    RETURN true;
END;
$$ LANGUAGE plpgsql;

SELECT fill_seats('blue', 'first', 3, 10, 300);
SELECT fill_seats('blue', 'first', 3, 10, 500);
SELECT fill_seats('blue', 'first', 3, 10, 300);
SELECT fill_seats('green', 'first', 4, 8, 1000);



CREATE TABLE IF NOT EXISTS movies (
    id SERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL
);



CREATE TABLE IF NOT EXISTS sessions (
    id SERIAL PRIMARY KEY,
    hall_id INTEGER,
    movie_id INTEGER,
    date TIMESTAMP,
    coefficient DECIMAL(1,1),
    FOREIGN KEY (hall_id) REFERENCES halls (id),
    FOREIGN KEY (movie_id) REFERENCES movies (id)
);



CREATE TABLE IF NOT EXISTS clients (
    id SERIAL PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL
);



CREATE TABLE IF NOT EXISTS orders (
    id SERIAL PRIMARY KEY,
    client_id INTEGER,
    sum NUMERIC(18,2),
    discount NUMERIC(18,2),
    total NUMERIC(18,2),
    FOREIGN KEY (client_id) REFERENCES clients (id)
);



CREATE TABLE IF NOT EXISTS basket (
    id SERIAL PRIMARY KEY,
    order_id INTEGER,
    session_id INTEGER,
    seat_id INTEGER,
    price NUMERIC(18,2),
    CONSTRAINT basket_unique UNIQUE (session_id, seat_id),
    FOREIGN KEY (order_id) REFERENCES orders (id),
    FOREIGN KEY (session_id) REFERENCES sessions (id),
    FOREIGN KEY (seat_id) REFERENCES seats (id)
);