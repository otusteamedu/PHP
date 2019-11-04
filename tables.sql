-- создаем таблицы
CREATE TABLE orders (
  id SERIAL PRIMARY KEY,
  show_id INT,
  tickets INT);

CREATE TABLE shows (
id SERIAL PRIMARY KEY,
date DATE,
start_time TIME,
movie_id INT,
room_id INT,
price MONEY);

CREATE TABLE movies (
id SERIAL PRIMARY KEY,
name VARCHAR(50),
description VARCHAR(200),
length INTERVAL);

CREATE TABLE rooms (
id SERIAL PRIMARY KEY,
name VARCHAR(50),
description VARCHAR(200));

--наполняем их данными
INSERT INTO movies (name, description, length)
VALUES 
('Joker', 'hahahaha', '2 hours'),
('Batman', 'I am the nigth', '3 hours 20 minutes'),
('Judge DREDD', 'I am the LAW', '1 hour 45 minutes');

INSERT INTO rooms (name, description)
VALUES 
('Большой зал', 'Лучший зал с огромным экраном'),
('Малый зал', 'Тут показывают артхаус'),
('Зал 3', 'Это зал номер 3, чего вы еще ожидали');

INSERT INTO shows (
	date,
start_time,
movie_id,
room_id,
price)
VALUES
('2019-11-10', '10:00', 1, 1, 450.70),
('2019-11-10', '10:00', 2, 1, 123.70),
('2019-11-10', '10:00', 3, 1, 200),
('2019-11-10', '10:00', 2, 2, 800),
('2019-11-10', '10:00', 3, 1, 115);

INSERT INTO orders (show_id, tickets)
VALUES (1, 2), (2, 10), (3, 1), (4, 5), (5, 2), (1, 4);
