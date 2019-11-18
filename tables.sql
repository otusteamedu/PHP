-- создаем таблицы
CREATE TABLE orders (
  id SERIAL PRIMARY KEY,
  tickets INT,
  full_price MONEY);

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

CREATE TABLE tickets (
id SERIAL PRIMARY KEY,
order_id INT,
show_id INT,
status VARCHAR(10),
price MONEY,
tariff_id INT,
seat_number INT);

CREATE TABLE Tariffs (
id SERIAL PRIMARY KEY,
description VARCHAR(200),
price_factor NUMERIC(1,2));

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

INSERT INTO orders (show_id, tickets, full_price)
VALUES (1, 2, 450.70), (2, 10, 5000), (3, 1, 1500), (4, 5, 900);

INSERT INTO tariffs (description, price_factor)
VALUES 
('BASIC', 1.00)
('VIP', 2.50),
('Детский тариф - только по выходным', 0.5),
('Тариф для самых лояльных покупателей', 0.7);

INSERT INTO tickets (order_id, show_id, status, price, tariff_id, seat_number)
VALUES (1, 2, paid, 500, 3, 23), (2, 2, returned, 333, 1, 23)



