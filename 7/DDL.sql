CREATE TABLE IF NOT EXISTS halls (
     id serial PRIMARY KEY,
     name varchar(100) DEFAULT NULL
);

CREATE TABLE IF NOT EXISTS seat_type (
    id serial PRIMARY KEY,
    name varchar(100) DEFAULT NULL,
    price_coefficient numeric(10, 2)
);

CREATE TABLE IF NOT EXISTS genres (
    id serial PRIMARY KEY,
    name varchar(100) DEFAULT NULL
);

CREATE TABLE IF NOT EXISTS hall_seats (
    id serial PRIMARY KEY,
    hall_id int DEFAULT 0,
    type_id int DEFAULT 0,
    row int DEFAULT 0,
    number int DEFAULT 0,
    CONSTRAINT FK_hall_seats_halls FOREIGN KEY (hall_id) REFERENCES halls(id) ON DELETE CASCADE,
    CONSTRAINT FK_hall_seats_seat_type FOREIGN KEY (type_id) REFERENCES seat_type(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS movies (
    id serial PRIMARY KEY,
    name varchar(100) DEFAULT NULL,
    description varchar(1024) DEFAULT NULL,
    genre_id int,
    duration timestamp(0) DEFAULT NULL,
    release_date date DEFAULT NULL,
    CONSTRAINT FK_movies_genres FOREIGN KEY (genre_id) REFERENCES genres(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS session (
    id serial PRIMARY KEY,
    movie_id int,
    hall_id int,
    price money,
    start_time timestamp(0) DEFAULT NULL,
    end_time timestamp(0) DEFAULT NULL,
    CONSTRAINT FK_session_halls FOREIGN KEY (hall_id) REFERENCES halls(id) ON DELETE CASCADE,
    CONSTRAINT FK_session_movies FOREIGN KEY (movie_id) REFERENCES movies(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS orders (
    id serial PRIMARY KEY,
    customer_id int,
    session_id int,
    seat_id int,
    cost money,
    CONSTRAINT FK_orders_hall_seats FOREIGN KEY (seat_id) REFERENCES hall_seats(id) ON DELETE CASCADE,
    CONSTRAINT FK_orders_session FOREIGN KEY (session_id) REFERENCES session(id) ON DELETE CASCADE
);
