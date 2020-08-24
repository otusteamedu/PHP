CREATE TABLE IF NOT EXISTS Halls (
  id SERIAL PRIMARY KEY,
  count_places INT NOT NULL
);

INSERT INTO Halls VALUES
    (DEFAULT , 5),
    (DEFAULT , 7),
    (DEFAULT , 6);

CREATE TABLE IF NOT EXISTS Places (
  id SERIAL PRIMARY KEY,
  row INT NOT NULL,
  place INT NOT NULL,
  cost DOUBLE NOT NULL,
  hall_id INT NOT NULL,
  CONSTRAINT Places_hall_id_foreign FOREIGN KEY (hall_id) REFERENCES Halls (id)
);
INSERT INTO Places VALUES
    (DEFAULT, 1, 1, 400, 1),
    (DEFAULT, 1, 2, 400, 1),
    (DEFAULT, 1, 3, 400, 1),
    (DEFAULT, 1, 4, 400, 1),
    (DEFAULT, 1, 5, 400, 1),
    (DEFAULT, 1, 1, 200, 2),
    (DEFAULT, 1, 2, 200, 2),
    (DEFAULT, 1, 3, 200, 2),
    (DEFAULT, 1, 4, 200, 2),
    (DEFAULT, 1, 5, 200, 2),
    (DEFAULT, 1, 6, 200, 2),
    (DEFAULT, 1, 7, 200, 2),
    (DEFAULT, 1, 1, 100, 3),
    (DEFAULT, 1, 2, 100, 3),
    (DEFAULT, 1, 3, 100, 3),
    (DEFAULT, 1, 4, 100, 3),
    (DEFAULT, 1, 5, 100, 3),
    (DEFAULT, 1, 6, 100, 3);

CREATE TABLE IF NOT EXISTS Films ( 
  id SERIAL PRIMARY KEY,
  title VARCHAR (255) NOT NULL,
  duration INT NOT NULL
);
INSERT INTO Places VALUES
    (DEFAULT, film_name1, 2.00),
    (DEFAULT, film_name2, 2.10),
    (DEFAULT, film_name3, 2.20),
    (DEFAULT, film_name4, 2.30),
    (DEFAULT, film_name5, 2.40),
    (DEFAULT, film_name6, 2.50),
    (DEFAULT, film_name7, 3.00);


CREATE TABLE IF NOT EXISTS Sessions ( 
  id SERIAL PRIMARY KEY,
  hall_id INT NOT NULL,
  total_tickets INT NOT NULL,
  total_tickets_free INT NOT NULL,
  film_id INT NOT NULL,
  profit INT NOT NULL,
  CONSTRAINT Sessions_film_id_foreign FOREIGN KEY (film_id) REFERENCES Films (id),
  CONSTRAINT Sessions_hall_id_foreign FOREIGN KEY (hall_id) REFERENCES Halls (id)
);
INSERT INTO Sessions VALUES
    (DEFAULT, 1, 5, 0, 1, 2000),
    (DEFAULT, 1, 5, 0, 2, 1400),
    (DEFAULT, 1, 5, 0, 3, 600),
    (DEFAULT, 1, 5, 0, 1, 2000);


CREATE TABLE IF NOT EXISTS Tickets (
  id SERIAL PRIMARY KEY,
  hall_id INT NOT NULL,
  place_id INT NOT NULL,
  session_id INT NOT NULL,
  CONSTRAINT Tickets_place_id_foreign FOREIGN KEY (place_id) REFERENCES Places (id),
  CONSTRAINT Tickets_session_id_foreign FOREIGN KEY (session_id) REFERENCES Sessions (id)
);
INSERT INTO Tickets VALUES
    (DEFAULT, 1, 1, 1),
    (DEFAULT, 1, 2, 1),
    (DEFAULT, 1, 3, 1),
    (DEFAULT, 1, 4, 1),
    (DEFAULT, 2, 1, 2),
    (DEFAULT, 2, 2, 2),
    (DEFAULT, 2, 3, 2),
    (DEFAULT, 2, 4, 2),
    (DEFAULT, 2, 5, 2),
    (DEFAULT, 2, 6, 2),
    (DEFAULT, 2, 7, 2),
    (DEFAULT, 3, 1, 3),
    (DEFAULT, 3, 1, 3),
    (DEFAULT, 3, 2, 3),
    (DEFAULT, 3, 3, 3),
    (DEFAULT, 3, 4, 3),
    (DEFAULT, 3, 5, 3),
    (DEFAULT, 3, 6, 3),
    (DEFAULT, 1, 1, 4),
    (DEFAULT, 1, 2, 4),
    (DEFAULT, 1, 3, 4),
    (DEFAULT, 1, 4, 4),
    (DEFAULT, 1, 5, 4);
