CREATE TABLE films (
    id serial NOT NULL,
    "name" text NOT NULL,
    duration int4 NOT NULL,
    CONSTRAINT films_pk PRIMARY KEY (id)
);

CREATE TABLE film_attributes_types (
    id serial NOT NULL,
    "type" varchar NOT NULL,
    CONSTRAINT film_attributes_types_pk PRIMARY KEY (id)
);

CREATE TABLE film_attributes (
    id serial NOT NULL,
    type_id int4 NOT NULL,
    "name" varchar NOT NULL,
    CONSTRAINT film_attributes_pk PRIMARY KEY (id)
);
ALTER TABLE film_attributes ADD CONSTRAINT film_attributes_fk FOREIGN KEY (type_id) REFERENCES film_attributes_types(id);

CREATE TABLE film_attributes_values (
    id serial NOT NULL,
    film_id int4 NOT NULL,
    attribute_id int4 NOT NULL,
    value_numeric numeric NULL,
    value_text text NULL,
    value_timestamp timestamp NULL,
    value_boolean bool NULL,
    CONSTRAINT film_attributes_values_check CHECK (((value_numeric IS NOT NULL) OR (value_text IS NOT NULL) OR (value_timestamp IS NOT NULL) OR (value_boolean IS NOT NULL))),
    CONSTRAINT film_attributes_values_pk PRIMARY KEY (id)
);
CREATE INDEX film_attributes_values_film_id_idx ON film_attributes_values USING btree (film_id);
CREATE INDEX film_attributes_values_value_timestamp_idx ON film_attributes_values USING btree (value_timestamp);

ALTER TABLE film_attributes_values ADD CONSTRAINT film_attributes_values_fk_attributes FOREIGN KEY (attribute_id) REFERENCES film_attributes(id);
ALTER TABLE film_attributes_values ADD CONSTRAINT film_attributes_values_fk_films FOREIGN KEY (film_id) REFERENCES films(id);


CREATE TABLE halls (
    id serial NOT NULL,
    "name" text NOT NULL,
    total_seats int2 NOT NULL,
    total_rows int2 NOT NULL,
    CONSTRAINT halls_pk PRIMARY KEY (id)
);

CREATE TABLE prices (
    id serial NOT NULL,
    price numeric(10,2) NOT NULL,
    CONSTRAINT prices_pk PRIMARY KEY (id)
);

CREATE TABLE seats (
    id serial NOT NULL,
    hall_id int4 NOT NULL,
    "row" int2 NOT NULL,
    "number" int2 NOT NULL,
    CONSTRAINT seats_pk PRIMARY KEY (id)
);
ALTER TABLE seats ADD CONSTRAINT seats_hall_fk FOREIGN KEY (hall_id) REFERENCES halls(id);

CREATE TABLE sessions (
    id serial NOT NULL,
    hall_id int4 NOT NULL,
    film_id int4 NOT NULL,
    start_time timestamp NOT NULL,
    price_id int4 NOT NULL,
    CONSTRAINT sessions_pk PRIMARY KEY (id)
);
ALTER TABLE sessions ADD CONSTRAINT sessions_film_fk FOREIGN KEY (film_id) REFERENCES films(id);
ALTER TABLE sessions ADD CONSTRAINT sessions_hall_fk FOREIGN KEY (hall_id) REFERENCES halls(id);
ALTER TABLE sessions ADD CONSTRAINT sessions_price_fk FOREIGN KEY (price_id) REFERENCES prices(id);

CREATE TABLE tickets (
    id serial NOT NULL,
    session_id int4 NOT NULL,
    seat_id int4 NOT NULL,
    price_id int4 NOT NULL,
    CONSTRAINT tickets_pk PRIMARY KEY (id)
);
ALTER TABLE tickets ADD CONSTRAINT tickets_price_fk FOREIGN KEY (price_id) REFERENCES prices(id);
ALTER TABLE tickets ADD CONSTRAINT tickets_seat_fk FOREIGN KEY (seat_id) REFERENCES seats(id);
ALTER TABLE tickets ADD CONSTRAINT tickets_session_fk FOREIGN KEY (session_id) REFERENCES sessions(id);
ALTER TABLE tickets ADD CONSTRAINT tickets_seat_id_session_id UNIQUE (seat_id, session_id);

/* Marketing view */
CREATE OR REPLACE VIEW films_marketing
AS SELECT films.name,
    film_attributes_types.type,
    film_attributes.name AS attribute,
    concat(film_attributes_values.value_boolean || '',
           film_attributes_values.value_numeric,
           film_attributes_values.value_text,
           film_attributes_values.value_timestamp) AS value
   FROM films
     JOIN film_attributes_values ON films.id = film_attributes_values.film_id
     JOIN film_attributes ON film_attributes_values.attribute_id = film_attributes.id
     JOIN film_attributes_types ON film_attributes.type_id = film_attributes_types.id;


/* Tasks view */
CREATE OR REPLACE VIEW films_tasks
AS SELECT 
    films.name as film_name,
    today_task.task_name as today_task,
    twenty_day_task.task_name as task_after_20_days
FROM
    (SELECT
        films.id AS film_id,
        film_attributes.name AS task_name
    FROM films
        JOIN film_attributes_values ON (films.id = film_attributes_values.film_id)
        JOIN film_attributes ON (film_attributes_values.attribute_id = film_attributes.id)
    WHERE
        film_attributes_values.value_timestamp = current_date + interval '20 days') twenty_day_task
FULL JOIN
    (SELECT
        films.id AS film_id,
        film_attributes.name AS task_name
    FROM films
        JOIN film_attributes_values ON (films.id = film_attributes_values.film_id)
        JOIN film_attributes ON (film_attributes_values.attribute_id = film_attributes.id)
    WHERE
        film_attributes_values.value_timestamp = current_date) today_task
ON today_task.film_id = twenty_day_task.film_id
JOIN films ON (twenty_day_task.film_id = films.id OR today_task.film_id = films.id);