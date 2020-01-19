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
    title VARCHAR(512),
    PRIMARY KEY (id)
);
CREATE UNIQUE INDEX movie_attribute_type_titles_unique ON movie_attribute_types (lower(title));

CREATE TABLE movie_attribute_text (
    id SERIAL,
    movie_id INT NOT NULL,
    attribute_type_id INT NOT NULL,
    value TEXT NOT NULL,
    PRIMARY KEY (id)
);
ALTER TABLE movie_attribute_text
    ADD CONSTRAINT fk_movie_attribute_text_movie FOREIGN KEY (movie_id)
       REFERENCES movies(id) NOT DEFERRABLE INITIALLY IMMEDIATE;
ALTER TABLE movie_attribute_text
    ADD CONSTRAINT fk_movie_attribute_text_attribute_type FOREIGN KEY (attribute_type_id)
       REFERENCES movie_attribute_types(id) NOT DEFERRABLE INITIALLY IMMEDIATE;
CREATE UNIQUE INDEX movie_attribute_text_movie_id_attribute_type_id ON movie_attribute_text(movie_id, attribute_type_id);

CREATE TABLE movie_attribute_date_service (
    id SERIAL,
    movie_id INT NOT NULL,
    attribute_type_id INT NOT NULL,
    value DATE NOT NULL,
    PRIMARY KEY (id)
);
ALTER TABLE movie_attribute_date_service
    ADD CONSTRAINT fk_movie_attribute_date_service_movie FOREIGN KEY (movie_id)
       REFERENCES movies(id) NOT DEFERRABLE INITIALLY IMMEDIATE;
ALTER TABLE movie_attribute_date_service
    ADD CONSTRAINT fk_movie_attribute_date_service_attribute_type FOREIGN KEY (attribute_type_id)
       REFERENCES movie_attribute_types(id) NOT DEFERRABLE INITIALLY IMMEDIATE;
CREATE UNIQUE INDEX movie_attribute_date_service_movie_id_attribute_type_id ON movie_attribute_date_service(movie_id, attribute_type_id);

CREATE TABLE movie_attribute_date_public (
    id SERIAL,
    movie_id INT NOT NULL,
    attribute_type_id INT NOT NULL,
    value DATE NOT NULL,
    PRIMARY KEY (id)
);
ALTER TABLE movie_attribute_date_public
    ADD CONSTRAINT fk_movie_attribute_date_public_movie FOREIGN KEY (movie_id)
       REFERENCES movies(id) NOT DEFERRABLE INITIALLY IMMEDIATE;
ALTER TABLE movie_attribute_date_public
    ADD CONSTRAINT fk_movie_attribute_date_public_attribute_type FOREIGN KEY (attribute_type_id)
       REFERENCES movie_attribute_types(id) NOT DEFERRABLE INITIALLY IMMEDIATE;
CREATE UNIQUE INDEX movie_attribute_date_public_movie_id_attribute_type_id ON movie_attribute_date_public(movie_id, attribute_type_id);

CREATE TABLE movie_attribute_bool (
    id SERIAL,
    movie_id INT NOT NULL,
    attribute_type_id INT NOT NULL,
    value BOOLEAN NOT NULL DEFAULT true,
    PRIMARY KEY (id)
);
ALTER TABLE movie_attribute_bool
    ADD CONSTRAINT fk_movie_attribute_bool_movie FOREIGN KEY (movie_id)
       REFERENCES movies(id) NOT DEFERRABLE INITIALLY IMMEDIATE;
ALTER TABLE movie_attribute_bool
    ADD CONSTRAINT fk_movie_attribute_bool_attribute_type FOREIGN KEY (attribute_type_id)
       REFERENCES movie_attribute_types(id) NOT DEFERRABLE INITIALLY IMMEDIATE;
CREATE UNIQUE INDEX movie_attribute_bool_movie_id_attribute_type_id ON movie_attribute_bool(movie_id, attribute_type_id);

CREATE TABLE movie_attribute_int (
    id SERIAL,
    movie_id INT NOT NULL,
    attribute_type_id INT NOT NULL,
    value INT NOT NULL,
    PRIMARY KEY (id)
);
ALTER TABLE movie_attribute_int
    ADD CONSTRAINT fk_movie_attribute_int_movie FOREIGN KEY (movie_id)
       REFERENCES movies(id) NOT DEFERRABLE INITIALLY IMMEDIATE;
ALTER TABLE movie_attribute_int
    ADD CONSTRAINT fk_movie_attribute_int_attribute_type FOREIGN KEY (attribute_type_id)
       REFERENCES movie_attribute_types(id) NOT DEFERRABLE INITIALLY IMMEDIATE;
CREATE UNIQUE INDEX movie_attribute_int_movie_id_attribute_type_id ON movie_attribute_int(movie_id, attribute_type_id);

CREATE TABLE movie_attribute_money (
    id SERIAL,
    movie_id INT NOT NULL,
    attribute_type_id INT NOT NULL,
    value MONEY NOT NULL,
    PRIMARY KEY (id)
);
ALTER TABLE movie_attribute_money
    ADD CONSTRAINT fk_movie_attribute_money_movie FOREIGN KEY (movie_id)
       REFERENCES movies(id) NOT DEFERRABLE INITIALLY IMMEDIATE;
ALTER TABLE movie_attribute_money
    ADD CONSTRAINT fk_movie_attribute_money_attribute_type FOREIGN KEY (attribute_type_id)
       REFERENCES movie_attribute_types(id) NOT DEFERRABLE INITIALLY IMMEDIATE;
CREATE UNIQUE INDEX movie_attribute_money_movie_id_attribute_type_id ON movie_attribute_money(movie_id, attribute_type_id);

CREATE TABLE movie_attribute_float (
    id SERIAL,
    movie_id INT NOT NULL,
    attribute_type_id INT NOT NULL,
    value NUMERIC NOT NULL,
    PRIMARY KEY (id)
);
ALTER TABLE movie_attribute_float
    ADD CONSTRAINT fk_movie_attribute_float_movie FOREIGN KEY (movie_id)
       REFERENCES movies(id) NOT DEFERRABLE INITIALLY IMMEDIATE;
ALTER TABLE movie_attribute_float
    ADD CONSTRAINT fk_movie_attribute_float_attribute_type FOREIGN KEY (attribute_type_id)
       REFERENCES movie_attribute_types(id) NOT DEFERRABLE INITIALLY IMMEDIATE;
CREATE UNIQUE INDEX movie_attribute_float_movie_id_attribute_type_id ON movie_attribute_float(movie_id, attribute_type_id);

CREATE MATERIALIZED VIEW movie_public_info AS (
    SELECT m.title as movie, mat.title as attribute, mab.value::text as value
    FROM movies m
         INNER JOIN movie_attribute_bool mab on m.id = mab.movie_id
         INNER JOIN movie_attribute_types mat on mab.attribute_type_id = mat.id
    UNION ALL
    SELECT m.title as movie, mat.title as attribute, matx.value::text as value
    FROM movies m
         INNER JOIN movie_attribute_text matx on m.id = matx.movie_id
         INNER JOIN movie_attribute_types mat on matx.attribute_type_id = mat.id
    UNION ALL
    SELECT m.title as movie, mat.title as attribute, madp.value::text as value
    FROM movies m
         INNER JOIN movie_attribute_date_public madp on m.id = madp.movie_id
         INNER JOIN movie_attribute_types mat on madp.attribute_type_id = mat.id
    UNION ALL
    SELECT m.title as movie, mat.title as attribute, maf.value::text as value
    FROM movies m
         INNER JOIN movie_attribute_float maf on m.id = maf.movie_id
         INNER JOIN movie_attribute_types mat on maf.attribute_type_id = mat.id
    UNION ALL
    SELECT m.title as movie, mat.title as attribute, mai.value::text as value
    FROM movies m
         INNER JOIN movie_attribute_int mai on m.id = mai.movie_id
         INNER JOIN movie_attribute_types mat on mai.attribute_type_id = mat.id
    UNION ALL
    SELECT m.title as movie, mat.title as attribute, mam.value::text as value
    FROM movies m
         INNER JOIN movie_attribute_money mam on m.id = mam.movie_id
         INNER JOIN movie_attribute_types mat on mam.attribute_type_id = mat.id);

SELECT * FROM movie_public_info;

CREATE OR REPLACE VIEW movie_service_info AS (
    SELECT
       m.title,
       string_agg(CASE WHEN mads.value = now()::date THEN mat.title END, ', ') AS task_for_now,
       string_agg(CASE WHEN mads.value = (now() + INTERVAL '20 days')::date THEN mat.title END, ', ') AS task_for_20_days
    FROM movies m
       INNER JOIN movie_attribute_date_service mads ON m.id = mads.movie_id
       INNER JOIN movie_attribute_types mat ON mads.attribute_type_id = mat.id
    GROUP BY m.title
    );
SELECT * FROM movie_service_info;