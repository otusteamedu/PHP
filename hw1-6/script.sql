DROP TABLE IF EXISTS booking;
DROP TABLE IF EXISTS employee;
DROP TABLE IF EXISTS `order`;
DROP TABLE IF EXISTS ticket;
DROP TABLE IF EXISTS hall;
DROP TABLE IF EXISTS place;
DROP TABLE IF EXISTS place_category;
DROP TABLE IF EXISTS customer;
DROP TABLE IF EXISTS film_schedule;
DROP TABLE IF EXISTS film_schedule_place_price;
DROP TABLE IF EXISTS film;

CREATE TABLE if not exists booking
(
    id          SERIAL PRIMARY KEY,
    order_id    integer REFERENCES `order` (id),
    employee_id integer REFERENCES employee (id),
    created_at  datetime,
    updated_at  datetime
    );

CREATE TABLE if not exists employee
(
    id              SERIAL PRIMARY KEY,
    name            VARCHAR(15),
    position        VARCHAR(15),
    start_work_date date
    );

CREATE TABLE if not exists `order`
(
    id         serial primary key,
    ticket_id  integer REFERENCES ticket (id),
    created_at datetime,
    updated_at datetime
    );

CREATE TABLE if not exists ticket
(
    id               serial primary key,
    place_id         integer REFERENCES place (id),
    film_schedule_id integer REFERENCES film_schedule (id),
    customer_id      integer REFERENCES customer (id),
    date             date
    );

CREATE TABLE if not exists hall
(
    id           SERIAL PRIMARY KEY,
    name         VARCHAR(15),
    limit_places integer
    );

CREATE TABLE if not exists place
(
    id                SERIAL PRIMARY KEY,
    row               integer,
    col               integer,
    hall_id           integer REFERENCES hall (id),
    place_category_id integer REFERENCES place_category (id)
    );

CREATE TABLE if not exists place_category
(
    id       SERIAL PRIMARY KEY,
    category VARCHAR(25)
    );

CREATE TABLE if not exists customer
(
    id         serial primary key,
    name       varchar(50),
    phone      varchar(10),
    email      varchar(20),
    login      varchar(10),
    created_at datetime,
    updated_at datetime
    );

CREATE TABLE if not exists film
(
    id          serial primary key,
    name        varchar(127),
    year        varchar(10),
    country     varchar(127),
    description varchar(127)
    );

CREATE TABLE if not exists film_schedule
(
    id          serial primary key,
    film_id     integer REFERENCES film (id),
    start_at    time,
    finished_at time
    );

CREATE TABLE if not exists film_schedule_place_price
(
    id                serial primary key,
    film_schedule_id  integer REFERENCES film_schedule (id),
    place_category_id integer REFERENCES place_category (id),
    price             numeric(5, 2)
    );

SELECT film.name, earnings.money
FROM film
         LEFT JOIN (SELECT film_schedule.film_id, SUM(fspp.price) as money
                    FROM ticket
                             LEFT JOIN film_schedule ON film_schedule.id = ticket.film_schedule_id
                             LEFT JOIN place p ON ticket.place_id = p.id
                             LEFT JOIN film_schedule_place_price AS fspp ON film_schedule.id = fspp.film_schedule_id
                    WHERE fspp.price IS NOT NULL
                    GROUP BY film_schedule.film_id) AS earnings
                   ON film.id = earnings.film_id
ORDER BY earnings.money DESC
    LIMIT 1;