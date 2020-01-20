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
INSERT INTO booking_statuses(id, status) VALUES (DEFAULT, 'free'), (DEFAULT, 'booked'), (DEFAULT, 'sold'), (DEFAULT, 'unavailable');

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

----------------------------------------------------------------------------------------------

CREATE TABLE movie_attribute_types (
    id SERIAL,
    title VARCHAR(64) NOT NULL,
    comment TEXT,
    PRIMARY KEY (id)
);
CREATE UNIQUE INDEX movie_attribute_type_titles_unique ON movie_attribute_types (lower(title));

CREATE TABLE movie_attributes (
    id SERIAL,
    type_id INT NOT NULL,
    title VARCHAR(512) NOT NULL,
    PRIMARY KEY (id)
);
CREATE UNIQUE INDEX movie_attributes_titles_unique ON movie_attributes (lower(title));
ALTER TABLE movie_attributes
    ADD CONSTRAINT fk_movie_attributes_movie_attributes_types FOREIGN KEY (type_id)
        REFERENCES movie_attribute_types(id) NOT DEFERRABLE INITIALLY IMMEDIATE;

CREATE TABLE movie_attribute_values (
    id SERIAL,
    movie_id INT NOT NULL,
    attribute_id INT NOT NULL,
    value_text VARCHAR,
    value_date DATE,
    value_bool BOOLEAN,
    value_int INT,
    value_float NUMERIC,
    value_money MONEY,
    PRIMARY KEY (id)
);
CREATE UNIQUE INDEX movie_attribute_values_unique ON movie_attribute_values (movie_id, attribute_id);
ALTER TABLE movie_attribute_values
    ADD CONSTRAINT fk_movie_attribute_values_movie FOREIGN KEY (movie_id)
        REFERENCES movies(id) NOT DEFERRABLE INITIALLY IMMEDIATE;
ALTER TABLE movie_attribute_values
    ADD CONSTRAINT fk_movie_attribute_values_attribute FOREIGN KEY (attribute_id)
        REFERENCES movie_attributes(id) NOT DEFERRABLE INITIALLY IMMEDIATE;

CREATE MATERIALIZED VIEW movie_public_info AS (
    SELECT m.title  as movie,
           ma.title as attribute,
           CASE mat.title
               WHEN 'date' THEN mav.value_date::text
               WHEN 'float' THEN mav.value_float::text
               WHEN 'text' THEN mav.value_text::text
               WHEN 'boolean' THEN mav.value_bool::text
               WHEN 'integer' THEN mav.value_int::text
               WHEN 'money' THEN mav.value_money::text
               END AS value
    FROM movies m
        INNER JOIN movie_attribute_values mav on m.id = mav.movie_id
        INNER JOIN movie_attributes ma on mav.attribute_id = ma.id
        INNER JOIN movie_attribute_types mat on ma.type_id = mat.id
    WHERE mat.title != 'service date'
    ORDER BY m.title, ma.title
);
SELECT * FROM movie_public_info;

CREATE OR REPLACE VIEW movie_service_info AS (
     SELECT m.title,
            string_agg(CASE WHEN value_date = now()::date THEN ma.title END, '; ') AS tasks_for_now,
            string_agg(CASE WHEN value_date = (now() + INTERVAL '20 days')::date THEN ma.title END, '; ') AS tasks_for_20_days
     FROM movies m
              INNER JOIN movie_attribute_values mav on m.id = mav.movie_id
              INNER JOIN movie_attributes ma on mav.attribute_id = ma.id
              INNER JOIN movie_attribute_types mat on ma.type_id = mat.id
     WHERE mat.title = 'service date'
     GROUP BY m.title
);
SELECT * FROM movie_service_info;