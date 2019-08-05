CREATE DATABASE IF NOT EXISTS theater;
USE theater;

CREATE TABLE IF NOT EXISTS messages(
    id BINARY(16) PRIMARY KEY,
    message text NOT NULL,
    answer text,
    type TINYINT(4) UNSIGNED NOT NULL,
    status TINYINT(4) UNSIGNED NOT NULL
);

GRANT ALL PRIVILEGES ON theater.* TO 'crazydope'@'%';

