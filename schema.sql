CREATE TABLE cinema (
    id SERIAL,
    title VARCHAR(255) NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE hall (
	id SERIAL,
	cinema_id INT NOT NULL,
	title VARCHAR(255) NOT NULL,
	row_count INT NOT NULL,
	place_count INT NOT NULL,
	PRIMARY KEY (id),
	CONSTRAINT hall_cinema_fk
		FOREIGN KEY (cinema_id)
		REFERENCES cinema (id)
);

CREATE TABLE movie (
	id SERIAL,
	title VARCHAR(255) NOT NULL,
	PRIMARY KEY (id)
);

CREATE TABLE showtime (
	id SERIAL,
	hall_id INT NOT NULL,
	movie_id INT NOT NULL,
	date_start TIMESTAMP WITH TIME ZONE NOT NULL,
	date_end TIMESTAMP WITH TIME ZONE NOT NULL,
	PRIMARY KEY (id),
	CONSTRAINT showtime_hall_fk
		FOREIGN KEY (hall_id)
		REFERENCES hall (id),
	CONSTRAINT showtime_movie_fk
		FOREIGN KEY (movie_id)
		REFERENCES movie (id)
);


CREATE TABLE ticket (
	id SERIAL,
	showtime_id INT NOT NULL,
	price INT NOT NULL,
	hall_row INT NOT NULL,
	hall_place INT NOT NULL,
	available bool DEFAULT TRUE,
	sold bool,
	PRIMARY KEY (id),
	CONSTRAINT ticket_showtime_fk
		FOREIGN KEY (showtime_id)
		REFERENCES showtime (id),
	CONSTRAINT ticket_place_uq UNIQUE (showtime_id, hall_row, hall_place)
);

----------  HOMEWORK 9 ---------------

CREATE TABLE movie_attr_type (
    id SERIAL,
	name VARCHAR(255) NOT NULL,
	description TEXT,
	PRIMARY KEY (id)
);

INSERT INTO movie_attr_type (id, "name") VALUES
('1', 'text'),
('2', 'date'),
('3', 'boolean'),
('4', 'int'),
('5', 'float'),
('6', 'service_date')
;

CREATE TABLE movie_attr (
    id SERIAL,
	name VARCHAR(255) NOT NULL,
	type_id INTEGER NOT NULL,
	PRIMARY KEY (id),
	CONSTRAINT movie_attr_movie_attr_type_fk
		FOREIGN KEY (type_id)
		REFERENCES movie_attr_type (id)
);

CREATE UNIQUE INDEX movie_attr_name_unique ON movie_attr (lower(name));
CREATE INDEX movie_attr_type_id ON movie_attr (type_id);

CREATE TABLE movie_attr_value (
    id SERIAL,
    movie_id INTEGER NOT NULL,
    attr_id INTEGER NOT NULL,
	value_text VARCHAR,
    value_date DATE,
    value_bool BOOL,
    value_int INT,
    value_float NUMERIC,
	PRIMARY KEY (id),
	CONSTRAINT movie_attr_value_movie_fk
		FOREIGN KEY (movie_id)
		REFERENCES movie (id),
    CONSTRAINT movie_attr_value_movie_attr_fk
		FOREIGN KEY (attr_id)
		REFERENCES movie_attr (id)
);

CREATE INDEX movie_attr_value_movie_id ON movie_attr_value (movie_id);
CREATE INDEX movie_attr_value_attr_id ON movie_attr_value (attr_id);

CREATE OR REPLACE VIEW movie_service_info AS
(
	SELECT m.title,
		string_agg(CASE WHEN value_date = NOW()::date THEN ma."name" END, ', ') AS tasks_for_now,
		string_agg(CASE WHEN value_date = (NOW() + INTERVAL '20 days')::date THEN ma."name" END, ', ') AS tasks_for_20_now
	FROM movie m
		JOIN movie_attr_value mav ON m.id = mav.movie_id
		JOIN movie_attr ma ON ma.id = mav.attr_id
		JOIN movie_attr_type mat ON mat.id = ma.type_id
	WHERE mat."name" = 'service_date'
	GROUP BY m.title
);
SELECT * FROM movie_service_info;

CREATE OR REPLACE VIEW movie_common_info AS
(
	SELECT m.title, ma."name",
		CASE mat."name"
			WHEN 'text' THEN mav.value_text::TEXT
			WHEN 'date' THEN mav.value_date::TEXT
			WHEN 'boolean' THEN mav.value_bool::TEXT
			WHEN 'int' THEN mav.value_int::TEXT
			WHEN 'float' THEN mav.value_float::TEXT
		END AS value
	FROM movie m
		JOIN movie_attr_value mav ON m.id = mav.movie_id
		JOIN movie_attr ma ON ma.id = mav.attr_id
		JOIN movie_attr_type mat ON mat.id = ma.type_id
	WHERE mat."name" != 'service_date'
	ORDER BY m.title
);
SELECT * FROM movie_common_info;
