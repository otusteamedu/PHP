CREATE TABLE IF NOT EXISTS orders (
    id SERIAL PRIMARY KEY,
    event_id integer NOT NULL REFERENCES events,
    place_id integer NULL REFERENCES places,
    order_status_id integer NOT NULL REFERENCES order_statuses,
    user_id integer NULL REFERENCES users,
    datetime timestamp NOT NULL,
    price real NULL CHECK (price >= 0),
    UNIQUE (event_id, place_id)
);