CREATE DATABASE cinema;
CREATE TABLE cinema.movies
(
    `id`   int PRIMARY KEY AUTO_INCREMENT,
    `name` varchar(255) NOT NULL
);

CREATE TABLE cinema.seances
(
    `id`       int PRIMARY KEY AUTO_INCREMENT,
    `start_at` datetime NOT NULL,
    `end_at`   datetime NOT NULL,
    `movie_id` int       NOT NULL,
    `hall_id`  int       NOT NULL
);

CREATE TABLE cinema.halls
(
    `id`   int PRIMARY KEY AUTO_INCREMENT,
    `name` varchar(255) NOT NULL
);

CREATE TABLE cinema.seats_type
(
    `id`   int PRIMARY KEY AUTO_INCREMENT,
    `code` varchar(255) NOT NULL
);

CREATE TABLE cinema.seats
(
    `id`      int PRIMARY KEY AUTO_INCREMENT,
    `row`     int NOT NULL,
    `number`  int NOT NULL,
    `hall_id` int NOT NULL,
    `type_id` int NOT NULL
);

CREATE TABLE cinema.seats_price
(
    `id`           int PRIMARY KEY AUTO_INCREMENT,
    `seance_id`     int NOT NULL,
    `seat_type_id` int NOT NULL,
    `price`        int NOT NULL
);

CREATE TABLE cinema.tickets
(
    `id`          int PRIMARY KEY AUTO_INCREMENT,
    `seat_id`     int,
    `seance_id`   int NOT NULL,
    `customer_id` int NOT NULL
);

CREATE TABLE cinema.customers
(
    `id`   int PRIMARY KEY AUTO_INCREMENT,
    `name` varchar(255) NOT NULL
);

ALTER TABLE cinema.seances
    ADD FOREIGN KEY (`movie_id`) REFERENCES cinema.movies (`id`);

ALTER TABLE cinema.seances
    ADD FOREIGN KEY (`hall_id`) REFERENCES cinema.halls (`id`);

ALTER TABLE cinema.seats
    ADD FOREIGN KEY (`hall_id`) REFERENCES cinema.halls (`id`);

ALTER TABLE cinema.seats
    ADD FOREIGN KEY (`type_id`) REFERENCES cinema.seats_type (`id`);

ALTER TABLE cinema.seats_price
    ADD FOREIGN KEY (`seance_id`) REFERENCES cinema.seances (`id`);

ALTER TABLE cinema.seats_price
    ADD FOREIGN KEY (`seat_type_id`) REFERENCES cinema.seats_type (`id`);