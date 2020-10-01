#!/bin/bash
set -e

psql -v ON_ERROR_STOP=1 --username otus --dbname otus -c <<-EOSQL
INSERT INTO films (name, description, duration, age_limit)
VALUES ('Фильм 1', 'Описание 1', 120, 6);
INSERT INTO films (name, description, duration, age_limit)
VALUES ('Фильм 2', 'Описание 2', 120, 6);
INSERT INTO films (name, description, duration, age_limit)
VALUES ('Фильм 3', 'Описание 3', 120, 12);
INSERT INTO films (name, description, duration, age_limit)
VALUES ('Фильм 4', 'Описание 4', 120, 18);
INSERT INTO films (name, description, duration, age_limit)
VALUES ('Фильм 5', 'Описание 5', 120, 21);

INSERT INTO seances (film_id, price, start_at)
VALUES (1, 300, '2020-09-15 12:00:00');
INSERT INTO seances (film_id, price, start_at)
VALUES (3, 250, '2020-09-15 15:00:00');
INSERT INTO seances (film_id, price, start_at)
VALUES (2, 400, '2020-09-15 16:00:00');
INSERT INTO seances (film_id, price, start_at)
VALUES (5, 750, '2020-09-15 18:30:00');
EOSQL
