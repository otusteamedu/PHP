CREATE TABLE IF NOT EXISTS order_statuses (
    id SERIAL PRIMARY KEY,
    title varchar(50) UNIQUE NOT NULL
);