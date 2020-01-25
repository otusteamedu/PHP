CREATE TABLE cinemas (
    id SERIAL,
    title VARCHAR(1024) NOT NULL,
    PRIMARY KEY (id)
);
CREATE UNIQUE INDEX cinema_titles_unique ON cinemas (lower(title));

CREATE TABLE halls (
    id SERIAL,
    title VARCHAR(255) NOT NULL,
    cinema_id INT NOT NULL,
    PRIMARY KEY (id)
);
CREATE UNIQUE INDEX hall_titles_unique ON halls (lower(title));
ALTER TABLE halls
    ADD CONSTRAINT fk_hall_cinema FOREIGN KEY (cinema_id)
        REFERENCES cinemas(id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE;

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
        REFERENCES movies(id) NOT DEFERRABLE INITIALLY IMMEDIATE;
ALTER TABLE showtimes
    ADD CONSTRAINT fk_showtime_hall FOREIGN KEY (hall_id)
        REFERENCES halls(id) NOT DEFERRABLE INITIALLY IMMEDIATE;

CREATE TABLE booking_statuses (
    id SERIAL,
    status VARCHAR(16) NOT NULL,
    PRIMARY KEY (id)
);
CREATE UNIQUE INDEX booking_status_titles_unique ON booking_statuses (lower(status));

CREATE TABLE bookings (
    id SERIAL,
    seat INT NOT NULL,
    price MONEY NOT NULL DEFAULT 0,
    status_id INT NOT NULL,
    showtime_id INT NOT NULL,
    PRIMARY KEY (id)
);
ALTER TABLE bookings
    ADD CONSTRAINT fk_booking_showtime FOREIGN KEY (showtime_id)
        REFERENCES showtimes(id) NOT DEFERRABLE INITIALLY IMMEDIATE;
ALTER TABLE bookings
    ADD CONSTRAINT fk_booking_status FOREIGN KEY (status_id)
        REFERENCES booking_statuses(id) NOT DEFERRABLE INITIALLY IMMEDIATE;
ALTER TABLE bookings
    ADD CONSTRAINT unique_seat_showtime UNIQUE (seat, showtime_id);
