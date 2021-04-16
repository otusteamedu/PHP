CREATE TABLE IF NOT EXISTS users (
    id SERIAL PRIMARY KEY,
    username varchar(50) UNIQUE NOT NULL,
    password varchar(50) NOT NULL,
    email varchar(255) UNIQUE NOT NULL,
    created_on timestamp NOT NULL,
    last_login timestamp
);