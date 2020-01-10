CREATE TABLE cinemas (
    id SERIAL,
    title VARCHAR(1024) NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE halls (
    id SERIAL,
    title VARCHAR(255) NOT NULL,
    cinema_id INT NOT NULL,
    PRIMARY KEY (id)
);

ALTER TABLE halls
    ADD CONSTRAINT fk_hall_cinema FOREIGN KEY (cinema_id)
        REFERENCES cinemas (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE;

CREATE TABLE movies (
    id SERIAL,
    title VARCHAR(1024) NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE showtimes (
    id SERIAL,
    date_time TIMESTAMP(0) WITH TIME ZONE NOT NULL,
    format VARCHAR(255) DEFAULT NULL,
    movie_id INT NOT NULL,
    hall_id INT NOT NULL,
    PRIMARY KEY (id)
);

ALTER TABLE showtimes
    ADD CONSTRAINT fk_showtime_movie FOREIGN KEY (movie_id)
        REFERENCES movies (id) NOT DEFERRABLE INITIALLY IMMEDIATE;

ALTER TABLE showtimes
    ADD CONSTRAINT fk_showtime_hall FOREIGN KEY (hall_id)
        REFERENCES halls (id) NOT DEFERRABLE INITIALLY IMMEDIATE;

CREATE TABLE bookings (
    id SERIAL,
    seat VARCHAR(64) NOT NULL,
    price MONEY NOT NULL DEFAULT 0,
    status VARCHAR(16) NOT NULL DEFAULT 'free',
    showtime_id INT NOT NULL,
    PRIMARY KEY (id)
);

ALTER TABLE bookings
    ADD CONSTRAINT check_status CHECK (status IN ('free', 'booked', 'sold', 'unavailable'));

ALTER TABLE bookings
    ADD CONSTRAINT fk_booking_showtime FOREIGN KEY (showtime_id)
        REFERENCES showtimes (id) NOT DEFERRABLE INITIALLY IMMEDIATE;

ALTER TABLE bookings
    ADD CONSTRAINT unique_seat_showtime UNIQUE (seat, showtime_id);
