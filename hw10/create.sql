CREATE TABLE halls
(
    id SERIAL PRIMARY KEY,
    name VARCHAR(15),
    num_places integer
);

CREATE TABLE places
(
    id SERIAL PRIMARY KEY,
    hall_id integer REFERENCES halls(id),
    num_row integer,
    num_col integer
);

CREATE TABLE customers
(
    id serial primary key,
    name varchar(127),
    phone varchar(10)
);

CREATE TABLE films
(
    id serial primary key,
    name varchar(127),
    duration integer
);

CREATE TABLE sessions
(
    id serial primary key,
    hall_id integer REFERENCES halls(id),
    time_from time,
    time_to time
);

CREATE TABLE offers
(
    id serial primary key,
    session_id integer REFERENCES sessions(id),
    film_id integer REFERENCES films(id),
    price numeric(8,2)
);

CREATE TABLE tickets
(
    id serial primary key,
    offer_id integer REFERENCES offers(id),
    place_id integer REFERENCES places(id),
    customer_id integer REFERENCES customers(id),
    date date
);


-------- EAV films
CREATE TABLE filmsAttrTypes
(
    id serial primary key,
    type varchar(15)
);

CREATE TABLE filmsAttr
(
    id serial primary key,
    attr varchar(128),
    type_id integer REFERENCES filmsAttrTypes(id)
);

CREATE TABLE  filmsAttrValues
(
    id serial primary key,
    film_id integer REFERENCES films(id),
    attr_id integer REFERENCES filmsAttr(id),
    value_str varchar,
    value_date date,
    value_bool boolean,
    value_int integer,
    value_num numeric(10,2)
);
CREATE INDEX films_id_index ON filmsAttrValues(film_id);

CREATE TABLE services
(
    id serial primary key,
    attr_id integer REFERENCES filmsAttr(id),
    priority integer DEFAULT 0
);