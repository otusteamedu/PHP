CREATE TABLE halls
(
    hall_id INT PRIMARY KEY GENERATED ALWAYS AS IDENTITY NOT NULL,
    name    VARCHAR(32)                                  NOT NULL
);
COMMENT ON TABLE halls IS ''Кинозады'';
COMMENT ON COLUMN halls.name IS ''Название зала'';

CREATE TABLE hall_places
(
    hall_place_id  INT PRIMARY KEY GENERATED ALWAYS AS IDENTITY NOT NULL,
    hall_id        INT REFERENCES halls (hall_id)               NOT NULL,
    hall_place_num INT                                          NOT NULL
);
COMMENT ON TABLE hall_places IS ''Места в кинозале'';
COMMENT ON COLUMN hall_places.hall_place_num IS ''Номер места в зале'';

CREATE TABLE film_sessions
(
    film_session_id INT PRIMARY KEY GENERATED ALWAYS AS IDENTITY NOT NULL,
    hall_id         INT REFERENCES halls (hall_id)               NOT NULL,
    name            VARCHAR(32)                                  NOT NULL,
    time_from       TIMESTAMP                                    NOT NULL,
    time_to         TIMESTAMP                                    NOT NULL
);

COMMENT ON TABLE film_sessions IS ''Сеансы'';
COMMENT ON COLUMN film_sessions.name IS ''Название фильма'';
COMMENT ON COLUMN film_sessions.time_from IS ''Начало фильма'';
COMMENT ON COLUMN film_sessions.time_to IS ''Конец фильма'';

CREATE TABLE place_prices
(
    place_price_id  INT PRIMARY KEY GENERATED ALWAYS AS IDENTITY   NOT NULL,
    place_id        INT REFERENCES hall_places (hall_place_id)     NOT NULL,
    film_session_id INT REFERENCES film_sessions (film_session_id) NOT NULL,
    price           FLOAT                                          NOT NULL
);

COMMENT ON TABLE place_prices IS ''Стоимость мест на сеансах'';

CREATE TABLE clients
(
    client_id  INT PRIMARY KEY GENERATED ALWAYS AS IDENTITY NOT NULL,
    first_name VARCHAR(32)                                  NOT NULL,
    last_name  VARCHAR(32)                                  NOT NULL,
    birth_date DATE
);

COMMENT ON TABLE clients IS ''Клиенты'';


CREATE TABLE orders
(
    order_id   INT PRIMARY KEY GENERATED ALWAYS AS IDENTITY   NOT NULL,
    client_id  INT REFERENCES clients (client_id)             NOT NULL,
    session_id INT REFERENCES film_sessions (film_session_id) NOT NULL,
    datetime   TIMESTAMP                                      NOT NULL DEFAULT now()
);

COMMENT ON TABLE orders IS ''Заказы'';

CREATE TABLE order_details
(
    order_detail_id INT PRIMARY KEY GENERATED ALWAYS AS IDENTITY   NOT NULL,
    order_id        INT REFERENCES orders (order_id)               NOT NULL,
    film_session_id INT REFERENCES film_sessions (film_session_id) NOT NULL,
    hall_place_id   INT REFERENCES hall_places (hall_place_id)     NOT NULL
);

COMMENT ON TABLE order_details IS ''Состав заказа'';
