/* film */
DROP TABLE IF EXISTS film CASCADE;
CREATE TABLE film (
  film_id SERIAL PRIMARY KEY,
  film_name VARCHAR(255),
  film_budget NUMERIC(13,2),
  film_runtime VARCHAR(40),
  film_world_premier_date TIMESTAMP,
  film_imdb FLOAT
);

INSERT INTO film (film_name, film_budget, film_runtime, film_world_premier_date, film_imdb) VALUES ('The Shawshank Redemption', '25000000', '142 min', '14 October 1994', '9.3');
INSERT INTO film (film_name, film_budget, film_runtime, film_world_premier_date, film_imdb) VALUES ('The Godfather', '6000000', '175 min', '24 March 1972', '9.2');
INSERT INTO film (film_name, film_budget, film_runtime, film_world_premier_date, film_imdb) VALUES ('The Dark Knight', '185000000', '152 min', '14 August 2008', '9.3');
INSERT INTO film (film_name, film_budget, film_runtime, film_world_premier_date, film_imdb) VALUES ('The Lord of the Rings: The Return of the King', '94000000', '201 min', '21 December 2003', '8.9');

/* client */
DROP TABLE IF EXISTS client CASCADE;
CREATE TABLE client (
  client_id SERIAL PRIMARY KEY,
  client_name VARCHAR(255),
  client_surname VARCHAR(255),
  client_phone VARCHAR(20),
  client_email VARCHAR(320)
);

INSERT INTO client (client_name, client_surname, client_phone, client_email) VALUES ('Ivan', 'Ivanov', '+733(585)865-47-21', 'nudif@mailinator.com');
INSERT INTO client (client_name, client_surname, client_phone, client_email) VALUES ('Petr', 'Petrov', '+709(232)216-89-57', 'dyhiqyl@mailinator.net');
INSERT INTO client (client_name, client_surname, client_phone, client_email) VALUES ('Sergey', 'Sergeev', '+704(23)634-70-56', 'vemahyfaw@mailinator.com');
INSERT INTO client (client_name, client_surname, client_phone, client_email) VALUES ('Alexandr', 'Alexandrov', '+757(907)106-47-03', 'warimidul@mailinator.com');
INSERT INTO client (client_name, client_surname, client_phone, client_email) VALUES ('Ivan1', 'Ivanov1', '+733(585)865-47-20', 'nudif1@mailinator.com');
INSERT INTO client (client_name, client_surname, client_phone, client_email) VALUES ('Petr1', 'Petrov1', '+709(232)216-89-50', 'dyhiqyl1@mailinator.net');
INSERT INTO client (client_name, client_surname, client_phone, client_email) VALUES ('Sergey1', 'Sergeev1', '+704(23)634-70-50', 'vemahyfaw1@mailinator.com');
INSERT INTO client (client_name, client_surname, client_phone, client_email) VALUES ('Alexandr1', 'Alexandrov1', '+757(907)106-47-00', 'warimidul1@mailinator.com');

/* hall */
DROP TABLE IF EXISTS hall CASCADE;
CREATE TABLE hall (
  hall_id SERIAL PRIMARY KEY,
  hall_title VARCHAR(255),
  hall_status INT DEFAULT 0
);

INSERT INTO hall (hall_title, hall_status) VALUES ('a', 1);
INSERT INTO hall (hall_title, hall_status) VALUES ('b', 1);
INSERT INTO hall (hall_title, hall_status) VALUES ('c', 1);
INSERT INTO hall (hall_title, hall_status) VALUES ('d', 0);

/* session */
DROP TABLE IF EXISTS session CASCADE;
CREATE TABLE session (
  session_id SERIAL PRIMARY KEY,
	film_id INT,
  session_cost NUMERIC(6,2),
  session_start_time TIMESTAMP,
  session_status INT DEFAULT 0,
	CONSTRAINT fk_session_film_id
      FOREIGN KEY (film_id)
          REFERENCES film(film_id)
					ON DELETE CASCADE
);

INSERT INTO session (film_id, session_cost, session_start_time, session_status) VALUES (1, 300.00, '07 September 2020 10:00', 1);
INSERT INTO session (film_id, session_cost, session_start_time, session_status) VALUES (2, 320.00, '07 September 2020 10:20', 1);
INSERT INTO session (film_id, session_cost, session_start_time, session_status) VALUES (3, 330.00, '07 September 2020 10:30', 1);
INSERT INTO session (film_id, session_cost, session_start_time, session_status) VALUES (4, 340.00, '07 September 2020 10:35', 1);
INSERT INTO session (film_id, session_cost, session_start_time, session_status) VALUES (1, 300.00, '07 September 2020 13:00', 1);
INSERT INTO session (film_id, session_cost, session_start_time, session_status) VALUES (2, 320.00, '07 September 2020 13:20', 1);
INSERT INTO session (film_id, session_cost, session_start_time, session_status) VALUES (3, 330.00, '07 September 2020 13:30', 1);
INSERT INTO session (film_id, session_cost, session_start_time, session_status) VALUES (4, 340.00, '07 September 2020 13:35', 1);
INSERT INTO session (film_id, session_cost, session_start_time, session_status) VALUES (1, 400.00, '07 September 2020 18:00', 1);
INSERT INTO session (film_id, session_cost, session_start_time, session_status) VALUES (2, 420.00, '07 September 2020 18:20', 1);
INSERT INTO session (film_id, session_cost, session_start_time, session_status) VALUES (3, 430.00, '07 September 2020 18:30', 1);
INSERT INTO session (film_id, session_cost, session_start_time, session_status) VALUES (4, 440.00, '07 September 2020 18:35', 1);
INSERT INTO session (film_id, session_cost, session_start_time, session_status) VALUES (1, 300.00, '07 September 2020 22:00', 1);
INSERT INTO session (film_id, session_cost, session_start_time, session_status) VALUES (2, 320.00, '07 September 2020 22:20', 1);
INSERT INTO session (film_id, session_cost, session_start_time, session_status) VALUES (3, 330.00, '07 September 2020 22:30', 1);
INSERT INTO session (film_id, session_cost, session_start_time, session_status) VALUES (4, 340.00, '07 September 2020 22:35', 0);

DROP TABLE IF EXISTS hall_session;
CREATE TABLE hall_session (
  hall_id INT,
  session_id INT,
  CONSTRAINT fk_hall_session_hall_id
      FOREIGN KEY (hall_id)
          REFERENCES hall(hall_id)
					ON DELETE CASCADE,
  CONSTRAINT fk_hall_session_session_id
      FOREIGN KEY (session_id)
          REFERENCES session(session_id)
					ON DELETE CASCADE
);

INSERT INTO hall_session (hall_id, session_id) VALUES (1, 1);
INSERT INTO hall_session (hall_id, session_id) VALUES (1, 2);
INSERT INTO hall_session (hall_id, session_id) VALUES (1, 3);
INSERT INTO hall_session (hall_id, session_id) VALUES (1, 4);
INSERT INTO hall_session (hall_id, session_id) VALUES (1, 5);
INSERT INTO hall_session (hall_id, session_id) VALUES (1, 6);
INSERT INTO hall_session (hall_id, session_id) VALUES (1, 7);
INSERT INTO hall_session (hall_id, session_id) VALUES (1, 8);
INSERT INTO hall_session (hall_id, session_id) VALUES (1, 9);
INSERT INTO hall_session (hall_id, session_id) VALUES (1, 10);
INSERT INTO hall_session (hall_id, session_id) VALUES (1, 11);
INSERT INTO hall_session (hall_id, session_id) VALUES (1, 12);
INSERT INTO hall_session (hall_id, session_id) VALUES (1, 13);
INSERT INTO hall_session (hall_id, session_id) VALUES (1, 14);
INSERT INTO hall_session (hall_id, session_id) VALUES (1, 15);

DROP TABLE IF EXISTS session_client;
CREATE TABLE session_client (
  session_id INT,
  client_id INT,
  CONSTRAINT fk_session_client_session_id
      FOREIGN KEY (session_id)
          REFERENCES session(session_id)
					ON DELETE CASCADE,
  CONSTRAINT fk_session_client_client_id
      FOREIGN KEY (client_id)
          REFERENCES client(client_id)
					ON DELETE CASCADE
);

INSERT INTO session_client (session_id, client_id) VALUES (1, 1);
INSERT INTO session_client (session_id, client_id) VALUES (1, 2);
INSERT INTO session_client (session_id, client_id) VALUES (1, 3);
INSERT INTO session_client (session_id, client_id) VALUES (1, 4);
INSERT INTO session_client (session_id, client_id) VALUES (3, 5);
INSERT INTO session_client (session_id, client_id) VALUES (3, 6);
INSERT INTO session_client (session_id, client_id) VALUES (3, 7);
INSERT INTO session_client (session_id, client_id) VALUES (3, 8);
INSERT INTO session_client (session_id, client_id) VALUES (9, 1);
INSERT INTO session_client (session_id, client_id) VALUES (9, 2);
INSERT INTO session_client (session_id, client_id) VALUES (9, 3);
INSERT INTO session_client (session_id, client_id) VALUES (9, 4);
INSERT INTO session_client (session_id, client_id) VALUES (9, 5);
INSERT INTO session_client (session_id, client_id) VALUES (9, 6);
INSERT INTO session_client (session_id, client_id) VALUES (9, 7);
INSERT INTO session_client (session_id, client_id) VALUES (9, 8);
INSERT INTO session_client (session_id, client_id) VALUES (15, 5);
INSERT INTO session_client (session_id, client_id) VALUES (15, 6);
INSERT INTO session_client (session_id, client_id) VALUES (15, 7);
INSERT INTO session_client (session_id, client_id) VALUES (15, 8);


/* history */
DROP TABLE IF EXISTS history;
CREATE TABLE history (
  history_id SERIAL PRIMARY KEY,
  session_id INT,
  total NUMERIC(10,2),
  CONSTRAINT fk_session
      FOREIGN KEY (session_id)
          REFERENCES session(session_id)
					ON DELETE CASCADE
);
--
INSERT INTO history (session_id, total) VALUES (9, 80000);
INSERT INTO history (session_id, total) VALUES (10, 84000);
INSERT INTO history (session_id, total) VALUES (11, 86000);
INSERT INTO history (session_id, total) VALUES (12, 88000);
INSERT INTO history (session_id, total) VALUES (13, 24000);
INSERT INTO history (session_id, total) VALUES (14, 19800);
INSERT INTO history (session_id, total) VALUES (15, 25600);

/* max total and film */
SELECT h.total as total, f.film_name as film_name FROM film f LEFT JOIN session s ON (f.film_id = s.film_id) LEFT JOIN history h ON (s.session_id = h.history_id) WHERE total = (SELECT MAX(total) FROM history)