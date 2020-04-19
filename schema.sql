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
