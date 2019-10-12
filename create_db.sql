CREATE TABLE IF NOT EXISTS films(
    id serial PRIMARY KEY,
    name VARCHAR (255) NOT NULL
);

CREATE TABLE IF NOT EXISTS halls(
    id serial PRIMARY KEY,
    name VARCHAR (255) NOT NULL
);

CREATE TABLE IF NOT EXISTS sessions(
    id serial PRIMARY KEY,
    film_id INT NOT NULL,
    hall_id INT NOT NULL,
    time TIMESTAMP  NOT NULL,
    FOREIGN KEY (film_id) REFERENCES films (id),
    FOREIGN KEY (hall_id) REFERENCES halls (id)
);

CREATE TABLE IF NOT EXISTS seats(
    id serial PRIMARY KEY,
    hall_id INT NOT NULL,
    row INT NOT NULL,
    number INT NOT NULL,
    FOREIGN KEY (hall_id) REFERENCES halls (id)
);

CREATE TABLE IF NOT EXISTS tickets(
    id serial PRIMARY KEY,
    session_id INT NOT NULL,
    seat_id INT NOT NULL,
    price NUMERIC NOT NULL CHECK (price >0),
    FOREIGN KEY (session_id) REFERENCES sessions (id),
    FOREIGN KEY (seat_id) REFERENCES seats (id),
    UNIQUE (seat_id, session_id)
);

CREATE TABLE IF NOT EXISTS film_attrs_types(
    id serial PRIMARY KEY,
    name VARCHAR (255) NOT NULL
);

CREATE TABLE IF NOT EXISTS films_attrs(
    id serial PRIMARY KEY,
    name VARCHAR (255) NOT NULL,
    type_id INT NOT NULL,
    FOREIGN KEY (type_id) REFERENCES film_attrs_types (id)
);

CREATE TABLE IF NOT EXISTS films_attrs_values(
    id serial PRIMARY KEY,
    film_id INT NOT NULL,
    film_attribute_id INT NOT NULL,
    value_text TEXT,
    value_date DATE,
    value_boolean BOOLEAN,
    FOREIGN KEY (film_id) REFERENCES films (id),
    FOREIGN KEY (film_attribute_id) REFERENCES films_attrs (id)
);

insert into films VALUES(1, 'matrix');
insert into films VALUES(2, 'terminator');

insert into film_attrs_types VALUES(1, 'text');
insert into film_attrs_types VALUES(2, 'boolean');
insert into film_attrs_types VALUES(3, 'date');

insert into films_attrs VALUES(1, 'prize', 1);
insert into films_attrs VALUES(2, 'description', 1);
insert into films_attrs VALUES(3, 'logic', 2);
insert into films_attrs VALUES(4, 'task', 3);

insert into films_attrs_values VALUES(1, 1, 1, 'oscar', null, null);
insert into films_attrs_values VALUES(2, 2, 1, 'emmy', null, null);
insert into films_attrs_values VALUES(3, 1, 2, 'top movie!', null, null);
insert into films_attrs_values VALUES(4, 2, 3, null, null, true);
insert into films_attrs_values VALUES(5, 2, 4, null, '2019-10-11', true);
insert into films_attrs_values VALUES(6, 2, 4, null, '2019-10-31', true);
insert into films_attrs_values VALUES(7, 2, 4, null, '2019-11-11', true);
insert into films_attrs_values VALUES(8, 1, 4, null, '2019-10-11', true);

insert into halls VALUES(1, 'hall1');

insert into seats VALUES(1, 1, 1, 1);
insert into seats VALUES(2, 1, 1, 2);

insert into sessions VALUES(1, 1, 1, '2019-11-11 20:00:00');

/*insert into tickets VALUES (1, 1, 1, 0);*/
/*insert into tickets VALUES (1, 1, 1, 1000);*/
/*insert into tickets VALUES (2, 1, 1, 1000);*/

CREATE INDEX value_date_idx ON films_attrs_values (value_date);

CREATE VIEW marketing AS
SELECT
    films.name as film_name,
    film_attrs_types.name as attribute_type,
    films_attrs_values.value_text as text,
    films_attrs_values.value_date as date,
    films_attrs_values.value_boolean as boolean
FROM films_attrs_values
         JOIN films on films.id = films_attrs_values.film_id
         JOIN films_attrs on films_attrs_values.film_attribute_id = films_attrs.id
         JOIN film_attrs_types on films_attrs.type_id = film_attrs_types.id;


CREATE VIEW tasks AS
SELECT today.film_name, today_tasks, forward_tasks  FROM
    (SELECT
         films.name as film_name,
         films_attrs_values.value_date as today_tasks
     FROM films_attrs_values
              JOIN films on films.id = films_attrs_values.film_id
     WHERE films_attrs_values.value_date = current_date) today
        FULL OUTER JOIN
    (SELECT
         films.name as film_name,
         films_attrs_values.value_date as forward_tasks
     FROM films_attrs_values
              JOIN films on films.id = films_attrs_values.film_id
     WHERE films_attrs_values.value_date = current_date + interval '20 days') forward
    ON today.film_name = forward.film_name;
