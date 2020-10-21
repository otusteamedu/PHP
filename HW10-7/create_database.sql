-- ---
-- Table 'films'
-- Фильмы, показываемые в кинотеатре
-- ---

DROP TABLE IF EXISTS films CASCADE;

CREATE TABLE films (
  id SERIAL,
  title TEXT NOT NULL,
  description TEXT NOT NULL,
  status SMALLINT NOT NULL DEFAULT 1,
  duration_minutes SMALLINT NOT NULL,
  PRIMARY KEY (id)
);

-- ---
-- Table 'cinema_halls'
-- Кинозалы
-- ---

DROP TABLE IF EXISTS cinema_halls CASCADE;

CREATE TABLE cinema_halls (
  id SERIAL,
  title TEXT NOT NULL,
  description TEXT NOT NULL,
  quanity_of_places INTEGER NOT NULL,
  status SMALLINT NOT NULL DEFAULT 1,
  PRIMARY KEY (id)
);

-- ---
-- Table 'row'
-- Ряд
-- ---

DROP TABLE IF EXISTS row CASCADE;

CREATE TABLE row (
  id SERIAL,
  number SMALLINT NOT NULL,
  hall_id INTEGER NOT NULL,
  status SMALLINT NOT NULL DEFAULT 1,
  PRIMARY KEY (id),
  FOREIGN KEY (hall_id) REFERENCES cinema_halls (id) ON DELETE CASCADE
);

-- ---
-- Table 'places'
-- Место в зале
-- ---

DROP TABLE IF EXISTS places CASCADE;

CREATE TABLE places (
  id SERIAL,
  number INTEGER NOT NULL,
  row_id INTEGER NOT NULL,
  status SMALLINT NOT NULL DEFAULT 1,
  PRIMARY KEY (id),
  FOREIGN KEY (row_id) REFERENCES row (id) ON DELETE CASCADE
);

-- ---
-- Table 'film_sessions'
-- Сеансы показа фильма
-- ---

DROP TABLE IF EXISTS film_sessions CASCADE;

CREATE TABLE film_sessions (
  id SERIAL,
  film_id INTEGER NOT NULL,
  hall_id INTEGER NOT NULL,
  session_start TIMESTAMP NOT NULL,
  session_end TIMESTAMP NOT NULL,
  session_duration INTEGER NOT NULL,
  PRIMARY KEY (id),
  FOREIGN KEY (hall_id) REFERENCES cinema_halls (id) ON DELETE CASCADE,
  FOREIGN KEY (film_id) REFERENCES films (id) ON DELETE CASCADE
);

-- ---
-- Table 'clients'
-- Клиенты
-- ---

DROP TABLE IF EXISTS clients CASCADE;

CREATE TABLE clients (
  id SERIAL,
  first_name TEXT NOT NULL,
  last_name TEXT NULL DEFAULT NULL,
  middle_name TEXT NOT NULL,
  email VARCHAR(255) NOT NULL,
  phone VARCHAR(20) NOT NULL,
  status SMALLINT NOT NULL DEFAULT 1,
  PRIMARY KEY (id)
);

-- ---
-- Table 'orders'
-- Покупки
-- ---

DROP TABLE IF EXISTS orders CASCADE;

CREATE TABLE orders (
  id SERIAL,
  client_id INTEGER NOT NULL,
  amount MONEY NOT NULL,
  status SMALLINT NOT NULL DEFAULT 1,
  PRIMARY KEY (id),
  FOREIGN KEY (client_id) REFERENCES clients (id) ON DELETE CASCADE
);

-- ---
-- Table 'tickets'
-- Билеты
-- ---

DROP TABLE IF EXISTS tickets CASCADE;

CREATE TABLE tickets (
  id SERIAL,
  order_id INTEGER NOT NULL,
  cost MONEY NOT NULL,
  session_id INTEGER NOT NULL,
  place_id INTEGER NOT NULL,
  PRIMARY KEY (id),
  FOREIGN KEY (place_id) REFERENCES places (id) ON DELETE CASCADE,
  FOREIGN KEY (session_id) REFERENCES film_sessions (id) ON DELETE CASCADE,
  FOREIGN KEY (order_id) REFERENCES orders (id) ON DELETE CASCADE
);

-- ---
-- Table 'prices'
-- Цены
-- ---

DROP TABLE IF EXISTS prices CASCADE;

CREATE TABLE prices (
  id SERIAL,
  ticket_cost MONEY NOT NULL,
  session_id INTEGER NOT NULL,
  place_id INTEGER NOT NULL,
  PRIMARY KEY (id),
  FOREIGN KEY (place_id) REFERENCES places (id) ON DELETE CASCADE,
  FOREIGN KEY (session_id) REFERENCES film_sessions (id) ON DELETE CASCADE
);

-- ---
-- Table 'payments'
-- Платежи
-- ---

DROP TABLE IF EXISTS payments CASCADE;

CREATE TABLE payments (
  id SERIAL,
  order_id INTEGER NOT NULL,
  payment_date TIMESTAMP NOT NULL,
  payment_type SMALLINT NOT NULL,
  payment_amount MONEY NOT NULL,
  status SMALLINT NOT NULL DEFAULT 1,
  PRIMARY KEY (id),
  FOREIGN KEY (order_id) REFERENCES orders (id) ON DELETE CASCADE
);



