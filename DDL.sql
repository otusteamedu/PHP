DROP TABLE IF EXISTS tickets;
DROP TABLE IF EXISTS seances;
DROP TABLE IF EXISTS movies;
DROP TABLE IF EXISTS places;
DROP TABLE IF EXISTS rooms;


CREATE TABLE rooms
(
    id serial NOT NULL,
    name varchar(250) NOT NULL,
    CONSTRAINT rooms_pk PRIMARY KEY (id)
);

CREATE TABLE places
(
    id serial NOT NULL,
    room_id integer NOT NULL,
    row integer NOT NULL,
    place integer NOT NULL,
    CONSTRAINT places_pk PRIMARY KEY (id),
    CONSTRAINT places_room_fk FOREIGN KEY (room_id) REFERENCES rooms (id)
);

CREATE TABLE movies
(
    id serial NOT NULL,
    name varchar(250) NOT NULL,
    CONSTRAINT movies_pk PRIMARY KEY (id)
);

CREATE TABLE seances
(
    id serial NOT NULL,
    room_id integer NOT NULL,
    movie_id integer NOT NULL,
    price integer NOT NULL,
    CONSTRAINT seances_pk PRIMARY KEY (id),
    CONSTRAINT seances_rooms_fk FOREIGN KEY (room_id) REFERENCES rooms (id),
    CONSTRAINT seances_movies_fk FOREIGN KEY (movie_id) REFERENCES movies (id)
);

CREATE TABLE tickets
(
    id serial  NOT NULL,
    seance_id integer NOT NULL,
    place_id integer NOT NULL,
    CONSTRAINT tickets_pk PRIMARY KEY (id),
    CONSTRAINT tickets_seances_fk FOREIGN KEY (seance_id) REFERENCES seances (id),
    CONSTRAINT tickets_places_fk FOREIGN KEY (place_id) REFERENCES places (id)
);

CREATE OR REPLACE FUNCTION random_between(low INT ,high INT) 
   RETURNS INT AS
$$
BEGIN
   RETURN floor(random()* (high-low + 1) + low);
END;
$$ language 'plpgsql' STRICT;

	   
DO $room_insert$
BEGIN

	FOR room_num in 1..3 loop
		INSERT INTO rooms(name) 
		SELECT CONCAT('Кинозал №', '', room_num) AS name;
	END loop;
END;
$room_insert$;  
	   
DO $places_insert$
DECLARE
    rooms_count integer;
    rows_count integer = 12;
    places_count integer = 12;
BEGIN
	rooms_count := (SELECT count(id) FROM rooms);

	FOR room_id in 1..rooms_count loop
		FOR room_row in 1..rows_count loop
			FOR room_place in 1..places_count loop
				INSERT INTO places(room_id, row, place) 
				VALUES(room_id, room_row, room_place);
			END loop;
		END loop;
	END loop;
END;
$places_insert$;	

DO $movies_insert$
BEGIN

	FOR movie_num in 1..10 loop
		INSERT INTO movies(name) 
		SELECT CONCAT('Киношка №', '', movie_num) AS name;
	END loop;
END;
$movies_insert$;  

DO $seances_insert$
DECLARE
    rooms_count integer;
	movie_count integer;
	average_seances_per_room integer = 6;
BEGIN
	rooms_count := (SELECT count(id) FROM rooms);
	movie_count := (SELECT count(id) FROM movies);

	FOR col_seances in 1..rooms_count*average_seances_per_room loop
		INSERT INTO seances(room_id, movie_id, price) 
		SELECT
			random_between(1,rooms_count) AS room_id,
			random_between(1,movie_count) AS movie_id,
			random_between(500,3000) AS price;
	END loop;
END;
$seances_insert$; 

DO
$tickets_seeder$
DECLARE
    tickets_count integer = random_between(100, 1000);
    seance record;
    place record;
BEGIN
    FOR seance IN (SELECT id, room_id FROM seances) LOOP
        FOR place IN (SELECT id FROM places WHERE room_id = seance.room_id LIMIT tickets_count) LOOP
            INSERT INTO tickets (seance_id, place_id) VALUES (seance.id, place.id);
        END LOOP;
    END LOOP;
END
$tickets_seeder$;

SELECT m.id AS movie_id, m.name, SUM(s.price) as total_cost
FROM movies AS m
INNER JOIN seances AS s ON s.movie_id = m.id
INNER JOIN tickets AS t ON t.seance_id = s.id
GROUP BY m.id, m.name
ORDER BY total_cost DESC