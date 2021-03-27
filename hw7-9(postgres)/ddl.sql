CREATE EXTENSION IF NOT EXISTS "uuid-ossp";
DROP TYPE IF EXISTS TICKET_STATUSES;
CREATE type TICKET_STATUSES AS ENUM ('reserved', 'available', 'sold', 'refund');
DROP TYPE IF EXISTS EAV_TYPES;
CREATE type EAV_TYPES AS ENUM ('bool', 'date', 'float', 'text');

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
    CONSTRAINT hall_seats_fk FOREIGN KEY (hall_id) REFERENCES halls (id)
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
    ticket_identifier uuid            default uuid_generate_v4(),
    status            TICKET_STATUSES default 'available',
    created_at        timestamptz     default now(),
    updated_at        timestamptz     default now(),
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
select tickets.id                                                        as ticket_id,
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

create table movie_attributes
(
    id   INT GENERATED ALWAYS AS IDENTITY,
    PRIMARY KEY (id),
    name varchar(255)
);

create table movie_attribute_types
(
    id   INT GENERATED ALWAYS AS IDENTITY,
    PRIMARY KEY (id),
    type EAV_TYPES,
    name varchar(255)
);

create table movie_attribute_values
(
    id                INT GENERATED ALWAYS AS IDENTITY,
    PRIMARY KEY (id),
    movie_id          INT NOT NULL,
    attribute_id      INT NOT NULL,
    attribute_type_id INT NOT NULL,
    value_boolean     bool default false,
    value_float       numeric(10, 2),
    value_date        date,
    value_text        text,
    CONSTRAINT attribute_value_to_movie
        FOREIGN KEY (movie_id)
            REFERENCES movies (id),
    CONSTRAINT attribute_value_to_attribute
        FOREIGN KEY (attribute_id)
            REFERENCES movie_attributes (id),
    CONSTRAINT attribute_value_to_attribute_type
        FOREIGN KEY (attribute_type_id)
            REFERENCES movie_attribute_types (id)
);

CREATE INDEX movie_attribute_values_movie_id_idx ON otus.movie_attribute_values (movie_id);
CREATE INDEX movie_attribute_values_attribute_id_idx ON otus.movie_attribute_values (attribute_id);
CREATE INDEX movie_attribute_values_attribute_type_id_idx ON otus.movie_attribute_values (attribute_type_id);
CREATE INDEX movie_attribute_types_name_idx ON otus.movie_attribute_types ("name");

-- View сборки служебных данных в форме (три колонки):

create view service_data as
select t.name   as task_type,
       a.name   as name,
       (case
            when v.value_boolean and v.value_float is null and v.value_date is null and v.value_text is null
                then 'Присутствует'
            when v.value_date is not null and v.value_float is null and v.value_text is null
                then cast(value_date as text)
            when v.value_date is null and v.value_float is not null and v.value_text is null
                then cast(value_float as text)
            when v.value_date is null and v.value_float is null and v.value_text is not null then value_text
            else null
           end) as value
from movie_attribute_values v
         left join movie_attributes a on a.id = v.attribute_id
         left join movie_attribute_types t on t.id = v.attribute_type_id;

-- фильм, тип атрибута, атрибут, значение (значение выводим как текст)

create view movie_data as
select m.title,
       t.name   as task_type,
       a.name   as name,
       (case
            when v.value_boolean and v.value_float is null and v.value_date is null and v.value_text is null
                then 'Присутствует'
            when v.value_date is not null and v.value_float is null and v.value_text is null
                then cast(value_date as text)
            when v.value_date is null and v.value_float is not null and v.value_text is null
                then cast(value_float as text)
            when v.value_date is null and v.value_float is null and v.value_text is not null then value_text
            else null
           end) as value
from movie_attribute_values v
         left join movie_attributes a on a.id = v.attribute_id
         left join movie_attribute_types t on t.id = v.attribute_type_id
         left join movies m on m.id = v.movie_id;

-- фильм, задачи актуальные на сегодня, задачи актуальные через 20 дней View сборки данных для маркетинга в форме (три колонки):
create view task_data as
with tasks as (
    select (case
                when v.value_date = CURRENT_DATE then v.value_date
                else null
        END)        as actual_tasks,
           (case
                when v.value_date = date(CURRENT_DATE + interval '20' day) then v.value_date
                else null
               END) as actual_in_20_days,
           movie_id
    from movie_attribute_values v
             left join movie_attribute_types t on t.id = v.attribute_type_id
    where t.name = 'Служебные задачи'
)
select m.title, tasks.actual_tasks, actual_in_20_days
from movies m
         left join tasks on m.id = tasks.movie_id;
