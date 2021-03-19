CREATE
EXTENSION IF NOT EXISTS "uuid-ossp";
DROP TYPE IF EXISTS STATUSES;
CREATE type STATUSES AS ENUM ('reserved', 'available', 'sold', 'refund');

CREATE TABLE cinemas
(
    id    INT GENERATED ALWAYS AS IDENTITY,
    title VARCHAR(255) NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE halls
(
    id        INT GENERATED ALWAYS AS IDENTITY,
    cinema_id INT,
    number    INT          NOT NULL,
    title     VARCHAR(255) NOT NULL,
    PRIMARY KEY (id),
    CONSTRAINT cinema_hall_to_cinema
        FOREIGN KEY (cinema_id)
            REFERENCES cinemas (id)
);

CREATE TABLE hall_seats
(
    id                     INT NOT NULL GENERATED ALWAYS AS IDENTITY,
    PRIMARY KEY (id),
    hall_id                INT NOT NULL,
    "row_number"           INT NOT NULL,
    seat_number            INT NOT NULL,
    seat_price_modificator float default 0,
    CONSTRAINT hall_seats_to_halls FOREIGN KEY (hall_id) REFERENCES halls (id)
);

CREATE TABLE movies
(
    id         INT GENERATED ALWAYS AS IDENTITY,
    title      varchar(255) NOT NULL,
    slogan     varchar(255),
    base_price INT default 0,
    PRIMARY KEY (id)
);

CREATE TABLE sessions
(
    id                        INT GENERATED ALWAYS AS IDENTITY,
    hall_id                   INT          NOT NULL,
    movie_id                  INT          NOT NULL,
    title                     VARCHAR(255) NOT NULL,
    start_time                timestamp    not null,
    end_time                  timestamp    not null,
    session_price_modificator float default 0,
    PRIMARY KEY (id),
    CONSTRAINT movie_session_to_hall
        FOREIGN KEY (hall_id)
            REFERENCES halls (id),
    CONSTRAINT movie_session_to_movie
        FOREIGN KEY (movie_id)
            REFERENCES movies (id)
);

CREATE TABLE tickets
(
    id                INT GENERATED ALWAYS AS IDENTITY,
    session_id        INT NOT NULL,
    hall_seat_id      INT NOT NULL,
    ticket_identifier uuid        default uuid_generate_v4(),
    status            STATUSES    default 'available',
    created_at        timestamptz default now(),
    updated_at        timestamptz default now(),
    PRIMARY KEY (id),
    CONSTRAINT ticket_to_session
        FOREIGN KEY (session_id)
            REFERENCES sessions (id),
    CONSTRAINT ticket_to_hall_seat
        FOREIGN KEY (hall_seat_id)
            REFERENCES hall_seats (id)
);

create table employees
(
    id          INT GENERATED ALWAYS AS IDENTITY,
    PRIMARY KEY (id),
    last_name   varchar(255),
    first_name  varchar(255),
    middle_name varchar(255),
    position    varchar(100)
);

CREATE TABLE orders
(
    id          INT GENERATED ALWAYS AS IDENTITY,
    PRIMARY KEY (id),
    ticket_id   INT NOT NULL,
    employee_id INT NOT NULL,
    created_at  timestamptz default now(),
    updated_at  timestamptz default now(),
    CONSTRAINT order_to_ticket
        FOREIGN KEY (ticket_id)
            REFERENCES tickets (id),
    CONSTRAINT order_to_employee
        FOREIGN KEY (employee_id)
            REFERENCES employees (id)
);

create VIEW prices as
select tickets.id  as ticket_id,
       session_id,
       hall_seat_id,
       base_price,
       seat_price_modificator,
       session_price_modificator,
       (base_price * seat_price_modificator * session_price_modificator) as ticket_price
from tickets
         left join hall_seats on hall_seats.id = tickets.hall_seat_id
         left join sessions on sessions.id = tickets.session_id
         left join movies on movies.id = sessions.movie_id;
