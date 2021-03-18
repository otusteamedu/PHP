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
    price      numeric(10, 2),
    created_at datetime,
    updated_at datetime
    );

CREATE TABLE if not exists ticket
(
    id               serial primary key,
    place_id         integer REFERENCES place (id),
    hall_id          integer REFERENCES hall (id),
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
    id  SERIAL PRIMARY KEY,
    row integer,
    col integer
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



# most commercial film
SELECT SUM(order.price) AS total_sum, f.name AS film_name
FROM booking
         LEFT JOIN `order` ON booking.order_id = `order`.id
         LEFT JOIN ticket ON `order`.ticket_id = ticket.id
         LEFT JOIN film_schedule fs on ticket.film_schedule_id = fs.id
         LEFT JOIN film f on fs.film_id = f.id
ORDER BY total_sum DESC
    LIMIT 1;