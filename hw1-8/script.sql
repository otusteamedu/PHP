DROP TABLE IF EXISTS booking CASCADE;
DROP TABLE IF EXISTS employee CASCADE;
DROP TABLE IF EXISTS "order" CASCADE;
DROP TABLE IF EXISTS ticket CASCADE;
DROP TABLE IF EXISTS hall CASCADE;
DROP TABLE IF EXISTS place CASCADE;
DROP TABLE IF EXISTS place_category CASCADE;
DROP TABLE IF EXISTS customer CASCADE;
DROP TABLE IF EXISTS film_schedule CASCADE;
DROP TABLE IF EXISTS film CASCADE;
DROP TABLE IF EXISTS film_schedule_place_price;


CREATE TABLE if not exists employee
(
    id              SERIAL PRIMARY KEY,
    name            VARCHAR(15),
    position        VARCHAR(15),
    start_work_date date
);

CREATE TABLE if not exists film
(
    id          serial primary key,
    name        varchar(127),
    year        varchar(20),
    country     varchar(127),
    description varchar(127)
);

CREATE TABLE if not exists hall
(
    id           SERIAL PRIMARY KEY,
    name         VARCHAR(15),
    limit_places integer
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
    phone      varchar(50),
    email      varchar(50),
    login      varchar(50),
    created_at date,
    updated_at date
);

CREATE TABLE if not exists film_schedule
(
    id          serial primary key,
    film_id     integer,
    start_at    time,
    finished_at time,
    CONSTRAINT fk_film_id FOREIGN KEY (film_id) REFERENCES film (id) ON DELETE CASCADE
);

CREATE TABLE if not exists place
(
    id                SERIAL PRIMARY KEY,
    row               integer,
    col               integer,
    hall_id           integer,
    place_category_id integer,
    CONSTRAINT fk_hall_id FOREIGN KEY (hall_id) REFERENCES hall (id) ON DELETE CASCADE,
    CONSTRAINT fk_place_category_id FOREIGN KEY (place_category_id) REFERENCES place_category (id) ON DELETE CASCADE
);

CREATE TABLE if not exists ticket
(
    id               serial primary key,
    place_id         integer,
    film_schedule_id integer,
    customer_id      integer,
    date             date,
    CONSTRAINT fk_place_id FOREIGN KEY (place_id) REFERENCES place (id) ON DELETE CASCADE,
    CONSTRAINT fk_film_schedule_id FOREIGN KEY (film_schedule_id) REFERENCES film_schedule (id) ON DELETE CASCADE,
    CONSTRAINT fk_customer_id FOREIGN KEY (customer_id) REFERENCES customer (id) ON DELETE CASCADE
);

CREATE TABLE if not exists "order"
(
    id         serial primary key,
    ticket_id  integer,
    created_at date,
    updated_at date,
    CONSTRAINT fk_ticket_id FOREIGN KEY (ticket_id) REFERENCES ticket (id) ON DELETE CASCADE
);

CREATE TABLE if not exists booking
(
    id          SERIAL PRIMARY KEY,
    order_id    integer,
    employee_id integer,
    created_at  date,
    updated_at  date,
    CONSTRAINT fk_order_id FOREIGN KEY (order_id) REFERENCES "order" (id) ON DELETE CASCADE,
    CONSTRAINT fk_employee_id FOREIGN KEY (employee_id) REFERENCES employee (id) ON DELETE CASCADE
);

CREATE TABLE if not exists film_schedule_place_price
(
    id                serial primary key,
    film_schedule_id  integer REFERENCES film_schedule (id),
    place_category_id integer REFERENCES place_category (id),
    price             numeric(5, 2),
    CONSTRAINT fk_film_schedule_id FOREIGN KEY (film_schedule_id) REFERENCES film_schedule (id) ON DELETE CASCADE,
    CONSTRAINT fk_place_category_id FOREIGN KEY (place_category_id) REFERENCES place_category (id) ON DELETE CASCADE
);